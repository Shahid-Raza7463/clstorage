<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Excel;
use App\Imports\Krasimport;
use App\Models\Designation;
use DB;
use Illuminate\Support\Facades\Log;

class KrasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $designations = Designation::ordered()->get();

        $designationData = [];
        foreach ($designations as $designation) {
            $record = DB::table('krasdata')->where('designation_id', $designation->id)->first();
            $decoded = $record ? json_decode($record->data, true) : [];
            $headings = !empty($decoded) ? array_keys($decoded[0]) : [];
            $key = ucwords(str_replace(' ', '_', $designation->name));

            $designationData[$key] = [
                'data' => $decoded,
                'headings' => $headings,
                'id' => $record?->id ?? null,
            ];
        }
        return view('backEnd.kras.index', compact('designations', 'designationData'));
    }

    // public function edit($id)
    // {
    //     $record = DB::table('krasdata')->where('id', $id)->first();
    //     return view('backEnd.kras.edit', compact('record'));
    // }
    // public function edit($id)
    // {
    //     $record = DB::table('krasdata')->where('id', $id)->first();
    //     $decodedData = $record ? json_decode($record->data, true) : [];

    //     return view('backEnd.kras.edit', compact('record', 'decodedData'));
    // }

    // Show form with full row data
    public function edit($id, $row)
    {
        $record = DB::table('krasdata')->where('id', $id)->first();
        $data = json_decode($record->data, true);

        if (!isset($data[$row])) {
            abort(404, 'Row not found');
        }

        return view('backEnd.kras.edit', [
            'id' => $id,
            'rowIndex' => $row,
            'row' => $data[$row],
        ]);
    }

    public function update(Request $request, $id)
    {
        $rowIndex = $request->input('row_index');
        $record = DB::table('krasdata')->where('id', $id)->first();
        $data = json_decode($record->data, true);

        if (!isset($data[$rowIndex])) {
            abort(404, 'Row not found');
        }

        // Update only the targeted row
        foreach ($request->except(['_token', '_method', 'row_index']) as $column => $value) {
            $data[$rowIndex][$column] = $value;
        }

        DB::table('krasdata')->where('id', $id)->update([
            'data' => json_encode($data),
        ]);

        return redirect()->route('kras.index')->with('success', 'Row updated successfully.');
    }

    public function destroy($id, $row)
    {
        $record = DB::table('krasdata')->where('id', $id)->first();
        $data = json_decode($record->data, true);

        // Remove the specified row
        if (isset($data[$row])) {
            unset($data[$row]);
            // Reindex array after unset
            $data = array_values($data);
        }

        // Save updated data back
        DB::table('krasdata')->where('id', $id)->update([
            'data' => json_encode($data),
        ]);

        return redirect()->route('kras.index')->with('success', 'Row deleted successfully.');
    }





    // public function editColumn($id, $column)
    // {
    //     $record = DB::table('krasdata')->where('id', $id)->first();
    //     $data = json_decode($record->data, true);

    //     // Find first non-null value of that column
    //     $value = collect($data)->pluck($column)->filter()->first();

    //     return view('backEnd.kras.edit', compact('id', 'column', 'value'));
    // }



    // public function krasExcelupload(Request $request)
    // {
    //     try {
    //         $file = $request->file('file');
    //         $data = Excel::toArray(new Krasimport, $file);

    //         $jsonData = json_encode($data[0]);
    //         DB::table('krasdata')->insert([
    //             'createdby' => auth()->user()->teammember_id,
    //             'data' => $jsonData,
    //             'designation_id' => $request->designationid,
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);

    //         $message = 'Excel file uploaded successfully! ';
    //         $output = ['msg' => $message];
    //         return back()->with('statusss', $output);
    //     } catch (Exception $e) {
    //         // Log and handle exceptions
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);
    //         $output = ['msg' => $e->getMessage()];
    //         return back()->withErrors($output)->withInput();
    //     }
    // }

    // public function krasExcelupload(Request $request)
    // {
    //     try {
    //         $file = $request->file('file');
    //         $data = Excel::toArray(new Krasimport, $file);

    //         $filtered = array_filter($data[0], function ($row) {
    //             return array_filter($row);
    //         });

    //         $jsonData = json_encode(array_values($filtered));

    //         DB::table('krasdata')->insert([
    //             'createdby' => auth()->user()->teammember_id,
    //             'data' => $jsonData,
    //             'designation_id' => $request->designationid,
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);

    //         return back()->with('statusss', ['msg' => 'Excel file uploaded successfully!']);
    //     } catch (Exception $e) {
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         return back()->withErrors(['msg' => $e->getMessage()])->withInput();
    //     }
    // }

    public function krasExcelupload(Request $request)
    {
        DB::beginTransaction();

        try {
            $file = $request->file('file');
            $import = new Krasimport();
            Excel::import($import, $file);

            $data = $import->rows->toArray();

            DB::table('krasdata')->insert([
                'createdby' => auth()->user()->teammember_id,
                'data' => json_encode($data),
                'designation_id' => $request->designationid,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();
            return back()->with('statusss', ['msg' => 'Excel file uploaded successfully!']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            report($e);
            return back()->withErrors(['msg' => $e->getMessage()])->withInput();
        }
    }
}

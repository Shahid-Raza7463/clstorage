<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Excel;
use App\imports\Krasimport;
use App\Models\Designation;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        $teammembers = DB::table('teammembers')
            ->where('id', auth()->user()->teammember_id)
            ->select('id', 'team_member', 'designation')
            ->first();

        if (is_null($teammembers?->designation)) {
            abort(403, 'Access denied. Designation is missing.');
        }

        // super admin , hr and  admin
        if ($teammembers->designation == 13 || $teammembers->designation == 1400  || $teammembers->designation ==  1300) {
            $designations = Designation::ordered()
                ->where('name', '!=', 'Super Admin')
                ->get();

            $designationData = [];
            foreach ($designations as $designation) {
                $record = DB::table('krasdata')
                    ->where('designation_id', $designation->id)
                    ->whereNull('krasdata.teamid')
                    ->first();

                $key = ucwords(str_replace(' ', '_', $designation->name));

                $teammemberall = DB::table('teammembers')
                    ->leftJoin('designations', 'designations.id', '=', 'teammembers.designation')
                    ->whereNotNull('teammembers.designation')
                    ->where('teammembers.designation', $designation->id)
                    ->select('teammembers.*', 'designations.name as designation_name')
                    ->get();


                foreach ($teammemberall as $member) {
                    // $hasKra = DB::table('krasteam')
                    //     ->where('teamid', $member->id)
                    //     ->where('krasdata_id', $member->designation)
                    //     ->exists();

                    $hasKra = DB::table('krasteam')
                        ->leftJoin('krasdata', 'krasdata.id', '=', 'krasteam.krasdata_id')
                        ->where('krasteam.teamid', $member->id)
                        ->exists();

                    $member->kra_status = $hasKra ? '1' : '0';
                }

                $hasKras = $teammemberall->contains('kra_status', 0);

                $kratemplates = DB::table('krasdata')
                    ->where('designation_id', $designation->id)
                    ->whereNull('krasdata.teamid')
                    ->get();

                // dd($kratemplates);

                $designationData[$key] = [
                    'teammemberall' => $teammemberall,
                    'hasKras' => $hasKras,
                    'krasid' => $record?->id ?? null,
                    'designationId' => $designation->id ?? null,
                    'kratemplates' => $kratemplates ?? null,
                ];
            }
            return view('backEnd.kras.index', compact('designations', 'designationData', 'teammembers'));
        } else {
            $designations = Designation::where('id', $teammembers->designation)->ordered()->get();
            $id = auth()->user()->teammember_id;

            $designationData = [];
            foreach ($designations as $designation) {

                $record = DB::table('krasdata')
                    ->where('designation_id', $designation->id)
                    ->where('teamid', $id)
                    ->first();

                if (!$record) {
                    $record = DB::table('krasdata')
                        ->join('krasteam', function ($join) use ($designation, $id) {
                            $join->on('krasdata.designation_id', '=', 'krasteam.krasdata_id')
                                ->whereNull('krasdata.teamid');
                        })
                        ->where('krasteam.krasdata_id', $designation->id)
                        ->where('krasteam.teamid', $id)
                        ->select('krasdata.*')
                        ->first();
                }

                $decoded = $record && $record->data ? json_decode($record->data, true) : [];
                $headings = (!empty($decoded) && is_array($decoded)) ? array_keys($decoded[0]) : [];
                $key = ucwords(str_replace(' ', '_', $designation->name));

                $designationData[$key] = [
                    'data' => $decoded,
                    'headings' => $headings,
                    'teamId' => $id,
                    'id' => $record?->id ?? null,
                ];
            }
            return view('backEnd.kras.show', compact('designations', 'designationData', 'teammembers'));
        }
    }

    public function show($id, $designation)
    {
        $teammembers = DB::table('teammembers')
            // ->where('id', $id)
            ->where('id', auth()->user()->teammember_id)
            ->select('id', 'team_member', 'designation')
            ->first();

        if (is_null($teammembers?->designation)) {
            abort(403, 'Access denied. Designation is missing.');
        }

        // dd($id, $designation);

        $designations = Designation::where('id', $designation)->ordered()->get();

        $designationData = [];
        foreach ($designations as $designation) {

            // $record = DB::table('krasdata')
            //     ->where('designation_id', $designation->id)
            //     ->where('teamid', $id)
            //     ->first();



            // if (!$record) {
            //     $record = DB::table('krasdata')
            //         ->join('krasteam', function ($join) use ($designation, $id) {
            //             $join->on('krasdata.designation_id', '=', 'krasteam.krasdata_id')
            //                 ->whereNull('krasdata.teamid');
            //         })
            //         ->where('krasteam.krasdata_id', $designation->id)
            //         ->where('krasteam.teamid', $id)
            //         ->select('krasdata.*')
            //         ->first();
            // }

            $record = DB::table('krasteam')
                ->leftJoin('krasdata', 'krasdata.id', '=', 'krasteam.krasdata_id')
                ->where('krasteam.teamid', $id)
                ->first();

            $decoded = $record && $record->data ? json_decode($record->data, true) : [];
            $headings = (!empty($decoded) && is_array($decoded)) ? array_keys($decoded[0]) : [];
            $key = ucwords(str_replace(' ', '_', $designation->name));

            // dd($decoded, $headings, $record->id, $id);
            $designationData[$key] = [
                'data' => $decoded,
                'headings' => $headings,
                'teamId' => $id,
                'id' => $record?->id ?? null,
            ];
        }
        return view('backEnd.kras.show', compact('designations', 'designationData', 'teammembers'));
    }

    public function deleteteamwiseKra($id, $designation)
    {
        try {

            $deletedKrasData = DB::table('krasdata')
                ->where('designation_id', $designation)
                ->where('teamid', $id)
                ->delete();

            $deletedKrasTeam = DB::table('krasteam')
                ->where('teamid', $id)
                ->delete();

            if ($deletedKrasData || $deletedKrasTeam) {
                $this->sendNotificationteamwise($id);
                return back()->with('statuss', ['msg' => 'KRAs deleted successfully!']);
            } else {
                return back()->with('statuss', ['msg' => 'No KRA records found to delete.']);
            }
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            report($e);
            return back()->withErrors(['msg' => 'Error: ' . $e->getMessage()])->withInput();
        }
    }


    public function modifyColumn(Request $request)
    {

        $oldKey = Str::snake(trim($request->input('oldcolumnName')));
        $newKey = Str::snake(trim($request->input('newcolumnName')));
        $id = $request->input('kraId1');
        $teamId = $request->input('teamId');

        $record = DB::table('krasdata')->where('id', $id)->first();
        $data = json_decode($record->data, true);


        foreach ($data as &$item) {
            if (array_key_exists($oldKey, $item)) {
                $newItem = [];

                foreach ($item as $key => $value) {
                    if ($key === $oldKey) {
                        $newItem[$newKey] = $value;
                    } else {
                        $newItem[$key] = $value;
                    }
                }
                $item = $newItem;
            }
        }

        $checkRecord = DB::table('krasdata')
            ->where('designation_id', $record->designation_id)
            ->where('teamid', $teamId)
            ->first();;


        if ($checkRecord) {
            DB::table('krasdata')
                ->where('id', $id)
                ->update([
                    'data' => json_encode($data),
                ]);
        } else {
            $krasdata_id = DB::table('krasdata')->insertGetId([
                'createdby' => auth()->user()->teammember_id,
                'data' => json_encode($data),
                'designation_id' => $record->designation_id,
                'teamid' => $teamId,
                'year' => now()->year,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('krasteam')->where('teamid', $teamId)->update([
                'krasdata_id' => $krasdata_id,
            ]);
        }


        // DB::table('krasdata')
        //     ->where('id', $id)
        //     ->update([
        //         'data' => json_encode($data),
        //     ]);

        $this->sendNotificationteamwise($teamId);

        return redirect()->route('kras.show', ['id' => $teamId, 'designation' => $record->designation_id])
            ->with('success', 'Column renamed successfully.');
    }

    public function deleteColumn(Request $request)
    {
        $columnKey = Str::snake(trim($request->input('columnnameDelete')));
        $id = $request->input('kraId2');
        $teamId = $request->input('teamId');

        $record = DB::table('krasdata')->where('id', $id)->first();
        $data = json_decode($record->data, true);
        foreach ($data as &$item) {
            if (array_key_exists($columnKey, $item)) {
                $newItem = [];
                foreach ($item as $key => $value) {
                    if ($key !== $columnKey) {
                        $newItem[$key] = $value;
                    }
                }
                $item = $newItem;
            }
        }

        $checkRecord = DB::table('krasdata')
            ->where('designation_id', $record->designation_id)
            ->where('teamid', $teamId)
            ->first();;


        if ($checkRecord) {
            DB::table('krasdata')
                ->where('id', $id)
                ->update([
                    'data' => json_encode($data),
                ]);
        } else {
            $krasdata_id = DB::table('krasdata')->insertGetId([
                'createdby' => auth()->user()->teammember_id,
                'data' => json_encode($data),
                'designation_id' => $record->designation_id,
                'teamid' => $teamId,
                'year' => now()->year,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('krasteam')->where('teamid', $teamId)->update([
                'krasdata_id' => $krasdata_id,
            ]);
        }


        // DB::table('krasdata')
        //     ->where('id', $id)
        //     ->update([
        //         'data' => json_encode($data),
        //     ]);

        $this->sendNotificationteamwise($teamId);

        return redirect()->route('kras.show', ['id' => $teamId, 'designation' => $record->designation_id])
            ->with('success', 'Column deleted successfully.');
    }

    public function addColumn(Request $request)
    {
        $columnKey = Str::snake(trim($request->input('columnnameAdd')));
        $columnValue = $request->input('columnnameaddValue') ?? null;
        $id = $request->input('kraId3');
        $teamId = $request->input('teamId');

        // $updateData = $request->except(['_token', '_method', 'row_index', 'teamid']);

        $record = DB::table('krasdata')->where('id', $id)->first();
        $data = json_decode($record->data, true);

        foreach ($data as &$item) {
            if (!array_key_exists($columnKey, $item)) {
                $item[$columnKey] = $columnValue;
            }
        }

        $checkRecord = DB::table('krasdata')
            ->where('designation_id', $record->designation_id)
            ->where('teamid', $teamId)
            ->first();;


        // dd($checkRecord);
        if ($checkRecord) {
            DB::table('krasdata')
                ->where('id', $id)
                ->update([
                    'data' => json_encode($data),
                ]);
        } else {

            $krasdata_id = DB::table('krasdata')->insertGetId([
                'createdby' => auth()->user()->teammember_id,
                'data' => json_encode($data),
                'designation_id' => $record->designation_id,
                'teamid' => $teamId,
                'year' => now()->year,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('krasteam')->where('teamid', $teamId)->update([
                'krasdata_id' => $krasdata_id,
            ]);
        }

        // DB::table('krasdata')
        //     ->where('id', $id)
        //     ->update([
        //         'data' => json_encode($data),
        //     ]);

        $this->sendNotificationteamwise($teamId);

        return redirect()->route('kras.show', ['id' => $teamId, 'designation' => $record->designation_id])
            ->with('success', 'Column added successfully.');
    }




    public function krasExcelupload(Request $request)
    {
        try {
            $file = $request->file('file');
            $import = new Krasimport();
            Excel::import($import, $file);

            $data = $import->rows->toArray();

            // // Notification send only for edit kras
            // $recordscheck = DB::table('krasdata')->where('designation_id', $request->designationid);
            // if ($recordscheck->exists()) {
            //     $recordscheck->delete();
            //     $designations = Designation::where('id', $request->designationid)->ordered()->first();
            //     $teammembers = DB::table('teammembers')
            //         ->where('designation', $designations->id)
            //         ->get();

            //     foreach ($teammembers as $member) {
            //         $maildata = array(
            //             'designations' => $designations ?? '',
            //             'created_at' => date('d-m-Y H:i:s'),
            //             'email' => $member->emailid ?? '',
            //         );

            //         Mail::send('emails.krasnodified', $maildata, function ($msg) use ($maildata) {
            //             $msg->to($maildata['email']);
            //             $msg->cc('shahidraza7463@gmail.com');
            //             $msg->subject('KRAs modified');
            //         });
            //     }
            // }
            // // Notification send only for edit kras end hare 
            DB::table('krasdata')->insert([
                'createdby' => auth()->user()->teammember_id,
                'data' => json_encode($data),
                'designation_id' => $request->designationid,
                'year' => now()->year,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return back()->with('statusss', ['msg' => 'Excel file uploaded successfully!']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            report($e);
            return back()->withErrors(['msg' => $e->getMessage()])->withInput();
        }
    }


    public function krasExceluploadteamwise(Request $request)
    {
        DB::beginTransaction();

        try {
            // dd($request);
            $kratemplatesId = $request->kratemplatesId;
            $teamids = $request->teamids;
            $designationids = $request->designationids;
            $templatename = $request->input('templatename', null);
            $data = [];

            if ($request->hasFile('file')) {
                $import = new Krasimport();
                Excel::import($import, $request->file('file'));
                $data = $import->rows->toArray();
            }

            $krasdata_id = null;

            if ($templatename && !$kratemplatesId) {
                $krasdata_id = DB::table('krasdata')->insertGetId([
                    'createdby'      => auth()->user()->teammember_id,
                    'data'           => json_encode($data),
                    'designation_id' => $designationids,
                    'template_name'  => $templatename,
                    'year'           => now()->year,
                    'created_at'     => now(),
                    'updated_at'     => now()
                ]);
            } elseif (!$templatename && !$kratemplatesId) {
                $krasdata_id = DB::table('krasdata')->insertGetId([
                    'createdby'      => auth()->user()->teammember_id,
                    'data'           => json_encode($data),
                    'designation_id' => $designationids,
                    'teamid'         => $teamids,
                    'year'           => now()->year,
                    'created_at'     => now(),
                    'updated_at'     => now()
                ]);
            } else {
                $krasdata_id = $kratemplatesId;
            }

            if ($krasdata_id) {
                DB::table('krasteam')->insert([
                    'teamid'           => $teamids,
                    'krasdata_id'  => $krasdata_id,
                    'created_at'       => now(),
                    'updated_at'       => now()
                ]);
            }

            DB::commit();
            return back()->with('statusss', ['msg' => 'Created successfully!']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File: {$e->getFile()} Line: {$e->getLine()} Message: {$e->getMessage()}");
            report($e);
            return back()->withErrors(['msg' => 'Something went wrong: ' . $e->getMessage()])->withInput();
        }
    }


    public function exceluploadBulk(Request $request)
    {
        try {
            $kratemplatesId1 = $request->kratemplatesId1;
            $designationids = $request->designationids;
            $selectedItemsJSON = $request->selected_items;
            $selectedTeams = json_decode($selectedItemsJSON);
            $templatename1 = $request->input('templatename1', null);
            $data = [];

            if ($request->hasFile('file')) {
                $import = new Krasimport();
                Excel::import($import, $request->file('file'));
                $data = $import->rows->toArray();
            }

            if ($templatename1 && !$kratemplatesId1) {
                $krasdata_id = DB::table('krasdata')->insertGetId([
                    'createdby' => auth()->user()->teammember_id,
                    'data' => json_encode($data),
                    'designation_id' => $designationids,
                    'template_name' => $templatename1,
                    'year' => now()->year,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                foreach ($selectedTeams as $selectedTeam) {
                    DB::table('krasteam')->insert([
                        'teamid' => $selectedTeam,
                        'krasdata_id' => $krasdata_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            } elseif (!$templatename1 && !$kratemplatesId1) {
                foreach ($selectedTeams as $selectedTeam) {
                    $krasdata_id = DB::table('krasdata')->insertGetId([
                        'createdby' => auth()->user()->teammember_id,
                        'data' => json_encode($data),
                        'designation_id' => $designationids,
                        'teamid' => $selectedTeam,
                        'year' => now()->year,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    DB::table('krasteam')->insert([
                        'teamid' => $selectedTeam,
                        'krasdata_id' => $krasdata_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            } elseif (!$templatename1 && $kratemplatesId1) {
                foreach ($selectedTeams as $selectedTeam) {
                    DB::table('krasteam')->insert([
                        'teamid' => $selectedTeam,
                        'krasdata_id' => $kratemplatesId1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            return back()->with('statusss', ['msg' => 'Created successfully!']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            report($e);
            return back()->withErrors(['msg' => $e->getMessage()])->withInput();
        }
    }

    public function edit($dataId, $datarow, $teamId)
    {
        $record = DB::table('krasdata')->where('id', $dataId)->first();
        $data = json_decode($record->data, true);

        $editableData = $data[$datarow];
        return view('backEnd.kras.edit', [
            'id' => $dataId,
            'rowIndex' => $datarow,
            'row' => $editableData,
            'teamId' => $teamId,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rowIndex = $request->input('row_index');
        $teamid = $request->input('teamid');
        $record = DB::table('krasdata')->where('id', $id)->first();
        $data = json_decode($record->data, true);
        $updateData = $request->except(['_token', '_method', 'row_index', 'teamid']);


        // Update only the targeted row
        foreach ($updateData as $column => $value) {
            $data[$rowIndex][$column] = $value;
        }

        $checkRecord = DB::table('krasdata')
            ->where('designation_id', $record->designation_id)
            ->where('teamid', $teamid)
            ->first();;



        if ($checkRecord) {
            DB::table('krasdata')->where('id', $id)->update([
                'data' => json_encode($data),
            ]);
        } else {
            $krasdata_id = DB::table('krasdata')->insertGetId([
                'createdby' => auth()->user()->teammember_id,
                'data' => json_encode($data),
                'designation_id' => $record->designation_id,
                'teamid' => $teamid,
                'year' => now()->year,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('krasteam')->where('teamid', $teamid)->update([
                'krasdata_id' => $krasdata_id,
            ]);
        }

        $this->sendNotificationteamwise($teamid);

        return redirect()->route('kras.show', ['id' => $teamid, 'designation' => $record->designation_id])
            ->with('success', 'Data updated successfully.');
    }


    public function destroy($dataId, $datarow, $teamId)
    {
        $record = DB::table('krasdata')->where('id', $dataId)->first();
        $data = json_decode($record->data, true);

        if (isset($data[$datarow])) {
            unset($data[$datarow]);
            // Reindex array after unset
            $data = array_values($data);
        }


        $checkRecord = DB::table('krasdata')
            ->where('designation_id', $record->designation_id)
            ->where('teamid', $teamId)
            ->first();;


        if ($checkRecord) {
            DB::table('krasdata')->where('id', $dataId)->update([
                'data' => json_encode($data),
            ]);
        } else {

            $krasdata_id =  DB::table('krasdata')->insertGetId([
                'createdby' => auth()->user()->teammember_id,
                'data' => json_encode($data),
                'designation_id' => $record->designation_id,
                'teamid' => $teamId,
                'year' => now()->year,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('krasteam')->where('teamid', $teamId)->update([
                'krasdata_id' => $krasdata_id,
            ]);
        }

        // DB::table('krasdata')->where('id', $dataId)->update([
        //     'data' => json_encode($data),
        // ]);

        $this->sendNotificationteamwise($teamId);

        return redirect()->route('kras.show', ['id' => $teamId, 'designation' => $record->designation_id])
            ->with('success', 'Data deleted successfully.');
    }


    public function krasTypeDelete(Request $request)
    {
        try {
            $records = DB::table('krasdata')->where('designation_id', $request->designationid);
            if ($records->exists()) {
                $records->delete();
                return back()->with('statuss', ['msg' => 'KRAs deleted successfully!']);
            } else {
                return back()->with('statuss', ['msg' => 'KRAs not exist ']);
            }
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            report($e);
            return back()->withErrors(['msg' => $e->getMessage()])->withInput();
        }
    }

    function sendNotificationteamwise($teamid)
    {
        $teammember  = DB::table('teammembers')
            ->where('id', $teamid)
            ->first();

        if ($teammember && !empty($teammember->emailid)) {
            $mailData = [
                'teammembers' => $teammember,
                'created_at' => now()->format('d-m-Y H:i:s'),
            ];

            Mail::send('emails.krasteamnotification', $mailData, function ($msg) use ($teammember) {
                $msg->to($teammember->emailid)->subject('KRAs Updated');
            });
        }

        if ($teammember && $teammember->role_id == 13) {
            $partners = DB::table('teammembers')
                ->whereIn('id', [156, 171])
                ->get();
        } else {
            $partners = DB::table('teammembers')
                ->where('role_id', 13)
                ->where('status', 1)
                ->get();
        }

        foreach ($partners as $partner) {
            if (!empty($partner->emailid)) {
                $partnerMailData = [
                    'partner' => $partner,
                    'created_at' => now()->format('d-m-Y H:i:s'),
                ];

                Mail::send('emails.krapartnernotification', $partnerMailData, function ($msg) use ($partner) {
                    $msg->to($partner->emailid)->subject('KRAs Updated');
                });
            }
        }
    }
}

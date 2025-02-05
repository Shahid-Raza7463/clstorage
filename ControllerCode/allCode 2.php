<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Allcode extends Controller
{
    // -----------------------------30-12-2024------------------------------------------
    public function store(Request $request)
    {
        //* regarding 
        // Start Hare
        //! End hare 


        //* regarding 
        // Start Hare
        //! End hare 


        //* regarding 
        // Start Hare
        //! End hare 



        //* regarding 
        // Start Hare
        //! End hare 

        //* regarding 
        // Start Hare
        //! End hare 


        //* regarding 
        // Start Hare
        //! End hare 


        //* regarding 
        // Start Hare
        //! End hare 



        //* regarding 
        // Start Hare
        //! End hare 


        //* regarding 
        // Start Hare
        //! End hare 


        //* regarding 
        // Start Hare
        //! End hare 


        //* regarding  file upload
        // Start Hare
        public function timesheetrequestupdate(Request $request)
        {
          try {
            $request->validate([
              'reason' => 'required',
              'file' => 'nullable|mimes:png,pdf,jpeg,jpg|max:5120',
            ], [
              'file.max' => 'The file may not be greater than 5 MB.',
            ]);
      
            $fileName =  $request->attachmentexist ?? null;
            if ($request->hasFile('file')) {
              // public\backEnd\image\confirmationfile
              $destinationPath = public_path('backEnd/image/confirmationfile');
              // Delete the existing file if it exists
              if ($request->attachmentexist) {
                $existingFilePath = $destinationPath . '/' . $request->attachmentexist;
                if (file_exists($existingFilePath)) {
                  unlink($existingFilePath);
                }
              }
              // Process the new file upload
              $file = $request->file('file');
              $fileName = $file->getClientOriginalName();
              $file->move($destinationPath, $fileName);
            }
      
            DB::table('timesheetrequests')
              ->where('id', $request->timesheetrequestid)
              ->update([
                'reason' => $request->reason,
                'partner' => $request->approver,
                'attachment' => $fileName,
                'updated_at' => date('Y-m-d H:i:s'),
              ]);
      
            $output = array('msg' => 'Updated Successfully');
            return back()->with('success', $output);
          } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
          }
        }
        //! End hare 



        //* regarding action column 
        // Start Hare
        public function timesheetrequestform(Request $request, $id)
        {
      
          $timesheetrequestedit = DB::table('timesheetrequests')
            ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
            ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
            ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
            ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
            ->where('timesheetrequests.id', $id)
            ->select(
              'timesheetrequests.*',
              'clients.client_name',
              'clients.client_code',
              'assignments.assignment_name',
              'teammembers.team_member',
              'teammembers.staffcode',
              'createdby.team_member as createdbyauth',
              'createdby.staffcode as staffcodeid',
            )
            ->first();
      
          $hasopenRequests = ($timesheetrequestedit && $timesheetrequestedit->status == 0);
      
          dd($hasopenRequests);
      
          $partner = DB::table('teammembers')
            ->whereNotIn('id', [887, 663, 841, 836, 843, 447])
            ->where('role_id', '=', 13)
            ->where('status', '=', 1)
            ->select('id', 'team_member', 'staffcode')
            ->orderBy('team_member', 'asc')
            // ->distinct()
            ->get();
      
          return view('backEnd.timesheet.timesheetrequestedit', compact('timesheetrequestedit', 'partner'));
        }
        // Start Hare
        public function timesheetrequestform(Request $request, $id)
        {
      
          $timesheetrequestedit = DB::table('timesheetrequests')
            ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
            ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
            ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
            ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
            ->where('timesheetrequests.id', $id)
            ->select(
              'timesheetrequests.*',
              'clients.client_name',
              'clients.client_code',
              'assignments.assignment_name',
              'teammembers.team_member',
              'teammembers.staffcode',
              'createdby.team_member as createdbyauth',
              'createdby.staffcode as staffcodeid',
            )
            ->get();

            $hasopenRequests = $timesheetrequestedit->contains('status', 0);
      
            dd($hasopenRequests);
      
          $partner = DB::table('teammembers')
            ->whereNotIn('id', [887, 663, 841, 836, 843, 447])
            ->where('role_id', '=', 13)
            ->where('status', '=', 1)
            ->select('id', 'team_member', 'staffcode')
            ->orderBy('team_member', 'asc')
            // ->distinct()
            ->get();
      
      
          return view('backEnd.timesheet.timesheetrequestedit', compact('timesheetrequestedit', 'partner'));
        }
        //! End hare 


        //* regarding file and  folder download
        // Start Hare
    //     <li>
    //     <strong>Download55:</strong>
    //     <a href="{{ url('img/' . 'creater.xlsx') }}" class="btn btn-success">Download2</a>
    // </li>
        Route::get('img/{name}', [ContactUsWebController::class, 'download']);

public function download(Request $request, $name)
{
    $path = public_path('assets/img/' . $name);
    if (!file_exists($path)) {
        abort(404, 'File not found.');
    }
    return response()->download($path);
}
        // Start Hare
        //! End hare 


        //* regarding date
        // Start Hare
        $to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');
        $from = Carbon::createFromFormat('Y-m-d', $request->from);
        // Calculate the total number of days (inclusive of both start and end dates)
        $totaldayscount = $to->diffInDays($from) + 1;
        if ($totaldayscount > 10) {
            return back()->with('statuss', ['msg' => 'You cannot apply casual leave for more than 10 days']);
        }
        dd('hi');
        // Start Hare
        //! End hare 


        //* regarding 
        // Start Hare
        Route::get('/download-balance-confirmation', function () {
            $filePath = public_path('backEnd/balanceconfirmation.xlsx');
            $fileName = 'balanceconfirmation.xlsx';
            return response()->download($filePath, $fileName);
        })->name('download.balanceconfirmation');

        //         <div class="col-sm-9">
        //     <a href="{{ route('download.balanceconfirmation') }}" class="btn btn-success">
        //         Download <i class="fas fa-file-excel" style="margin-left: 3px; font-size: 20px;"></i>
        //     </a>
        // </div>

        // Start Hare

        // public function getFiles($file)
        // {

        //     $path = storage_path('/app/kgsomani/' . $file);
        //     return response()->download($path);
        // }
        // Start Hare
        //     Route::get('/download-image', function () {
        //         $filePath = public_path('img/logo.png');
        //         $fileName = 'logo.png';
        //         return response()->download($filePath, $fileName);
        //     })->name('download.image');

        //     <li>
        //     <strong>Download:</strong>
        //     <a href="{{ route('download.image') }}" class="btn btn-success">Download</a>
        // </li>

        // dd(public_path('img/logo.png'));



        // return response()->streamDownload(function () {
        //     echo file_get_contents(public_path('img/logo.png'));
        // }, 'logo.png');


        // Steps to Use the chmod Command
        // 1.	Access Your Server
        // o	If you're using a local development environment (e.g., XAMPP, WAMP):
        // 	Open your terminal or command prompt.
        // 	Navigate to your project directory.
        // o	If you're on a remote server (e.g., hosting provider like InfinityFree or cPanel):
        // 	Use an SSH client like PuTTY or connect to your server via the terminal.
        // 	Navigate to your project directory.
        // 2.	Navigate to Your Laravel Project Use the cd command to move to your project directory. For example:
        // bash
        // CopyEdit
        // cd /var/www/html/your_project_name
        // 3.	Run the Command Execute the following command to set directory permissions:
        // bash
        // CopyEdit
        // chmod 755 public/backEnd
        // o	If you need to apply this to a specific file, use:
        // bash
        // CopyEdit
        // chmod 644 public/backEnd/balanceconfirmation.xlsx
        // 4.	Verify Permissions To confirm the permissions have been applied, run:
        // bash
        // CopyEdit
        // ls -l public/backEnd
        // You should see something like:
        // kotlin
        // CopyEdit
        // -rw-r--r-- 1 www-data www-data 12345 Jan 15 15:00 balanceconfirmation.xlsx
        // ________________________________________
        // If You're Using a File Manager
        // If your hosting provider doesn't allow terminal access:
        // 1.	Open the File Manager in cPanel or your hosting dashboard.
        // 2.	Navigate to the public/backEnd/ folder or the balanceconfirmation.xlsx file.
        // 3.	Right-click the folder/file and choose Permissions or Change Permissions.
        // 4.	Set the permissions to:
        // o	Folder: 755 (Read, Write, and Execute for the Owner, Read and Execute for others).
        // o	File: 644 (Read and Write for the Owner, Read for others).
        // ________________________________________
        // After doing this, the file should be accessible for download. Let me know if you encounter any issues!


        // Start Hare
        if ($request->totalhour) {
            // Check if the format is exactly two digits (e.g., "00")
            if (!preg_match('/^\d{1,2}$/', $request->totalhour)) {
                $output = array('msg' => 'The total hours must be in the format 00.');
                dd($output);
                return back()->with('success', $output);
            }
        }
        dd('hi');
        //! End hare 

        //* regarding year
        // Start Hare
        // Start Hare

        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        $previousYear = $currentDate->copy()->subYear(1)->year;  // Use copy to avoid modifying $currentDate

        $updatedRows = DB::table('leavetypes')
            ->where('year', $previousYear)
            ->update([
                'year' =>  $currentYear,
                'startdate' =>  "$previousYear-04-01",
                'enddate' => "$currentYear-03-31"
            ]);

        dd($previousYear, $currentYear);  // Dumps the previous and current year

        // Start Hare
        $currentYear = date('Y');  // Get the current year using PHP's date function
        $previousYear = $currentYear - 1;  // Manually calculate the previous year

        $updatedRows = DB::table('leavetypes')
            ->where('year', $previousYear)
            ->update([
                'year' => $currentYear,
                'startdate' => "$previousYear-04-01",
                'enddate' => "$currentYear-03-31"
            ]);

        dd($previousYear, $currentYear);  // Dumps the previous and current year


        //! End hare 
    }

    // -----------------------------30-12-2024------------------------------------------
}

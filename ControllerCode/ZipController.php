<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use ZipArchive;

class ZipController extends Controller
{
    //*  Route::get('/zip', [ZipController::class, 'download']);

    // this code download any folder from public folder 
    public function download()
    {
        $zip = new ZipArchive();
        $file_name = 'zip_name.zip';

        if ($zip->open(public_path($file_name), ZipArchive::CREATE) == true) {
            $files = File::files(public_path('file'));
            if (count($files) > 0) {
                foreach ($files as $key => $value) {
                    $relativeName = basename($value);
                    $zip->addFile($value, $relativeName);
                }
                $zip->close();
                return response()->download(public_path($file_name));
                // return response()->download(public_path($file_name))->deleteFileAfterSend(true);
            }
        }
    }

    // this code download any file from storage folder in laravel 

    // public function download()
    // {
    //     $zip = new ZipArchive();
    //     $file_name = 'shahid.zip';

    //     if ($zip->open(storage_path($file_name), ZipArchive::CREATE) == true) {
    //         // Adjust the path to your storage folder
    //         $files = File::files(storage_path('app\public\image\task'));
    //         if (count($files) > 0) {
    //             foreach ($files as $key => $value) {
    //                 $relativeName = basename($value);
    //                 $zip->addFile($value, $relativeName);
    //             }
    //             $zip->close();
    //             return response()->download(storage_path($file_name));
    // return response()->download(storage_path($file_name))->deleteFileAfterSend(true);
    //         }
    //     }
    // }

    // this code download any folder from public folder filtering from database 
    public function zipfile(Request $request, $assignmentfolder_id)
    {
        // used in app\Http\Controllers\AssignmentfolderfileController.php

        $articlefiles = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();

        $zipFileName = 'mannat.zip';
        $zip = new ZipArchive;

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($articlefiles as $file) {
                $filePath = public_path('backEnd/image/articlefiles/' . $file->filesname);
                if (File::exists($filePath)) {
                    $zip->addFile($filePath, $file->filesname);
                }
            }
            $zip->close();
        }

        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }

    // this code download any folder from storage folder filtering from database 
    public function zipfile(Request $request, $assignmentfolder_id)
    {
        // dd($assignmentfolder_id);

        // $userId = auth()->user()->id;
        $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();

        $zipFileName = 'mannat.zip';
        $zip = new ZipArchive;

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($fileName as $file) {
                // file path
                $filePath = storage_path('image/task/' . $file->filesname);
                if (File::exists($filePath)) {
                    $zip->addFile($filePath, $file->filesname);
                }
            }
            $zip->close();
        }
        // public\backEnd\image\articlefiles
        //  storage\image\task
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }
}

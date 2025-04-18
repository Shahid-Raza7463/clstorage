<?php

namespace App\Http\Controllers;

use App\Models\Assignmentfolderfile;
use ZipArchive;
// use File;
use App\Jobs\CreateAllzip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use ZipStream\Option\Archive;
use ZipStream\Option\File;
use STS\ZipStream\ZipStreamFacade as ZipStreamcreate;
use ZipStream\ZipStream;
use ZipStream\Option\Archive as ZipOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AssignmentfolderfileController extends Controller
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

    // single filedownlaod
    public function assignmentfileDownload($id, Request $request)
    {
        $foldername = DB::table('assignmentfolderfiles')->where('id', $id)->first();
        $filePath = $foldername->assignmentgenerateid . '/' . $foldername->filesname;
        // vsalocal
        $filePath = storage_path('app/public/image/task/' . $foldername->filesname);
        if (!file_exists($filePath)) {
            return back()->with('error', 'File does not exist on local storage.');
        }
        return response()->download($filePath, $foldername->realname);
        // vsalocal end 
        // vsalive
        // return Storage::disk('s3')->download($filePath, $foldername->realname);
        // vsalive end 
    }
    // All asignment folder download in the zip formate 
    public function zipfolderdownload(Request $request, $assignmentgenerateid)
    {
        // Get All folder data and folder name 
        $assignmentfoldername = DB::table('assignmentfolders')
            ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
            ->where('assignmentfolders.assignmentgenerateid', $assignmentgenerateid)
            ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname')
            ->get();

        // Set Downloaded folder name 
        $parentZipFileName = $assignmentgenerateid . '.zip';
        $parentZip = new ZipArchive;

        // Open parent zip
        if ($parentZip->open($parentZipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($assignmentfoldername as $foldername) {
                $folderZipFileName = $foldername->assignmentfoldersname . '.zip';
                $zip = new ZipArchive;

                // Open Child zip
                if ($zip->open($folderZipFileName, ZipArchive::CREATE) === TRUE) {
                    if ($foldername->filesname != null) {
                        // Replace server path hare 
                        // vsalocal
                        $filePath = storage_path('app/public/image/task/' . $foldername->filesname);
                        // vsalive
                        // $filePath = Storage::disk('s3')->get($assignmentgenerateid . '/' . $foldername->filesname);
                    }
                    if ($filePath) {
                        $zip->addFromString($foldername->filesname, $filePath);
                    } else {
                        return '<h1>File Not Found</h1>';
                    }
                    $zip->close();
                    $parentZip->addFile($folderZipFileName, $foldername->assignmentfoldersname . '/' . $foldername->filesname);
                }
            }

            $parentZip->close();
        }
        // dd($parentZipFileName);
        // Download the parent zip file
        return response()->download($parentZipFileName)->deleteFileAfterSend(true);
    }

    // zip download 
    public function zipfile(Request $request, $assignmentfolder_id)
    {
        if (auth()->user()->role_id == 11) {
            $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
            $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();

            // dd($fileName);
            $zipFileName = $generateid->assignmentfoldersname . '.zip';
            $zip = new ZipArchive;

            if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                foreach ($fileName as $file) {
                    // vsalocal
                    $filePath = storage_path('app/public/image/task/' . $file->filesname);
                    // vsalocal end 
                    // vsalive
                    // $filePath = Storage::disk('s3')->temporaryUrl(
                    //     $generateid->assignmentgenerateid . '/' . $file->filesname,
                    //     now()->addMinutes(10)
                    // );
                    // vsalive end 
                    $fileContents = file_get_contents($filePath);

                    if ($fileContents !== false) {
                        $zip->addFromString($file->realname, $fileContents);
                    } else {
                        return '<h1>File Not Found</h1>';
                    }
                }
                $zip->close();

                $headers = [
                    'Content-Type' => 'application/zip',
                    'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
                ];

                return response()->stream(
                    function () use ($zipFileName) {
                        readfile($zipFileName);
                        unlink($zipFileName);
                    },
                    200,
                    $headers
                );
            } else {
                return '<h1>Failed to create zip file</h1>';
            }
        } else {
            $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
            $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();

            $zipFileName = $generateid->assignmentfoldersname . '.zip';
            $zip = new ZipArchive;

            if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
                foreach ($fileName as $file) {
                    // vsalocal
                    $filePath = storage_path('app/public/image/task/' . $file->filesname);
                    // vsalocal end 

                    // vsalive
                    // $filePath = Storage::disk('s3')->temporaryUrl(
                    //     $generateid->assignmentgenerateid . '/' . $file->filesname,
                    //     now()->addMinutes(10)
                    // );
                    // vsalive end 
                    $fileContents = file_get_contents($filePath);

                    if ($fileContents !== false) {
                        $zip->addFromString($file->realname, $fileContents);
                    } else {
                        return '<h1>File Not Found</h1>';
                    }
                }
                $zip->close();

                return response()->download($zipFileName)->deleteFileAfterSend(true);
            } else {
                return '<h1>Failed to create zip file</h1>';
            }
        }
    }



    // new download all zip file code 
    public function assignmentfoldercreate(Request $request, $assignmentgenerateid)
    {
        return view('backEnd.assignmentfolder.zipcreatedwaiting', compact('assignmentgenerateid'));
    }

    public function createdzipdownload(Request $request, $assignmentgenerateid)
    {
        // zip file is stored
        $zipFilePath =  storage_path('app/public/image/task/') . $assignmentgenerateid . '.zip';

        // Check if the zip file exists
        if (file_exists($zipFilePath)) {
            // Set the appropriate headers for a downloadable file
            $headers = [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="' . $assignmentgenerateid . '.zip"',
            ];

            // Return the response for download and delete the file after sending
            return response()->download($zipFilePath, $assignmentgenerateid . '.zip', $headers)->deleteFileAfterSend(true);
        } else {
            // If the zip file does not exist, return a response indicating the file is not found
            // return response()->json(['error' => 'File not found'], 404);
            $message = 'You have already downloaded zip file';
            return view('backEnd.assignmentfolder.zipcreatedwaiting', compact('message', 'assignmentgenerateid'));
        }
    }





    // for vsalive
    // public function createzipfolder(Request $request)
    // {
    //     $assignmentfoldername = DB::table('assignmentfolders')
    //         ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
    //         ->where('assignmentfolders.assignmentgenerateid', $request->assignmentgenerateid)
    //         ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname', 'assignmentfolderfiles.realname')
    //         ->get();
    //     // dd($assignmentfoldername);
    //     $data = array(
    //         'assignmentfoldername' => $assignmentfoldername ?? '',
    //         'assignmentgenerateid'   => $request->assignmentgenerateid,
    //     );

    //     CreateAllzip::dispatch($data)->onQueue('CreateZip');
    // }



    // for vsalocal
    // public function createzipfolder(Request $request)
    // {
    //     $assignmentfoldername = DB::table('assignmentfolders')
    //         ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
    //         ->where('assignmentfolders.assignmentgenerateid', $request->assignmentgenerateid)
    //         ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname', 'assignmentfolderfiles.realname')
    //         ->get();

    //     // Prepare data
    //     $data = [
    //         'assignmentfoldername' => $assignmentfoldername,
    //         'assignmentgenerateid' => $request->assignmentgenerateid,
    //     ];

    //     // Set zip file name and path
    //     $parentZipFileName = $data['assignmentgenerateid'] . '.zip';
    //     $parentZipFilePath = storage_path('app/public/image/task/') . $parentZipFileName;

    //     // Initialize ZipArchive
    //     $parentZip = new ZipArchive;

    //     if ($parentZip->open($parentZipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    //         foreach ($data['assignmentfoldername'] as $foldername) {
    //             if ($foldername->filesname !== null) {
    //                 // Get file path
    //                 $filePath = storage_path('app/public/image/task/' . $foldername->filesname);

    //                 if (file_exists($filePath)) {
    //                     // Read file content
    //                     $fileContent = file_get_contents($filePath);

    //                     if ($fileContent !== false) {
    //                         // Add file to zip inside its folder
    //                         $parentZip->addFromString($foldername->assignmentfoldersname . '/' . $foldername->realname, $fileContent);
    //                     }
    //                 }
    //             } else {
    //                 // If no files, add empty directory
    //                 $parentZip->addEmptyDir($foldername->assignmentfoldersname);
    //             }
    //         }
    //         $parentZip->close();
    //     } else {
    //         return response()->json(['error' => 'Could not create zip file'], 500);
    //     }

    //     return response()->json(['zipFile' => $parentZipFileName]);
    // }

    // public function createzipfolder(Request $request)
    // {
    //     $assignmentgenerateid = $request->assignmentgenerateid;

    //     // Fetch files from the database
    //     $files = DB::table('assignmentfolderfiles')
    //         ->where('assignmentfolder_id', function ($query) use ($assignmentgenerateid) {
    //             $query->select('id')
    //                 ->from('assignmentfolders')
    //                 ->where('assignmentgenerateid', $assignmentgenerateid);
    //         })
    //         ->select('filesname', 'realname')
    //         ->get();

    //     // dd($files);

    //     if ($files->isEmpty()) {
    //         return response()->json(['error' => 'No files found!'], 404);
    //     }

    //     // Set ZIP file name dynamically
    //     $zipFileName = $assignmentgenerateid . '.zip';

    //     // Stream ZIP directly to the response
    //     return Zip::create($zipFileName, function ($zip) use ($files) {
    //         foreach ($files as $file) {
    //             $filePath = storage_path('app/public/image/task/' . $file->filesname);
    //             if (file_exists($filePath)) {
    //                 $zip->add(storage_path('app/public/image/task/' . $file->filesname), $file->realname);
    //             }
    //         }
    //     });
    // }




    // public function createzipfolder(Request $request)
    // {
    //     $assignmentgenerateid = $request->assignmentgenerateid;

    //     // Fetch files from the database
    //     $files = DB::table('assignmentfolderfiles')
    //         ->where('assignmentfolder_id', function ($query) use ($assignmentgenerateid) {
    //             $query->select('id')
    //                 ->from('assignmentfolders')
    //                 ->where('assignmentgenerateid', $assignmentgenerateid);
    //         })
    //         ->select('filesname', 'realname')
    //         ->get();

    //     if ($files->isEmpty()) {
    //         return response()->json(['error' => 'No files found!'], 404);
    //     }

    //     // Set ZIP file name
    //     $zipFileName = $assignmentgenerateid . '.zip';

    //     // Prepare an array of files for ZipStream
    //     $fileArray = [];

    //     foreach ($files as $file) {
    //         $filePath = storage_path('app/public/image/task/' . $file->filesname);
    //         if (file_exists($filePath)) {
    //             $fileArray[$file->realname] = $filePath;
    //         }
    //     }

    //     // Ensure there are files to zip
    //     if (empty($fileArray)) {
    //         return response()->json(['error' => 'No valid files found!'], 404);
    //     }

    //     // Stream ZIP directly to the response using ZipStream
    //     return ZipStreamcreate::create($zipFileName, $fileArray);
    // }


    // public function createzipfolder(Request $request)
    // {
    //     $assignmentgenerateid = $request->assignmentgenerateid;

    //     // Fetch files from the database
    //     $files = DB::table('assignmentfolderfiles')
    //         ->where('assignmentfolder_id', function ($query) use ($assignmentgenerateid) {
    //             $query->select('id')
    //                 ->from('assignmentfolders')
    //                 ->where('assignmentgenerateid', $assignmentgenerateid);
    //         })
    //         ->select('filesname', 'realname')
    //         ->get();

    //     if ($files->isEmpty()) {
    //         return response()->json(['error' => 'No files found!'], 404);
    //     }

    //     // Set ZIP file name and path
    //     $zipFileName = $assignmentgenerateid . '.zip';
    //     $zipFilePath = storage_path('app/public/' . $zipFileName);

    //     // Prepare an array of files for ZipStream
    //     $fileArray = [];

    //     foreach ($files as $file) {
    //         $filePath = storage_path('app/public/image/task/' . $file->filesname);
    //         if (file_exists($filePath)) {
    //             $fileArray[$file->realname] = $filePath;
    //         }
    //     }

    //     if (empty($fileArray)) {
    //         return response()->json(['error' => 'No valid files found!'], 404);
    //     }

    //     // Create ZIP file using ZipStream
    //     ZipStreamcreate::create($zipFilePath, $fileArray);

    //     return response()->json([
    //         'success' => true,
    //         'zipFile' => asset('storage/zip/' . $zipFileName) // Return the public path for download
    //     ]);
    // }

    // public function createzipfolder(Request $request)
    // {
    //     $assignmentgenerateid = $request->assignmentgenerateid;

    //     // Fetch files from the database
    //     $files = DB::table('assignmentfolderfiles')
    //         ->where('assignmentfolder_id', function ($query) use ($assignmentgenerateid) {
    //             $query->select('id')
    //                 ->from('assignmentfolders')
    //                 ->where('assignmentgenerateid', $assignmentgenerateid);
    //         })
    //         ->select('filesname', 'realname')
    //         ->get();

    //     if ($files->isEmpty()) {
    //         return response()->json(['error' => 'No files found!'], 404);
    //     }

    //     // Create a new ZipStream instance
    //     $zip = new Zip($assignmentgenerateid . '.zip');

    //     foreach ($files as $file) {
    //         $filePath = storage_path('app/public/image/task/' . $file->filesname);
    //         if (file_exists($filePath)) {
    //             $zip->add(storage_path('app/public/image/task/' . $file->filesname), $file->realname);
    //         }
    //     }

    //     // Finish and stream the zip file to the browser
    //     return $zip;
    // }

    // public function createzipfolder(Request $request)
    // {
    //     $assignmentgenerateid = $request->assignmentgenerateid;

    //     // Fetch files from the database
    //     $files = DB::table('assignmentfolderfiles')
    //         ->where('assignmentfolder_id', function ($query) use ($assignmentgenerateid) {
    //             $query->select('id')
    //                 ->from('assignmentfolders')
    //                 ->where('assignmentgenerateid', $assignmentgenerateid);
    //         })
    //         ->select('filesname', 'realname')
    //         ->get();

    //     if ($files->isEmpty()) {
    //         return response()->json(['error' => 'No files found!'], 404);
    //     }

    //     // Set response headers for ZIP stream
    //     $zip = new ZipStream($assignmentgenerateid . '.zip');

    //     foreach ($files as $file) {
    //         $filePath = storage_path('app/public/image/task/' . $file->filesname);
    //         if (file_exists($filePath)) {
    //             $zip->addFileFromPath($file->realname, $filePath);
    //         }
    //     }

    //     // Finish the stream and send to the browser
    //     return $zip->finish();
    // }

    // public function createzipfolder(Request $request)
    // {
    //     $assignmentgenerateid = $request->assignmentgenerateid;

    //     // Fetch files from the database
    //     $files = DB::table('assignmentfolderfiles')
    //         ->where('assignmentfolder_id', function ($query) use ($assignmentgenerateid) {
    //             $query->select('id')
    //                 ->from('assignmentfolders')
    //                 ->where('assignmentgenerateid', $assignmentgenerateid);
    //         })
    //         ->select('filesname', 'realname')
    //         ->get();

    //     if ($files->isEmpty()) {
    //         return response()->json(['error' => 'No files found!'], 404);
    //     }

    //     // Set ZIP archive options
    //     $options = new Archive();
    //     $options->setSendHttpHeaders(true); // Important for streaming

    //     // Start ZIP Stream
    //     $zip = new ZipStream(null, $options);

    //     foreach ($files as $file) {
    //         $filePath = storage_path('app/public/image/task/' . $file->filesname);
    //         if (file_exists($filePath)) {
    //             // Add file to zip
    //             $zip->addFileFromPath($file->realname, $filePath);
    //         }
    //     }

    //     // Send ZIP to browser
    //     $zip->finish();
    //     return response()->json(['success' => 'ZIP file created successfully']);
    // }

    // public function createzipfolder(Request $request)
    // {
    //     $assignmentgenerateid = $request->assignmentgenerateid;

    //     // Fetch files from the database
    //     $files = DB::table('assignmentfolderfiles')
    //         ->where('assignmentfolder_id', function ($query) use ($assignmentgenerateid) {
    //             $query->select('id')
    //                 ->from('assignmentfolders')
    //                 ->where('assignmentgenerateid', $assignmentgenerateid);
    //         })
    //         ->select('filesname', 'realname')
    //         ->get();

    //     if ($files->isEmpty()) {
    //         return response()->json(['error' => 'No files found!'], 404);
    //     }

    //     // **ZIP file streaming response**
    //     return new StreamedResponse(function () use ($files) {

    //         $options = new Archive();
    //         $options->setSendHttpHeaders(true); 


    //         $zip = new ZipStream('my_files.zip', $options);

    //         foreach ($files as $file) {
    //             $filePath = storage_path('app/public/image/task/' . $file->filesname);
    //             if (file_exists($filePath)) {

    //                 $zip->addFileFromPath($file->realname, $filePath);
    //             }
    //         }


    //         $zip->finish();
    //     }, 200, [
    //         "Content-Type" => "application/octet-stream",
    //         "Content-Disposition" => "attachment; filename=my_files.zip"
    //     ]);
    // }

    // public function createzipfolder(Request $request)
    // {
    //     $assignmentgenerateid = $request->assignmentgenerateid;

    //     // Fetch files from the database
    //     $files = DB::table('assignmentfolderfiles')
    //         ->where('assignmentfolder_id', function ($query) use ($assignmentgenerateid) {
    //             $query->select('id')
    //                 ->from('assignmentfolders')
    //                 ->where('assignmentgenerateid', $assignmentgenerateid);
    //         })
    //         ->select('filesname', 'realname')
    //         ->get();

    //     if ($files->isEmpty()) {
    //         return response()->json(['error' => 'No files found!'], 404);
    //     }

    //     // **ZIP Streaming Response**
    //     return response()->streamDownload(function () use ($files) {
    //         $options = new Archive();
    //         $options->setSendHttpHeaders(true);

    //         $zip = new ZipStream('my_files.zip', $options);

    //         foreach ($files as $file) {
    //             $filePath = storage_path('app/public/image/task/' . $file->filesname);
    //             if (file_exists($filePath)) {
    //                 $zip->addFileFromPath($file->realname, $filePath);
    //             }
    //         }

    //         $zip->finish();
    //     }, 'my_files.zip', [
    //         "Content-Type" => "application/octet-stream",
    //         "Content-Disposition" => "attachment; filename=my_files.zip"
    //     ]);
    // }



    // public function createzipfolder(Request $request)
    // {
    //     $assignmentgenerateid = $request->assignmentgenerateid;

    //     // Fetch files from the database
    //     $files = DB::table('assignmentfolderfiles')
    //         ->where('assignmentfolder_id', function ($query) use ($assignmentgenerateid) {
    //             $query->select('id')
    //                 ->from('assignmentfolders')
    //                 ->where('assignmentgenerateid', $assignmentgenerateid);
    //         })
    //         ->select('filesname', 'realname')
    //         ->get();

    //     if ($files->isEmpty()) {
    //         return response()->json(['error' => 'No files found!'], 404);
    //     }

    //     // ✅ Fix: Correct way to create ZipStream instance
    //     return response()->streamDownload(function () use ($files) {
    //         $options = new Archive();
    //         $options->setSendHttpHeaders(true); // ✅ Ensure headers are properly sent

    //         // ✅ Corrected: No filename here, only options
    //         $zip = new ZipStream($options);

    //         foreach ($files as $file) {
    //             $filePath = storage_path('app/public/image/task/' . $file->filesname);
    //             if (file_exists($filePath)) {
    //                 $zip->addFileFromPath($file->realname, $filePath);
    //             }
    //         }

    //         $zip->finish();
    //     }, 'my_files.zip', [
    //         "Content-Type" => "application/octet-stream",
    //         "Content-Disposition" => "attachment; filename=my_files.zip"
    //     ]);
    // }

    // public function createzipfolder(Request $request)
    // {
    //     try {
    //         // Retrieve assignment ID from request
    //         $assignmentId = $request->query('assignmentgenerateid');

    //         // Define folder path where assignment files are stored
    //         // $folderPath = storage_path("app/public/assignments/{$assignmentId}/");
    //         $folderPath = storage_path("app/public/image/task/{$assignmentId}/");

    //         // Check if folder exists
    //         if (!is_dir($folderPath)) {
    //             return response()->json(['error' => 'Folder not found'], 404);
    //         }

    //         // Get list of files in the directory
    //         $files = array_diff(scandir($folderPath), array('.', '..'));

    //         if (empty($files)) {
    //             return response()->json(['error' => 'No files found in the folder'], 404);
    //         }

    //         // Stream the ZIP file as a response
    //         return response()->stream(function () use ($folderPath, $files) {
    //             $options = new Archive();
    //             $zip = new ZipStream('assignment_files.zip', $options);

    //             foreach ($files as $file) {
    //                 $filePath = $folderPath . $file;

    //                 if (is_file($filePath)) {
    //                     $zip->addFileFromPath($file, $filePath);
    //                 }
    //             }

    //             $zip->finish();
    //         }, 200, [
    //             'Content-Type' => 'application/octet-stream',
    //             'Content-Disposition' => 'attachment; filename="assignment_files.zip"',
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }


    // 22222222222222222222222222222222222222222222222222222222222222

    public function createzipfolder(Request $request)
    {
        $assignmentfoldername = DB::table('assignmentfolders')
            ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
            ->where('assignmentfolders.assignmentgenerateid', $request->assignmentgenerateid)
            ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname', 'assignmentfolderfiles.realname')
            ->get();

        // Set ZIP file name
        $zipFileName = $request->assignmentgenerateid . '.zip';

        // Streamed response for downloading the zip file
        $response = new StreamedResponse(function () use ($assignmentfoldername) {
            $options = new ZipOptions();
            $options->setSendHttpHeaders(true);
            $zip = new ZipStream(null, $options);

            foreach ($assignmentfoldername as $folder) {
                if (!empty($folder->filesname)) {
                    // Get file path
                    $filePath = storage_path('app/public/image/task/' . $folder->filesname);

                    if (file_exists($filePath)) {
                        // Read file content and add to zip
                        $zip->addFileFromPath($folder->assignmentfoldersname . '/' . $folder->realname, $filePath);
                    }
                } else {
                    // Add empty directory if no files
                    $zip->addFolder($folder->assignmentfoldersname);
                }
            }

            $zip->finish();
        });

        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $zipFileName . '"');

        return $response;
    }

    // 22222222222222222222222222222222222222222222222222222222222222
    public function index_list($id)
    {
        $foldername = DB::table('assignmentfolders')->where('id', $id)->first();
        $financial =  DB::table('assignmentbudgetings')->leftjoin('financialstatementclassifications', 'financialstatementclassifications.assignment_id', 'assignmentbudgetings.assignment_id')
            ->where('assignmentbudgetings.assignmentgenerate_id', $foldername->assignmentgenerateid)
            ->select('financialstatementclassifications.id', 'financialstatementclassifications.financial_name')
            ->get();
        // $assignmentfolderfile = DB::table('assignmentfolderfiles')
        //     ->leftjoin('teammembers', 'teammembers.id', 'assignmentfolderfiles.createdby')
        //     ->where('assignmentfolderfiles.assignmentfolder_id', $id)
        //     ->where('assignmentfolderfiles.status', 1)
        //     ->select('assignmentfolderfiles.*', 'teammembers.team_member', 'teammembers.staffcode')
        //     ->latest()
        //     ->get();

        $assignmentfolderfile = DB::table('assignmentfolderfiles')
            ->leftjoin('teammembers', 'teammembers.id', 'assignmentfolderfiles.createdby')
            ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
                $join->on('teamrolehistoryteam.teammember_id', '=', 'assignmentfolderfiles.createdby')
                    ->whereRaw('teamrolehistoryteam.created_at < assignmentfolderfiles.created_at');
            })
            ->where('assignmentfolderfiles.assignmentfolder_id', $id)
            ->where('assignmentfolderfiles.status', 1)
            ->select('assignmentfolderfiles.*', 'teammembers.team_member', 'teammembers.staffcode', 'teamrolehistoryteam.newstaff_code')
            ->latest()
            ->get();
        // dd($assignmentfolderfile);

        $assignmentbudgeting = DB::table('assignmentbudgetings')
            ->where('assignmentgenerate_id', $foldername->assignmentgenerateid)->first();
        $teamleader = DB::table('assignmentmappings')
            ->join('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            ->where('assignmentmappings.assignmentgenerate_id', $foldername->assignmentgenerateid)
            ->where('type', 0)->pluck('teammember_id')->first();

        return view('backEnd.assignmentfolderfile.index', compact('teamleader', 'assignmentbudgeting', 'assignmentfolderfile', 'id', 'foldername', 'financial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'particular' => 'required',
            'file' => 'required',
        ]);

        try {
            $data = $request->except(['_token']);
            $files = [];
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $realname = $file->getClientOriginalName();
                    $name = time() . $realname;
                    $destinationPath = storage_path('app/public/image/task');
                    $name = $file->getClientOriginalName();
                    $sizeKB = round($file->getSize() / 1024, 2);
                    $file->move($destinationPath, $name);

                    // $path = $file->storeAs($request->assignmentgenerateid, $name, 's3');
                    $files[] = [
                        'realname' => $realname,
                        'name' => $name,
                        'size' => $sizeKB,

                    ];
                }
            }

            // dd($files);
            foreach ($files as $filess) {
                // dd($files); die;
                $s = DB::table('assignmentfolderfiles')->insert([
                    'particular' => $request->particular,
                    'assignmentgenerateid' => $request->assignmentgenerateid,
                    'assignmentfolder_id' =>  $request->assignmentfolder_id,
                    'createdby' =>  auth()->user()->teammember_id,
                    'filesname' =>  $filess['name'],
                    'realname' =>  $filess['realname'],
                    'filesize' => $filess['size'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            //dd($data);
            $output = array('msg' => 'Submit Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignmentfolderfile  $assignmentfolderfile
     * @return \Illuminate\Http\Response
     */
    public function show(Assignmentfolderfile $assignmentfolderfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignmentfolderfile  $assignmentfolderfile
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignmentfolderfile $assignmentfolderfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignmentfolderfile  $assignmentfolderfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignmentfolderfile $assignmentfolderfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignmentfolderfile  $assignmentfolderfile
     * @return \Illuminate\Http\Response
     */
    public function  destroy($id)
    {
        //  dd($id);
        try {
            DB::table('assignmentfolderfiles')->where('id', $id)->update([

                'status'   =>   0,

            ]);
            $output = array('msg' => 'Deleted Successfully');
            return back()->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
}

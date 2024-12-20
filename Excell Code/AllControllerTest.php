<?php
// Route::get('/import-csv', [AllControllerTest::class, 'importLargeCSV']);
//* number 4
// Start Hare
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\LargeCSVImport;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use App\Models\AllModelTest;
use Illuminate\Support\Facades\Log;

class AllControllerTest extends Controller
{

    // Excel::import(new LargeCSVImport, storage_path('app\public\image\task\clients.csv'));
    // Excel::import(new LargeCSVImport, storage_path('app\public\image\task\timesheetusers.csv'));
    // Excel::import(new LargeCSVImport, storage_path('app\public\image\task\EDL_DEP_TD_DUMP_SEPT_2024.csv'));
    // public function importLargeCSV()
    // {

    //     // dd('hi');
    //     try {
    //         // Excel::import(new LargeCSVImport, storage_path('app\public\image\task\clients.csv'));
    //         Excel::import(new LargeCSVImport, storage_path('app\public\image\task\EEB-NPA-PROV-SEP-2024-V3.txt'));
    //         return "Data imported successfully.";
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }


    // public function importLargeCSV()
    // {
    //     try {
    //         // Load only the first 10 rows into a collection
    //         // $collection = Excel::toCollection(new LargeCSVImport, storage_path('app/public/image/task/EDL_DEP_TD_DUMP_SEPT_2024.csv'));
    //         $collection = Excel::toCollection(new LargeCSVImport, storage_path('app\public\image\task\clients.csv'));

    //         // Check if the collection has data
    //         if ($collection->isNotEmpty()) {
    //             $rows = $collection->first()->take(200); // Get the first 10 rows
    //             dd($rows);
    //             // Insert rows into the database
    //             foreach ($rows as $row) {
    //                 AllModelTest::create([
    //                     'servicename' => $row['client_name'],
    //                     'brif' => $row['client_code'],
    //                 ]);
    //             }

    //             return "Data imported successfully.";
    //         } else {
    //             return "No data found in the CSV file.";
    //         }
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }




    // public function importLargeCSV()
    // {
    //     try {

    //         // $collection = Excel::toCollection(new LargeCSVImport, storage_path('app/public/image/task/EDL_DEP_TD_DUMP_SEPT_2024.csv'));
    //         $collection = Excel::toCollection(new LargeCSVImport, storage_path('app\public\image\task\clients.csv'));

    //         // Check if the collection has data
    //         if ($collection->isNotEmpty()) {
    //             $rows = $collection->first()->take(10);
    //             // $rows = $collection->first()->count();
    //             dd($rows);

    //             foreach ($rows as $row) {
    //                 AllModelTest::create([
    //                     'lpt_product_name' => $row['lpt_product_name'],
    //                     'asq_desc' => $row['asq_desc'] ?? null,
    //                     'cln_principal_balance' => $row['cln_principal_balance'] ?? null,
    //                     'provision_amount' => $row['provision_amount'] ?? null,
    //                     'outstanding' => $row['outstanding'] ?? null,
    //                 ]);
    //             }

    //             return "Data imported successfully.";
    //         } else {
    //             return "No data found in the CSV file.";
    //         }
    //     } catch (Exception $e) {
    //         return "Error text: " . $e->getMessage();
    //     }
    // }


    // public function importLargeCSV()
    // {
    //     $filePath = storage_path('app/public/image\task\clients.csv');

    //     try {
    //         // Open the file in read mode
    //         if (($handle = fopen($filePath, 'r')) !== false) {
    //             // Read and ignore the header row
    //             // fgetcsv($handle);

    //             // Loop through each row in the file and insert it into the database
    //             while (($row = fgetcsv($handle)) !== false) {
    //                 dd($row);
    //                 if (!empty($row[0])) { // Assuming 'lpt_product_name' is in the first column
    //                     AllModelTest::create([
    //                         'lpt_product_name' => $row[0],
    //                         'asq_desc' => $row[1] ?? null,
    //                         'cln_principal_balance' => $row[2] ?? null,
    //                         'provision_amount' => $row[3] ?? null,
    //                         'outstanding' => $row[4] ?? null,
    //                     ]);
    //                 }
    //             }

    //             // Close the file
    //             fclose($handle);

    //             return "Data imported successfully from the entire file.";
    //         } else {
    //             return "Could not open the file.";
    //         }
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    // public function importLargeCSV()
    // {
    //     $filePath = storage_path('app/public/image/task/clients.csv');

    //     try {
    //         // Open the file in read mode
    //         if (($handle = fopen($filePath, 'r')) !== false) {
    //             // Read the header row to get the columns
    //             $header = fgetcsv($handle);

    //             // Loop through each row in the file and insert it into the database
    //             while (($row = fgetcsv($handle)) !== false) {
    //                 // Combine header with row to get associative array
    //                 $data = array_combine($header, $row);
    //                 dd($data);
    //                 AllModelTest::create([
    //                     'lpt_product_name' => $data['lpt_product_name'] ?? null,
    //                     'asq_desc' => $data['asq_desc'] ?? null,
    //                     'cln_principal_balance' => $data['cln_principal_balance'] ?? null,
    //                     'provision_amount' => $data['provision_amount'] ?? null,
    //                     'outstanding' => $data['outstanding'] ?? null,
    //                 ]);
    //             }

    //             // Close the file
    //             fclose($handle);

    //             return "Data imported successfully from the entire file.";
    //         } else {
    //             return "Could not open the file.";
    //         }
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    // public function importLargeCSV()
    // {
    //     // $filePath = storage_path('app/public/image/task/clients.csv');
    //     $filePath = storage_path('app/public/image/task\EEB-NPA-PROV-SEP-2024-V3.txt');

    //     try {
    //         // Open the file in read mode
    //         if (($handle = fopen($filePath, 'r')) !== false) {
    //             // Read the header row to get the columns
    //             $header = fgetcsv($handle);
    //             dd($header);
    //             // Loop through each row in the file and insert it into the database
    //             while (($row = fgetcsv($handle)) !== false) {
    //                 // Combine header with row to get associative array
    //                 $data = array_combine($header, $row);

    //                 AllModelTest::create([
    //                     'lpt_product_name' => $data['lpt_product_name'] ?? null,
    //                     'asq_desc' => $data['asq_desc'] ?? null,
    //                     'cln_principal_balance' => $data['cln_principal_balance'] ?? null,
    //                     'provision_amount' => $data['provision_amount'] ?? null,
    //                     'outstanding' => $data['outstanding'] ?? null,
    //                 ]);
    //             }

    //             // Close the file
    //             fclose($handle);

    //             return "Data imported successfully from the entire file.";
    //         } else {
    //             return "Could not open the file.";
    //         }
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    // public function importLargeCSV()
    // {
    //     $filePath = storage_path('app/public/image/task/EEB-NPA-PROV-SEP-2024-V3.txt');

    //     try {
    //         // Open the file in read mode
    //         if (($handle = fopen($filePath, 'r')) !== false) {
    //             // Read the header row with a tab delimiter
    //             $header = fgetcsv($handle, 0, "\t");

    //             // Check if the header row was read correctly
    //             if ($header === false) {
    //                 fclose($handle);
    //                 return "Error: Unable to read header row.";
    //             }

    //             // Loop through each row in the file and insert it into the database
    //             while (($row = fgetcsv($handle, 0, "\t")) !== false) {
    //                 // Combine header with row to get associative array
    //                 $data = array_combine($header, $row);
    //                 dd($data);
    //                 // Insert data into the database
    //                 AllModelTest::create([
    //                     'lpt_product_name' => $data['LPT_PRODUCT_NAME'] ?? null,
    //                     'asq_desc' => $data['ASQ_DESC'] ?? null,
    //                     'cln_principal_balance' => $data['CLN_PRINCIPAL_BALANCE'] ?? null,
    //                     'provision_amount' => $data['PROVISION_AMOUNT'] ?? null,
    //                     'outstanding' => $data['OUTSTANDING'] ?? null,
    //                 ]);
    //             }

    //             // Close the file
    //             fclose($handle);

    //             return "Data imported successfully from the entire file.";
    //         } else {
    //             return "Could not open the file.";
    //         }
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    public function importLargeCSV()
    {
        $filePath = storage_path('app/public/image/task/EEB-NPA-PROV-SEP-2024-V3.txt');

        try {
            // Open the file in read mode
            if (($handle = fopen($filePath, 'r')) !== false) {
                // Read the header row with a tab delimiter
                $header = fgetcsv($handle, 0, "\t");

                // Check if the header row was read correctly
                if ($header === false) {
                    fclose($handle);
                    return "Error: Unable to read header row.";
                }

                // Counter to limit the number of iterations to 10
                $counter = 0;

                // Loop through each row in the file and insert it into the database
                while (($row = fgetcsv($handle, 0, "\t")) !== false) {
                    // Combine header with row to get associative array
                    $data = array_combine($header, $row);

                    // Debug the data if needed
                    // dd($data);

                    // Insert data into the database
                    AllModelTest::create([
                        'lpt_product_name' => $data['LPT_PRODUCT_NAME'] ?? null,
                        'asq_desc' => $data['ASQ_DESC'] ?? null,
                        'cln_principal_balance' => $data['CLN_PRINCIPAL_BALANCE'] ?? null,
                        'provision_amount' => $data['Provision_Amount'] ?? null,
                        'outstanding' => $data['OUTSTANDING'] ?? null,
                        'cln_product_type_code' => $data['CLN_PRODUCT_TYPE_CODE'] ?? null,
                        'asq_code' => $data['ASQ_CODE'] ?? null,
                    ]);

                    // Increment the counter
                    $counter++;

                    // Stop after 10 iterations
                    // if ($counter >= 11) {
                    //     break;
                    // }
                }

                // Close the file
                fclose($handle);

                return "Data imported successfully for {$counter} rows.";
            } else {
                return "Could not open the file.";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
//* number 3
// Start Hare

public function importLargeCSV()
{
    $filePath = storage_path('app/public/image/task/EEB-NPA-PROV-SEP-2024-V3.txt');

    try {
        // Open the file in read mode
        if (($handle = fopen($filePath, 'r')) !== false) {
            // Read the header row with a tab delimiter
            $header = fgetcsv($handle, 0, "\t");

            // Check if the header row was read correctly
            if ($header === false) {
                fclose($handle);
                return "Error: Unable to read header row.";
            }

            // Counter to limit the number of iterations to 10
            $counter = 0;

            // Loop through each row in the file and insert it into the database
            while (($row = fgetcsv($handle, 0, "\t")) !== false) {
                // Combine header with row to get associative array
                $data = array_combine($header, $row);

                // Debug the data if needed
                // dd($data);

                // Insert data into the database
                AllModelTest::create([
                    'lpt_product_name' => $data['LPT_PRODUCT_NAME'] ?? null,
                    'asq_desc' => $data['ASQ_DESC'] ?? null,
                    'cln_principal_balance' => $data['CLN_PRINCIPAL_BALANCE'] ?? null,
                    'provision_amount' => $data['Provision_Amount'] ?? null,
                    'outstanding' => $data['OUTSTANDING'] ?? null,
                    'cln_product_type_code' => $data['CLN_PRODUCT_TYPE_CODE'] ?? null,
                    'asq_code' => $data['ASQ_CODE'] ?? null,
                ]);

                // Increment the counter
                $counter++;

                // Stop after 10 iterations
                if ($counter >= 11) {
                    break;
                }
            }

            // Close the file
            fclose($handle);

            return "Data imported successfully for {$counter} rows.";
        } else {
            return "Could not open the file.";
        }
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}
    // public function importLargeCSV()
    // {
    //     $filePath = storage_path('app/public/image/task/EEB-NPA-PROV-SEP-2024-V3.txt');

    //     try {
    //         // Open the file in read mode
    //         if (($handle = fopen($filePath, 'r')) !== false) {
    //             // Read the header row with a tab delimiter
    //             $header = fgetcsv($handle, 0, "\t");

    //             // Check if the header row was read correctly
    //             if ($header === false) {
    //                 fclose($handle);
    //                 return "Error: Unable to read header row.";
    //             }

    //             // Loop through each row in the file and insert it into the database
    //             while (($row = fgetcsv($handle, 0, "\t")) !== false) {
    //                 // Combine header with row to get associative array
    //                 $data = array_combine($header, $row);
    //                 dd($data);
    //                 // Insert data into the database
    //                 AllModelTest::create([
    //                     'lpt_product_name' => $data['LPT_PRODUCT_NAME'] ?? null,
    //                     'asq_desc' => $data['ASQ_DESC'] ?? null,
    //                     'cln_principal_balance' => $data['CLN_PRINCIPAL_BALANCE'] ?? null,
    //                     'provision_amount' => $data['PROVISION_AMOUNT'] ?? null,
    //                     'outstanding' => $data['OUTSTANDING'] ?? null,
    //                 ]);
    //             }

    //             // Close the file
    //             fclose($handle);

    //             return "Data imported successfully from the entire file.";
    //         } else {
    //             return "Could not open the file.";
    //         }
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    public function importLargeCSV()
    {
        $filePath = storage_path('app/public/image/task/EEB-NPA-PROV-SEP-2024-V3.txt');

        try {
            // Open the file in read mode
            if (($handle = fopen($filePath, 'r')) !== false) {
                // Read the header row with a tab delimiter
                $header = fgetcsv($handle, 0, "\t");

                // Check if the header row was read correctly
                if ($header === false) {
                    fclose($handle);
                    return "Error: Unable to read header row.";
                }

                // Counter to limit the number of iterations to 10
                $counter = 0;

                // Loop through each row in the file and insert it into the database
                while (($row = fgetcsv($handle, 0, "\t")) !== false) {
                    // Combine header with row to get associative array
                    $data = array_combine($header, $row);

                    // Debug the data if needed
                    // dd($data);

                    // Insert data into the database
                    AllModelTest::create([
                        'lpt_product_name' => $data['LPT_PRODUCT_NAME'] ?? null,
                        'asq_desc' => $data['ASQ_DESC'] ?? null,
                        'cln_principal_balance' => $data['CLN_PRINCIPAL_BALANCE'] ?? null,
                        'provision_amount' => $data['Provision_Amount'] ?? null,
                        'outstanding' => $data['OUTSTANDING'] ?? null,
                        'cln_product_type_code' => $data['CLN_PRODUCT_TYPE_CODE'] ?? null,
                        'asq_code' => $data['ASQ_CODE'] ?? null,
                    ]);

                    // Increment the counter
                    $counter++;

                    // Stop after 10 iterations
                    if ($counter >= 10) {
                        break;
                    }
                }

                // Close the file
                fclose($handle);

                return "Data imported successfully for 10 rows.";
            } else {
                return "Could not open the file.";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
//! End hare

//* number 2
// Start Hare
public function importLargeCSV()
{
    try {

        // Load only the first 10 rows into a collection
        // $collection = Excel::toCollection(new LargeCSVImport, storage_path('app/public/image/task/EDL_DEP_TD_DUMP_SEPT_2024.csv'));
        $collection = Excel::toCollection(new LargeCSVImport, storage_path('app\public\image\task\clients.csv'));
        // Check if the collection has data
        if ($collection->isNotEmpty()) {
            $rows = $collection->first()->take(20);
            // $rows = $collection->first()->count();
            // dd($rows);
            // Insert rows into the database
            foreach ($rows as $row) {
                AllModelTest::create([
                    'servicename' => $row['client_name'],
                    'brif' => $row['client_code'],
                ]);
                // AllModelTest::create([
                //     'lpt_product_name' => $row['lpt_product_name'],
                //     'asq_desc' => $row['asq_desc'] ?? null,
                //     'cln_principal_balance' => $row['cln_principal_balance'] ?? null,
                //     'provision_amount' => $row['provision_amount'] ?? null,
                //     'outstanding' => $row['outstanding'] ?? null,
                // ]);
            }

            return "Data imported successfully.";
        } else {
            return "No data found in the CSV file.";
        }
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}
//! End hare

//* Number 1
// Start Hare

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\LargeCSVImport;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use App\Models\AllModelTest;
use Illuminate\Support\Facades\Log;

class AllControllerTest extends Controller
{

    // public function importLargeCSV()
    // {
    //     try {
    //         // die;
    //         // Excel::import(new LargeCSVImport, storage_path('app\uEDL_DEP_TD_DUMP_SEPT_2024.csv'));
    //         // Excel::import(new LargeCSVImport, storage_path('app\debtors1.xlsx'));
    //         Excel::import(new LargeCSVImport, storage_path('app\public\image\task\bank1.xlsx'));
    //         return "Data imported successfully!";
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    // Excel::import(new LargeCSVImport, storage_path('app\public\image\task\clients.csv'));
    // Excel::import(new LargeCSVImport, storage_path('app\public\image\task\timesheetusers.csv'));
    // Excel::import(new LargeCSVImport, storage_path('app\public\image\task\EDL_DEP_TD_DUMP_SEPT_2024.csv'));
    public function importLargeCSV()
    {

        // dd('hi');
        try {
            // Excel::import(new LargeCSVImport, storage_path('app\public\image\task\clients.csv'));
            Excel::import(new LargeCSVImport, storage_path('app\public\image\task\EEB-NPA-PROV-SEP-2024-V3.txt'));
            return "Data imported successfully.";
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // public function importLargeCSV()
    // {
    //     try {
    //         // Load only the first 10 rows into a collection
    //         // $collection = Excel::toCollection(new LargeCSVImport, storage_path('app/public/image/task/EDL_DEP_TD_DUMP_SEPT_2024.csv'));
    //         $collection = Excel::toCollection(new LargeCSVImport, storage_path('app\public\image\task\clients.csv'));

    //         // Check if the collection has data
    //         if ($collection->isNotEmpty()) {
    //             $rows = $collection->first()->take(200); // Get the first 10 rows
    //             dd($rows);
    //             // Insert rows into the database
    //             foreach ($rows as $row) {
    //                 AllModelTest::create([
    //                     'servicename' => $row['client_name'],
    //                     'brif' => $row['client_code'],
    //                 ]);
    //             }

    //             return "Data imported successfully.";
    //         } else {
    //             return "No data found in the CSV file.";
    //         }
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    // public function importLargeCSV()
    // {
    //     try {
    //         // Load only the first 10 rows into a collection
    //         // $collection = Excel::toCollection(new LargeCSVImport, storage_path('app/public/image/task/EDL_DEP_TD_DUMP_SEPT_2024.csv'));
    //         $collection = Excel::toCollection(new LargeCSVImport, storage_path('app\public\image\task\clients.csv'));

    //         // Check if the collection has data
    //         if ($collection->isNotEmpty()) {
    //             $rows = $collection->first()->take(200); // Get the first 10 rows
    //             dd($rows);
    //             // Insert rows into the database
    //             foreach ($rows as $row) {
    //                 AllModelTest::create([
    //                     'servicename' => $row['client_name'],
    //                     'brif' => $row['client_code'],
    //                 ]);
    //             }

    //             return "Data imported successfully.";
    //         } else {
    //             return "No data found in the CSV file.";
    //         }
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    // public function importLargeCSV()
    // {
    //     try {
    //         Excel::import(new LargeCSVImport, storage_path('app/public/image/task/clients.csv'));
    //         return "Data imported successfully.";
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    public function importLargeCSV()
    {
        $filePath = storage_path('app/public/image/task/EDL_DEP_TD_DUMP_SEPT_2024.csv');
        $rowLimit = 10; // Set the limit for how many rows you want to process
        $currentRow = 0;

        try {
            // Open the file in read mode
            if (($handle = fopen($filePath, 'r')) !== false) {
                // Skip the header row if necessary
                $header = fgetcsv($handle);

                // Loop through the file line by line
                while (($row = fgetcsv($handle)) !== false) {
                    if ($currentRow >= $rowLimit) {
                        break; // Stop after reading the specified number of rows
                    }

                    // Map CSV columns to your model fields
                    $data = array_combine($header, $row);
                    dd($data);
                    // Insert row data into the database
                    AllModelTest::create([
                        'servicename' => $data['client_name'], // Adjust this to match CSV header
                        'brif' => $data['client_code'], // Adjust this to match CSV header
                    ]);

                    $currentRow++; // Increment the row counter
                }

                // Close the file
                fclose($handle);

                return "Data imported successfully for {$rowLimit} rows.";
            } else {
                return "Could not open the file.";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // public function importLargeCSV()
    // {
    //     $filePath = storage_path('app/public/image/task/EDL_DEP_TD_DUMP_SEPT_2024.csv');
    //     $rowLimit = 10; // Set the limit for how many rows you want to process
    //     $currentRow = 0;

    //     try {
    //         // Open the file in read mode
    //         if (($handle = fopen($filePath, 'r')) !== false) {
    //             // Skip the header row if necessary
    //             $header = fgetcsv($handle);

    //             // Loop through the file line by line
    //             while (($row = fgetcsv($handle)) !== false) {
    //                 if ($currentRow >= $rowLimit) {
    //                     break; // Stop after reading the specified number of rows
    //                 }

    //                 // Map CSV columns to your model fields
    //                 $data = array_combine($header, $row);
    //                 dd($data);
    //                 // Insert row data into the database
    //                 AllModelTest::create([
    //                     'servicename' => $data['client_name'], // Adjust this to match CSV header
    //                     'brif' => $data['client_code'], // Adjust this to match CSV header
    //                 ]);

    //                 $currentRow++; // Increment the row counter
    //             }

    //             // Close the file
    //             fclose($handle);

    //             return "Data imported successfully for {$rowLimit} rows.";
    //         } else {
    //             return "Could not open the file.";
    //         }
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    // public function importLargeCSV()
    // {
    //     $filePath = storage_path('app/public/image/task/EDL_DEP_TD_DUMP_SEPT_2024.csv');
    //     $rowLimit = 10; // Process 10 rows as an example
    //     $currentRow = 0;

    //     try {
    //         // Open the file in read mode
    //         if (($handle = fopen($filePath, 'r')) !== false) {
    //             // Get the header row
    //             $headerLine = fgetcsv($handle);
    //             $header = explode('|', $headerLine[0]);

    //             // Loop through the file line by line
    //             while (($row = fgetcsv($handle)) !== false) {
    //                 if ($currentRow >= $rowLimit) {
    //                     break; // Stop after the specified number of rows
    //                 }

    //                 // Split row by '|' delimiter and combine with header
    //                 $rowData = explode('|', $row[0]);
    //                 $data = array_combine($header, $rowData);
    //                 dd($rowLimit);
    //                 // Insert mapped data into the database
    //                 AllModelTest::create([
    //                     'servicename' => $data['nomnm'] ?? null, // Adjust these keys as per CSV headers
    //                     'brif' => $data['row_id'] ?? null,
    //                 ]);

    //                 $currentRow++;
    //             }

    //             fclose($handle);

    //             return "Data imported successfully for {$rowLimit} rows.";
    //         } else {
    //             return "Could not open the file.";
    //         }
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    // public function importLargeCSV()
    // {
    //     $filePath = storage_path('app/public/image/task/EDL_DEP_TD_DUMP_SEPT_2024.csv');
    //     $rowLimit = 200; // Set the limit for how many rows you want to process
    //     $currentRow = 0;
    //     $batchData = []; // Array to hold data for batch insert

    //     try {
    //         // Open the file in read mode
    //         if (($handle = fopen($filePath, 'r')) !== false) {
    //             // Get the header row
    //             $headerLine = fgetcsv($handle);
    //             // dd($filePath);
    //             $header = explode('|', $headerLine[0]);


    //             $retrievedDates = [];
    //             // Loop through the file line by line
    //             while (($row = fgetcsv($handle)) !== false) {
    //                 if ($currentRow >= $rowLimit) {
    //                     break; // Stop after the specified number of rows
    //                 }

    //                 // Split row by '|' delimiter
    //                 $rowData = explode('|', $row[0]);

    //                 // Check if both arrays have the same number of elements
    //                 if (count($header) === count($rowData)) {
    //                     // Combine header with row data
    //                     $data = array_combine($header, $rowData);
    //                     $retrievedDates[] = $data;
    //                     // Prepare the data for batch insert
    //                     $batchData[] = [
    //                         'servicename' => $data['nomnm'] ?? null, // Adjust these keys as per CSV headers
    //                         'brif' => $data['row_id'] ?? null,
    //                     ];
    //                 } else {
    //                     // Log or handle the mismatch as needed
    //                     Log::warning("Header and row data length mismatch at row {$currentRow}: " . print_r($rowData, true));
    //                 }

    //                 $currentRow++;
    //             }

    //             // Close the file
    //             fclose($handle);
    //             // Perform batch insert into the database if there is data
    //             if (!empty($batchData)) {
    //                 AllModelTest::insert($batchData); // Use insert for batch insertion
    //             }
    //             dd($retrievedDates);

    //             return "Data imported successfully for {$currentRow} rows.";
    //         } else {
    //             return "Could not open the file.";
    //         }
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

}
//! End hare

<?php

//*
// Start Hare
//! End hare

//*number 3
// Start Hare
<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class LargeCSVImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // No need to process here since handling in controller
    }
}

//! End hare

//* number 2
// Start Hare
<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class LargeCSVImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // No need to process here since handling in controller
    }
}

//! End hare

//* Number 1
// Start Hare

namespace App\Imports;

use App\Models\AllModelTest;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class LargeCSVImport implements ToModel, WithChunkReading, WithHeadingRow
{

    // $heading = [$row['id'], $row['client_name'], $row['client_code']];
    // dd($heading);

    private $rowCount = 0;

    public function model(array $row)
    {

        // Stop import after 10 rows
        if ($this->rowCount >= 10) {
            return null;
        }

        $this->rowCount++; // Increment row counter


        // dd($row);
        // if ($row['lpt_product_name']) {
        //     return new AllModelTest([
        //         'lpt_product_name' => $row['lpt_product_name'],
        //         'asq_desc' => $row['asq_desc'],
        //         'cln_principal_balance' => $row['cln_principal_balance'],
        //         'provision_amount' => $row['provision_amount'],
        //         'outstanding' => $row['outstanding'],
        //     ]);
        // }

        // dd($row);

        if (!empty($row['lpt_product_name'])) {
            return new AllModelTest([
                'lpt_product_name' => $row['lpt_product_name'],
                'asq_desc' => $row['asq_desc'] ?? null,
                'cln_principal_balance' => $row['cln_principal_balance'] ?? null,
                'provision_amount' => $row['provision_amount'] ?? null,
                'outstanding' => $row['outstanding'] ?? null,
            ]);
        }

        // dd('hi');
    }

    public function chunkSize(): int
    {
        // return 1000;
        return 10;
    }
}
//! End hare

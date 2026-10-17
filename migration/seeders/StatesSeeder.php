<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder
{
    public function run()
    {
        DB::table('states')->insert([
            ['id' => 1, 'statename' => 'ANDHRA PRADESH', 'created_at' => null, 'updated_at' => null],
            ['id' => 2, 'statename' => 'ASSAM', 'created_at' => null, 'updated_at' => null],
            ['id' => 3, 'statename' => 'ARUNACHAL PRADESH', 'created_at' => null, 'updated_at' => null],
            ['id' => 4, 'statename' => 'BIHAR', 'created_at' => null, 'updated_at' => null],
            ['id' => 5, 'statename' => 'GUJRAT', 'created_at' => null, 'updated_at' => null],
            ['id' => 6, 'statename' => 'HARYANA', 'created_at' => null, 'updated_at' => null],
            ['id' => 7, 'statename' => 'HIMACHAL PRADESH', 'created_at' => null, 'updated_at' => null],
            ['id' => 8, 'statename' => 'JAMMU & KASHMIR', 'created_at' => null, 'updated_at' => null],
            ['id' => 9, 'statename' => 'KARNATAKA', 'created_at' => null, 'updated_at' => null],
            ['id' => 10, 'statename' => 'KERALA', 'created_at' => null, 'updated_at' => null],
            ['id' => 11, 'statename' => 'MADHYA PRADESH', 'created_at' => null, 'updated_at' => null],
            ['id' => 12, 'statename' => 'MAHARASHTRA', 'created_at' => null, 'updated_at' => null],
            ['id' => 13, 'statename' => 'MANIPUR', 'created_at' => null, 'updated_at' => null],
            ['id' => 14, 'statename' => 'MEGHALAYA', 'created_at' => null, 'updated_at' => null],
            ['id' => 15, 'statename' => 'MIZORAM', 'created_at' => null, 'updated_at' => null],
            ['id' => 16, 'statename' => 'NAGALAND', 'created_at' => null, 'updated_at' => null],
            ['id' => 17, 'statename' => 'ORISSA', 'created_at' => null, 'updated_at' => null],
            ['id' => 18, 'statename' => 'PUNJAB', 'created_at' => null, 'updated_at' => null],
            ['id' => 19, 'statename' => 'RAJASTHAN', 'created_at' => null, 'updated_at' => null],
            ['id' => 20, 'statename' => 'SIKKIM', 'created_at' => null, 'updated_at' => null],
            ['id' => 21, 'statename' => 'TAMIL NADU', 'created_at' => null, 'updated_at' => null],
            ['id' => 22, 'statename' => 'TRIPURA', 'created_at' => null, 'updated_at' => null],
            ['id' => 23, 'statename' => 'UTTAR PRADESH', 'created_at' => null, 'updated_at' => null],
            ['id' => 24, 'statename' => 'WEST BENGAL', 'created_at' => null, 'updated_at' => null],
            ['id' => 25, 'statename' => 'DELHI', 'created_at' => null, 'updated_at' => null],
            ['id' => 26, 'statename' => 'GOA', 'created_at' => null, 'updated_at' => null],
            ['id' => 27, 'statename' => 'PONDICHERY', 'created_at' => null, 'updated_at' => null],
            ['id' => 28, 'statename' => 'LAKSHDWEEP', 'created_at' => null, 'updated_at' => null],
            ['id' => 29, 'statename' => 'DAMAN & DIU', 'created_at' => null, 'updated_at' => null],
            ['id' => 30, 'statename' => 'DADRA & NAGAR', 'created_at' => null, 'updated_at' => null],
            ['id' => 31, 'statename' => 'CHANDIGARH', 'created_at' => null, 'updated_at' => null],
            ['id' => 32, 'statename' => 'ANDAMAN & NICOBAR', 'created_at' => null, 'updated_at' => null],
            ['id' => 33, 'statename' => 'UTTARANCHAL', 'created_at' => null, 'updated_at' => null],
            ['id' => 34, 'statename' => 'JHARKHAND', 'created_at' => null, 'updated_at' => null],
            ['id' => 35, 'statename' => 'CHATTISGARH', 'created_at' => null, 'updated_at' => null],
            ['id' => 36, 'statename' => 'NOIDA', 'created_at' => null, 'updated_at' => null],
            ['id' => 37, 'statename' => 'GURGAON', 'created_at' => null, 'updated_at' => null],
            ['id' => 38, 'statename' => 'UTTARAKHAND\\r\\n', 'created_at' => null, 'updated_at' => null],
            ['id' => 39, 'statename' => 'TELANGNA\\r\\n', 'created_at' => null, 'updated_at' => null],
        ]);
    }
}

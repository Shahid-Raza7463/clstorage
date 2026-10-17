<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            StatesSeeder::class,
            TitlesSeeder::class,
            AssignmentsSeeder::class,
            PagesSeeder::class,
            UsersSeeder::class,
            TeammembersSeeder::class,
            LeavetypesSeeder::class,
            LeaverolesSeeder::class,
            PermissionsSeeder::class,
            TimesheetdaySeeder::class,
            ClientsSeeder::class,
            AssignmentbudgetingsSeeder::class,
            AssignmentmappingsSeeder::class,
            AssignmentteammappingsSeeder::class,
        ]);
    }
}

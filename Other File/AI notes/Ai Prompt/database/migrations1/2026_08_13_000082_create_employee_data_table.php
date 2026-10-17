<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_data', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id', true, false);
            $table->string('emailid', 31)->nullable();
            $table->string('team_member', 26)->nullable();
            $table->string('department', 23)->nullable();
            $table->string('designation', 19)->nullable();
            $table->date('joining_date')->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('mobile_no', 15)->nullable();
            $table->string('personalemail', 30)->nullable();
            $table->string('location', 6)->nullable();
            $table->string('gender', 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_data');
    }
}

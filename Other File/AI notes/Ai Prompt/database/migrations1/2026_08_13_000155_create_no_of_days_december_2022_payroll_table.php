<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoOfDaysDecember2022PayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('no_of_days_december_2022_payroll', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id', true, false);
            $table->string('name_of_employee', 100)->nullable();
            $table->integer('no_of_days_in_month')->nullable();
            $table->integer('no_of_days_present')->nullable();
            $table->integer('casual_leave')->nullable();
            $table->integer('sick_leave')->nullable();
            $table->integer('compensatory_off')->nullable();
            $table->integer('bithday_leave')->nullable();
            $table->integer('lwp')->nullable();
            $table->integer('total_days_to_be_paid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('no_of_days_december_2022_payroll');
    }
}

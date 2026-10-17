<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrolloctoberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolloctober', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id', true, false);
            $table->string('Email', 30)->nullable();
            $table->string('Name_of_person', 20)->nullable();
            $table->string('Proposed_Entity', 19)->nullable();
            $table->string('employment_status', 10)->nullable();
            $table->string('ranges', 9)->nullable();
            $table->string('partner_incharge', 33)->nullable();
            $table->integer('monthly_gross_salary')->nullable();
            $table->integer('no_of_days_in_month')->nullable();
            $table->integer('no_of_days_present')->nullable();
            $table->integer('casual_leave')->nullable();
            $table->integer('sick_leave')->nullable();
            $table->integer('compensatory_off')->nullable();
            $table->integer('bithday_leave')->nullable();
            $table->integer('lwp')->nullable();
            $table->integer('total_days_to_be_paid')->nullable();
            $table->integer('amount')->nullable();
            $table->string('pfyn', 3)->nullable();
            $table->integer('employee_contribution')->nullable();
            $table->integer('employer_contribution')->nullable();
            $table->integer('advance')->nullable();
            $table->integer('tds')->nullable();
            $table->integer('add_gst_input')->nullable();
            $table->integer('arrear')->nullable();
            $table->integer('bonus')->nullable();
            $table->integer('total_amount_to_paid')->nullable();
            $table->string('remarks', 51)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolloctober');
    }
}

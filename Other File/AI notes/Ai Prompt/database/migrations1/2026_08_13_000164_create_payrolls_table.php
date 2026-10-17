<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->string('name_of_employee', 100)->nullable();
            $table->string('Proposed_Entity', 100)->nullable();
            $table->string('employment_status', 30)->nullable();
            $table->string('month', 20)->nullable();
            $table->string('ranges', 100)->nullable();
            $table->string('partner_incharge', 100)->nullable();
            $table->string('monthly_gross_salary', 20)->nullable();
            $table->string('no_of_days_in_month', 20)->nullable();
            $table->string('no_of_days_present', 15)->nullable();
            $table->string('casual_leave', 100)->nullable();
            $table->string('sick_leave', 100)->nullable();
            $table->string('compensatory_off', 100)->nullable();
            $table->string('bithday_leave', 15)->nullable();
            $table->string('lwp', 100)->nullable();
            $table->string('total_days_to_be_paid', 15)->nullable();
            $table->string('amount', 30)->nullable();
            $table->string('pfyn', 100)->nullable();
            $table->string('employee_contribution', 100)->nullable();
            $table->string('employer_contribution', 255)->nullable();
            $table->string('advance', 30)->nullable();
            $table->string('tds', 30)->nullable();
            $table->string('add_gst_input', 100)->nullable();
            $table->string('arrear', 30)->nullable();
            $table->string('bonus', 255)->nullable();
            $table->string('total_amount_to_paid', 30)->nullable();
            $table->string('remarks', 255)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('neftstatus')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalconveyancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localconveyances', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->integer('client_id')->nullable();
            $table->string('dateassignment', 20)->nullable();
            $table->string('place', 100)->nullable();
            $table->string('Nature', 100)->nullable();
            $table->string('Audit_from_date', 20)->nullable();
            $table->string('Audit_period_date', 30)->nullable();
            $table->string('Remarks', 255)->nullable();
            $table->integer('Status')->nullable();
            $table->string('Attendance', 255)->nullable();
            $table->string('Visiting_from_date', 20)->nullable();
            $table->string('Visiting_date', 20)->nullable();
            $table->string('leave_day', 15)->nullable();
            $table->string('totaldays', 15)->nullable();
            $table->text('correction')->nullable();
            $table->string('Approved_Conveyance', 100)->nullable();
            $table->string('Total_Value', 30)->nullable();
            $table->string('billpaid', 255)->nullable();
            $table->string('clientbill', 255)->nullable();
            $table->string('attachment', 255)->nullable();
            $table->string('Recoverable', 255)->nullable();
            $table->string('Passed', 255)->nullable();
            $table->string('Approved', 255)->nullable();
            $table->string('Total_Amount_Payable', 30)->nullable();
            $table->string('Client_Invoice_Number', 30)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
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
        Schema::dropIfExists('localconveyances');
    }
}

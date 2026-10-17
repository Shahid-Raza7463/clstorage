<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('bank_id')->nullable();
            $table->string('financialyear', 10)->nullable();
            $table->string('tax', 255)->nullable();
            $table->integer('sgst')->nullable();
            $table->integer('cgst')->nullable();
            $table->integer('igst')->nullable();
            $table->integer('nogst')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('assignment_id')->nullable();
            $table->string('assignmentgenerate_id', 30)->nullable();
            $table->integer('export')->nullable();
            $table->integer('currency')->nullable();
            $table->integer('companydetails_id')->nullable();
            $table->string('invoice_id', 30)->nullable();
            $table->text('clientaddress')->nullable();
            $table->string('gstno', 15)->nullable();
            $table->string('panno', 12)->nullable();
            $table->string('contactname', 100)->nullable();
            $table->string('contactemail', 100)->nullable();
            $table->integer('partner')->nullable();
            $table->string('remark', 255)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('paymentstatus', 30)->nullable();
            $table->string('statecode', 30)->nullable();
            $table->string('supply', 255)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
            $table->integer('assignto')->nullable();
            $table->integer('approvel')->nullable();
            $table->integer('status')->nullable();
            $table->string('natureofassignment', 100)->nullable();
            $table->string('periodassignment', 30)->nullable();
            $table->string('saccode', 30)->nullable();
            $table->string('pocketexpenseamount', 30)->nullable();
            $table->string('pocketexpensefile', 255)->nullable();
            $table->string('invoicedate', 20)->nullable();
            $table->text('service')->nullable();
            $table->string('amount', 30)->nullable();
            $table->integer('total')->nullable();
            $table->string('finalreport', 255)->nullable();
            $table->string('finalreportdate', 20)->nullable();
            $table->string('annexure', 255)->nullable();
            $table->string('appointmentletter', 255)->nullable();
            $table->text('notes')->nullable();
            $table->integer('clientdata')->nullable();
            $table->string('clientdatachange', 100)->nullable();
            $table->integer('auditdocument')->nullable();
            $table->string('duedateofrecovery', 20)->nullable();
            $table->string('auditdocumentother', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('year', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}

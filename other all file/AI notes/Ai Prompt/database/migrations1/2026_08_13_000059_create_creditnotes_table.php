<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditnotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditnotes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('client_id')->nullable();
            $table->text('clientaddress')->nullable();
            $table->string('contact_person', 100)->nullable();
            $table->string('contact_number', 30)->nullable();
            $table->string('saccode', 30)->nullable();
            $table->string('contact_mail', 100)->nullable();
            $table->string('gstno', 15)->nullable();
            $table->string('companydetails_id', 30)->nullable();
            $table->string('statecode', 30)->nullable();
            $table->string('supply', 200)->nullable();
            $table->string('credit_note_number', 30)->nullable();
            $table->string('invoice_date', 20)->nullable();
            $table->string('credit_date', 20)->nullable();
            $table->string('invoice_id', 30)->nullable();
            $table->string('amount', 30)->nullable();
            $table->integer('pocketexpenseamount')->nullable();
            $table->string('total', 30)->nullable();
            $table->string('service', 100)->nullable();
            $table->string('cgst', 200)->nullable();
            $table->bigInteger('igst')->nullable();
            $table->string('sgst', 200)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('creditnotes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debtors', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->integer('id', true, false);
            $table->integer('mailstatus')->nullable()->default(0);
            $table->string('subject', 150)->nullable();
            $table->string('assignmentgenerate_id', 30)->nullable();
            $table->integer('type')->nullable();
            $table->integer('status')->nullable()->default(2);
            $table->integer('batchstatus')->default(0);
            $table->integer('amounthidestatus')->nullable();
            $table->string('balancedate', 20)->nullable();
            $table->integer('created_by')->nullable();
            $table->string('reference_no', 30)->nullable();
            $table->string('batchname', 100)->nullable();
            $table->bigInteger('batch_id')->nullable();
            $table->string('batchclosedate', 20)->nullable();
            $table->string('customer_id', 30)->nullable();
            $table->string('name_of_the_entity', 100)->nullable();
            $table->string('ifsc', 11)->nullable();
            $table->string('branch_name', 100)->nullable();
            $table->string('branch_code', 30)->nullable();
            $table->string('branch_pin_code', 30)->nullable();
            $table->string('name_one', 100)->nullable();
            $table->string('email_one', 100)->nullable();
            $table->string('mobile_one', 15)->nullable();
            $table->string('email_cc', 100)->nullable();
            $table->string('email_bcc', 100)->nullable();
            $table->string('remarks', 50)->nullable();
            $table->string('attachment', 255)->nullable();
            $table->string('originalattachmentname', 255)->nullable();
            $table->string('pan', 12)->nullable();
            $table->string('name_two', 50)->nullable();
            $table->string('email_two', 50)->nullable();
            $table->string('mobile_two', 15)->nullable();
            $table->string('company_brach_code', 30)->nullable();
            $table->string('debtor_currency', 255)->nullable();
            $table->string('debtor_amount', 30)->nullable();
            $table->string('creditor_currency', 255)->nullable();
            $table->string('creditor_amount', 30)->nullable();
            $table->string('advance_from_customers_currency', 30)->nullable();
            $table->string('advance_from_customers_amount', 30)->nullable();
            $table->string('advance_to_suppliers_currency', 30)->nullable();
            $table->string('advance_to_suppliers_amount', 30)->nullable();
            $table->string('loan_receivable_currency', 255)->nullable();
            $table->string('loan_receivable_amount', 30)->nullable();
            $table->string('loan_payable_currency', 255)->nullable();
            $table->string('loan_payable_amount', 30)->nullable();
            $table->string('interest_receivable_currency', 255)->nullable();
            $table->string('interest_receivable_amount', 30)->nullable();
            $table->string('interest_payable_currency', 255)->nullable();
            $table->string('interest_payable_amount', 30)->nullable();
            $table->string('security_deposit_provided', 255)->nullable();
            $table->string('security_deposit_currency', 200)->nullable();
            $table->string('security_deposit_received', 255)->nullable();
            $table->string('security_deposit_received_currency', 100)->nullable();
            $table->string('secondaryemail', 100)->nullable();
            $table->string('otp', 30)->nullable();
            $table->string('otpverifydate', 20)->nullable();
            $table->string('username', 100)->nullable();
            $table->string('designation', 100)->nullable();
            $table->string('usernumber', 30)->nullable();
            $table->string('useremail', 100)->nullable();
            $table->string('userreplieddate', 20)->nullable();
            $table->date('autoreminddate')->nullable();
            $table->string('contactname', 100)->nullable();
            $table->string('contactnumber', 15)->nullable();
            $table->string('contactemail', 100)->nullable();
            $table->integer('confirmationsentby')->nullable();
            $table->string('confirmationsentdate', 20)->nullable();
            $table->string('authorisation', 100)->nullable();
            $table->text('comment')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('submit_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debtors');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('tendersubmitstatus')->default(0);
            $table->string('tenderofferedby', 255)->nullable();
            $table->string('services', 255)->nullable();
            $table->string('tenderpublishdate', 20)->nullable();
            $table->string('endrefund', 30)->nullable();
            $table->string('remarkresult', 255)->nullable();
            $table->string('acknowledgementofsubmission', 255)->nullable();
            $table->text('detailofwinner')->nullable();
            $table->string('documentsubmit', 50)->nullable();
            $table->string('prebidmeetingdate', 20)->nullable();
            $table->string('openingtenderdate', 20)->nullable();
            $table->string('organisation', 100)->nullable();
            $table->string('stamppaperrequired', 255)->nullable();
            $table->string('remarks', 255)->nullable();
            $table->string('tenderhardcopy', 255)->nullable();
            $table->string('linkedinlink', 255)->nullable();
            $table->string('currentauditors', 255)->nullable();
            $table->string('lastyear', 10)->nullable();
            $table->string('existing', 255)->nullable();
            $table->string('previousauditors', 255)->nullable();
            $table->string('emd', 255)->nullable();
            $table->text('cfo')->nullable();
            $table->string('actualdate', 20)->nullable();
            $table->string('organisationwebsite', 255)->nullable();
            $table->text('boardmembers')->nullable();
            $table->string('tenderfor', 255)->nullable();
            $table->string('tendertype', 30)->nullable();
            $table->string('tenderid', 30)->nullable();
            $table->integer('teammember_id')->nullable();
            $table->integer('enrollmentofpayment')->nullable();
            $table->string('tenderonlinesubmission', 200)->nullable();
            $table->string('amount', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phoneno', 15)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('nature', 100)->nullable();
            $table->string('result', 200)->nullable();
            $table->string('tenderfees', 30)->nullable();
            $table->string('refundstatus', 30)->nullable();
            $table->string('lowestprice', 30)->nullable();
            $table->text('winner')->nullable();
            $table->string('contactperson', 100)->nullable();
            $table->string('transactionid', 30)->nullable();
            $table->string('date', 20)->nullable();
            $table->string('infavourof', 200)->nullable();
            $table->string('pairbank', 100)->nullable();
            $table->string('ddno', 30)->nullable();
            $table->string('issuedate', 20)->nullable();
            $table->string('infavourofdd', 200)->nullable();
            $table->string('issuebank', 100)->nullable();
            $table->string('dateofexpiry', 20)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
            $table->integer('tenderproposalsubmitted')->nullable();
            $table->integer('status')->nullable();
            $table->string('tenderdate', 20)->nullable();
            $table->string('daterange', 20)->nullable();
            $table->string('publishdate', 20)->nullable();
            $table->string('tenderdocument', 255)->nullable();
            $table->integer('emdstatus')->nullable();
            $table->string('emdremarks', 255)->nullable();
            $table->string('lonecpmny', 255)->nullable();
            $table->string('loneamt', 255)->nullable();
            $table->string('ltwocpmny', 255)->nullable();
            $table->string('ltwoamt', 255)->nullable();
            $table->string('lthreecpmny', 255)->nullable();
            $table->string('lthreeamt', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenders');
    }
}

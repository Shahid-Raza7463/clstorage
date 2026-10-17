<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentbudgetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignmentbudgetings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigInteger('id', true, false);
            $table->bigInteger('client_id')->nullable();
            $table->integer('assignment_id')->nullable();
            $table->string('assignmentgenerate_id', 30)->nullable();
            $table->bigInteger('assignmentnumber')->nullable();
            $table->string('assignmentname', 100)->nullable();
            $table->string('otp', 30)->nullable();
            $table->string('otpverifydate', 20)->nullable();
            $table->integer('closedby')->nullable();
            $table->integer('billingfrequency')->nullable();
            $table->string('duedate', 20)->nullable();
            $table->string('billdate', 50)->nullable();
            $table->integer('billlingamount')->nullable();
            $table->string('finalreportdate', 20)->nullable();
            $table->string('draftreportdate', 20)->nullable();
            $table->string('moneyreceiveddate', 20)->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->string('appointment_letter', 255)->nullable();
            $table->string('balanceconfirmationotp', 30)->nullable();
            $table->integer('balanceconfirmationstatus')->default(1);
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unique(['assignmentgenerate_id'], 'assignmentgenerate_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignmentbudgetings');
    }
}

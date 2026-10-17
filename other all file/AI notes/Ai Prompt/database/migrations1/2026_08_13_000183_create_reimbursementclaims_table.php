<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReimbursementclaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reimbursementclaims', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id', true, false);
            $table->string('Date_of_Expense', 20)->nullable();
            $table->string('Type_of_Expense', 30)->nullable();
            $table->string('Approved_Amount', 30)->nullable();
            $table->string('Actual_Amount', 30)->nullable();
            $table->string('Location', 100)->nullable();
            $table->string('attachment', 255)->nullable();
            $table->integer('Approver')->nullable();
            $table->integer('Status')->nullable();
            $table->text('reason')->nullable();
            $table->string('paiddate', 20)->nullable();
            $table->string('processingdate', 20)->nullable();
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
        Schema::dropIfExists('reimbursementclaims');
    }
}

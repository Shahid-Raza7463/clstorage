<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->bigInteger('assignmentgenerate_id')->nullable();
            $table->string('invoiceid', 30)->nullable();
            $table->string('tds', 30)->nullable();
            $table->string('roundoff', 50)->nullable();
            $table->integer('tdscgst')->nullable();
            $table->integer('tdsigst')->nullable();
            $table->integer('tdssgst')->nullable();
            $table->string('amountreceived', 30)->nullable();
            $table->integer('paymentmode')->nullable();
            $table->string('paymentdate', 20)->nullable();
            $table->string('transaction_id', 30)->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('payments');
    }
}

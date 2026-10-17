<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtorconfirmationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debtorconfirmations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->string('name', 100)->nullable();
            $table->integer('debtor_id')->nullable();
            $table->string('assignmentgenerate_id', 30)->nullable();
            $table->string('bankfilename', 100)->nullable();
            $table->string('type', 30)->nullable();
            $table->string('currency', 200)->nullable();
            $table->string('correct_amount', 30)->nullable();
            $table->text('notes')->nullable();
            $table->string('confirmation', 50)->nullable();
            $table->string('attachment', 255)->nullable();
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
        Schema::dropIfExists('debtorconfirmations');
    }
}

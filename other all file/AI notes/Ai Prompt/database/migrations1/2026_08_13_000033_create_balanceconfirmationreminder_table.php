<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceconfirmationreminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balanceconfirmationreminder', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->integer('id', true, false);
            $table->integer('debtorsid');
            $table->integer('remindercount')->default(0);
            $table->string('reminderdatecount', 20)->nullable();
            $table->integer('noofdays')->default(0);
            $table->string('assignmentgenid', 30)->nullable();
            $table->string('type', 30)->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('balanceconfirmationreminder');
    }
}

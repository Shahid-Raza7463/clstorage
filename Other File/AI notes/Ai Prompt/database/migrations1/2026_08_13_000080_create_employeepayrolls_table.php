<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeepayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeepayrolls', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id', true, false);
            $table->string('month', 20)->nullable();
            $table->integer('teammember_id')->nullable();
            $table->integer('no_of_day_present')->nullable()->default(0);
            $table->integer('sl')->default(0);
            $table->integer('cl')->default(0);
            $table->integer('co')->default(0);
            $table->integer('birthday')->default(0);
            $table->integer('day_to_be_paid')->nullable()->default(0);
            $table->integer('totaldays')->default(0);
            $table->decimal('amount', 10, 2)->nullable()->default(0.00);
            $table->decimal('employee_contribution', 10, 2)->nullable()->default(0.00);
            $table->decimal('employer_contribution', 10, 2)->nullable()->default(0.00);
            $table->integer('advance')->nullable()->default(0);
            $table->integer('tds')->nullable()->default(0);
            $table->integer('Arrear')->nullable()->default(0);
            $table->integer('bonus')->nullable()->default(0);
            $table->decimal('total_amount_to_paid', 10, 2)->nullable()->default(0.00);
            $table->string('remark', 255)->nullable();
            $table->string('comment', 255)->nullable();
            $table->integer('level_one')->default(0);
            $table->integer('level_two')->default(0);
            $table->integer('level_three')->default(0);
            $table->integer('lwp')->nullable();
            $table->integer('holiday')->nullable();
            $table->integer('send_to_bank')->default(0);
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
        Schema::dropIfExists('employeepayrolls');
    }
}

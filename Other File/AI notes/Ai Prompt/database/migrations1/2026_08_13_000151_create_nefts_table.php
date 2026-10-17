<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNeftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nefts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->string('month', 20)->nullable();
            $table->string('type', 30)->nullable();
            $table->integer('teammember_id')->nullable();
            $table->string('entity', 100)->nullable();
            $table->string('name_as_per_bankaccount', 100)->nullable();
            $table->string('nameofbank', 100)->nullable();
            $table->string('bankaccountnumber', 30)->nullable();
            $table->string('ifsccode', 11)->nullable();
            $table->integer('paymenttype')->nullable();
            $table->string('totalconveyance', 30)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('status')->nullable();
            $table->integer('verify')->nullable()->default(1);
            $table->string('employeestatus', 30)->nullable();
            $table->string('paiddate', 20)->nullable();
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
        Schema::dropIfExists('nefts');
    }
}

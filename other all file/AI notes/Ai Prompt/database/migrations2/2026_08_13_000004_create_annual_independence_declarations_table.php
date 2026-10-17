<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnualIndependenceDeclarationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annual_independence_declarations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id', true, false);
            $table->integer('subsidiaries')->nullable();
            $table->string('subsidiariesother', 255)->nullable();
            $table->integer('financial')->nullable();
            $table->string('financialother', 255)->nullable();
            $table->integer('outside')->nullable();
            $table->string('outsideother', 255)->nullable();
            $table->integer('client')->nullable();
            $table->string('clientother', 100)->nullable();
            $table->integer('authority')->nullable();
            $table->string('authorityother', 255)->nullable();
            $table->integer('underwriter')->nullable();
            $table->string('underwriterother', 255)->nullable();
            $table->integer('trustee')->nullable();
            $table->string('trusteeother', 255)->nullable();
            $table->integer('spouse')->nullable();
            $table->string('spouseother', 255)->nullable();
            $table->integer('compromise')->nullable();
            $table->string('compromiseother', 255)->nullable();
            $table->integer('litigation')->nullable();
            $table->string('litigationother', 255)->nullable();
            $table->integer('relative')->nullable();
            $table->string('relativeother', 255)->nullable();
            $table->string('year', 10)->nullable();
            $table->integer('createdby')->nullable();
            $table->unsignedInteger('partner')->nullable();
            $table->integer('type')->nullable();
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
        Schema::dropIfExists('annual_independence_declarations');
    }
}

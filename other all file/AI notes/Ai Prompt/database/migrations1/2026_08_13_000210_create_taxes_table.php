<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('createdby')->nullable();
            $table->integer('year')->nullable();
            $table->integer('tax_regime')->nullable();
            $table->string('gross_salary', 30)->nullable();
            $table->string('tds', 30)->nullable();
            $table->string('anyotherincome', 30)->nullable();
            $table->string('othersection', 100)->nullable();
            $table->string('otherdescription', 255)->nullable();
            $table->string('taxamount', 30)->nullable();
            $table->string('otherattachment', 255)->nullable();
            $table->string('advancetaxamount', 30)->nullable();
            $table->string('advanceetaxattachment', 255)->nullable();
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
        Schema::dropIfExists('taxes');
    }
}

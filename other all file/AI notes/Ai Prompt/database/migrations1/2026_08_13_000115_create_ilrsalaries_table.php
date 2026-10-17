<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlrsalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilrsalaries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('clientlogin_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('type')->nullable();
            $table->integer('informationresource_id')->nullable();
            $table->string('nameoftheemployee', 100)->nullable();
            $table->string('tanoftheemployee', 255)->nullable();
            $table->string('salaryincomefilename', 255)->nullable();
            $table->string('anyotherdetailfilename', 255)->nullable();
            $table->string('employeeaddress', 255)->nullable();
            $table->string('salaryincome', 30)->nullable();
            $table->string('salaryincomefile', 255)->nullable();
            $table->string('anyotherdetail', 255)->nullable();
            $table->string('anyotherdetailfile', 255)->nullable();
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
        Schema::dropIfExists('ilrsalaries');
    }
}

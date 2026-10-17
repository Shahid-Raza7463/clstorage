<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlefilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articlefiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->string('fathersname', 100)->nullable();
            $table->string('mothersname', 100)->nullable();
            $table->string('dob', 20)->nullable();
            $table->string('doj', 20)->nullable();
            $table->string('document10th', 255)->nullable();
            $table->string('document12th', 255)->nullable();
            $table->string('documentbcom', 255)->nullable();
            $table->string('bcomcertificate', 255)->nullable();
            $table->string('noc', 255)->nullable();
            $table->string('ipcccertificate', 255)->nullable();
            $table->string('cptcertificate', 255)->nullable();
            $table->string('ipcccertificatetwo', 255)->nullable();
            $table->string('octrainingcertificate', 255)->nullable();
            $table->string('itttrainingcertificate', 255)->nullable();
            $table->string('emergencycontactnumber', 15)->nullable();
            $table->string('emergencycontactnumbertwo', 15)->nullable();
            $table->string('residenceproof', 255)->nullable();
            $table->string('residenceprooftwo', 255)->nullable();
            $table->string('pancard', 255)->nullable();
            $table->string('photograph', 255)->nullable();
            $table->string('accountname', 100)->nullable();
            $table->string('additional', 255)->nullable();
            $table->string('agreement', 255)->nullable();
            $table->string('accountholder', 255)->nullable();
            $table->string('accountnumber', 30)->nullable();
            $table->string('ifsccode', 11)->nullable();
            $table->string('branch', 100)->nullable();
            $table->string('copyof', 255)->nullable();
            $table->string('copyoftwo', 255)->nullable();
            $table->integer('createdby')->nullable();
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
        Schema::dropIfExists('articlefiles');
    }
}

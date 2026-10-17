<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleonboardingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articleonboardings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->string('name', 100)->nullable();
            $table->string('contactno', 15)->nullable();
            $table->text('currentaddress')->nullable();
            $table->text('permanentaddress')->nullable();
            $table->string('emailid', 100)->nullable();
            $table->string('cro_nro_no', 30)->nullable();
            $table->string('fathersname', 100)->nullable();
            $table->string('mothersname', 100)->nullable();
            $table->string('dob', 20)->nullable();
            $table->string('doj', 20)->nullable();
            $table->string('document10th', 255)->nullable();
            $table->string('document12th', 255)->nullable();
            $table->string('documentbcom', 255)->nullable();
            $table->string('bcomcertificate', 255)->nullable();
            $table->string('bachelorattached', 255)->nullable();
            $table->string('documentbachelor', 255)->nullable();
            $table->string('noc', 255)->nullable();
            $table->string('nda', 255)->nullable();
            $table->string('ipcccertificate', 255)->nullable();
            $table->string('cptcertificate', 255)->nullable();
            $table->string('ipcccertificatetwo', 255)->nullable();
            $table->string('octrainingcertificate', 255)->nullable();
            $table->string('itttrainingcertificate', 255)->nullable();
            $table->string('emergency_contact_number', 13)->nullable();
            $table->string('emergencycontactnumber', 15)->nullable();
            $table->string('emergencycontactnumbertwo', 15)->nullable();
            $table->string('residenceproof', 255)->nullable();
            $table->string('residenceprooftwo', 255)->nullable();
            $table->string('pancard', 255)->nullable();
            $table->string('pancardno', 12)->nullable();
            $table->string('aadharcard', 255)->nullable();
            $table->string('aadharno', 12)->nullable();
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
            $table->integer('role')->nullable();
            $table->string('department', 100)->nullable();
            $table->string('dateofjoining', 20)->nullable();
            $table->string('designation', 100)->nullable();
            $table->string('stampaper', 255)->nullable();
            $table->string('gender', 30)->nullable();
            $table->string('linkedin', 100)->nullable();
            $table->string('qualification', 100)->nullable();
            $table->text('about')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('articleonboardings');
    }
}

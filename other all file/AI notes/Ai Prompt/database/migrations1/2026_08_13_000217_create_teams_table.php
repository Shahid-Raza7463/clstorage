<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->integer('id', true, false);
            $table->integer('title_id')->nullable();
            $table->string('team_member', 100)->nullable();
            $table->string('mobile_no', 15)->nullable();
            $table->string('emailid', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('personalemail', 100)->nullable();
            $table->string('profilepic', 100)->nullable();
            $table->string('fathername', 100)->nullable();
            $table->string('dateofbirth', 20)->nullable();
            $table->string('pancardno', 12)->nullable();
            $table->string('emergencycontactnumber', 15)->nullable();
            $table->string('adharcardnumber', 16)->nullable();
            $table->string('nameofbank', 100)->nullable();
            $table->string('bankaccountnumber', 30)->nullable();
            $table->string('ifsccode', 11)->nullable();
            $table->string('mothername', 100)->nullable();
            $table->string('mothernumber', 15)->nullable();
            $table->string('fathernumber', 15)->nullable();
            $table->string('panupload', 100)->nullable();
            $table->text('address_proof')->nullable();
            $table->string('designation', 100)->nullable();
            $table->string('addressupload', 200)->nullable();
            $table->integer('role_id')->nullable();
            $table->string('teamlead', 100)->nullable();
            $table->string('qualification', 100)->nullable();
            $table->text('permanentaddress')->nullable();
            $table->text('communicationaddress')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('leavingdate', 20)->nullable();
            $table->text('reasonofleaving')->nullable();
            $table->string('dateofresign', 20)->nullable();
            $table->integer('created_by')->nullable();
            $table->string('location', 100)->nullable();
            $table->integer('status')->nullable()->default(0);
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
        Schema::dropIfExists('teams');
    }
}

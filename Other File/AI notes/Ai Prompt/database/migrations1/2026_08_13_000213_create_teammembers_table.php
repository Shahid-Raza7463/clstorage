<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeammembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('teammembers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->increments('id');
            $table->string('staffcode', 30)->nullable();
            $table->string('staffcodenumber', 30)->nullable();
            $table->unsignedInteger('mentor_id')->nullable();
            $table->unsignedInteger('title_id')->nullable();
            $table->string('team_member', 100)->nullable();
            $table->string('entity', 100)->nullable();
            $table->string('employment_status', 30)->nullable();
            $table->string('mobile_no', 15)->nullable();
            $table->string('emailid', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('personalemail', 100)->nullable();
            $table->string('profilepic', 255)->nullable();
            $table->string('fathername', 100)->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('pancardno', 12)->nullable();
            $table->string('emergencycontactnumber', 15)->nullable();
            $table->string('adharcardnumber', 16)->nullable();
            $table->string('aadharupload', 255)->nullable();
            $table->string('nameasperbank', 100)->nullable();
            $table->string('nameofbank', 100)->nullable();
            $table->string('bankaccountnumber', 20)->nullable();
            $table->string('ifsccode', 11)->nullable();
            $table->string('cancelcheque', 255)->nullable();
            $table->string('mothername', 100)->nullable();
            $table->string('mothernumber', 15)->nullable();
            $table->string('fathernumber', 15)->nullable();
            $table->string('panupload', 255)->nullable();
            $table->text('address_proof')->nullable();
            $table->string('designation', 100)->nullable();
            $table->string('addressupload', 255)->nullable();
            $table->string('originalcancelcheque', 255)->nullable();
            $table->string('originalappointment_letter', 255)->nullable();
            $table->string('originalnda', 255)->nullable();
            $table->string('originalpanupload', 255)->nullable();
            $table->string('originaladdressupload', 255)->nullable();
            $table->string('originalaadharupload', 255)->nullable();
            $table->unsignedInteger('role_id')->nullable();
            $table->string('teamlead', 100)->nullable();
            $table->string('qualification', 100)->nullable();
            $table->string('appointment_letter', 255)->nullable();
            $table->string('nda', 255)->nullable();
            $table->text('permanentaddress')->nullable();
            $table->text('communicationaddress')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('rejoining_date')->nullable();
            $table->date('leavingdate')->nullable();
            $table->text('reasonofleaving')->nullable();
            $table->date('dateofresign')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->string('location', 100)->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('linkedin', 255)->nullable();
            $table->text('about')->nullable();
            $table->tinyInteger('status')->nullable()->default(0);
            $table->tinyInteger('timesheet_access')->default(0);
            $table->tinyInteger('verify')->nullable();
            $table->tinyInteger('relievingstatus')->nullable();
            $table->string('category', 30)->nullable();
            $table->unsignedInteger('cost_hour')->nullable();
            $table->string('salary_range', 20)->nullable()->default('0');
            $table->unsignedInteger('monthly_gross_salary')->default(0);
            $table->string('pf_applicable', 5)->nullable();
            $table->string('timesheet_applicable', 10)->nullable();
            $table->string('taxtds', 10)->nullable();
            $table->string('taxgrosssalary', 10)->nullable();
            $table->string('taxpf', 10)->nullable();
            $table->string('change_type', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teammembers');
    }
}

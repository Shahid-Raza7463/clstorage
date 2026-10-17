<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateonboardingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidateonboardings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->integer('reportinghead')->nullable();
            $table->string('your_full_name', 100)->nullable();
            $table->string('dateofbirth', 20)->nullable();
            $table->integer('providend')->nullable();
            $table->text('membershipnumber')->nullable();
            $table->string('pfformupload', 100)->nullable();
            $table->string('uan', 50)->nullable();
            $table->string('outupload', 100)->nullable();
            $table->text('highestqualification')->nullable();
            $table->integer('role')->nullable();
            $table->integer('department')->nullable();
            $table->string('dateofjoining', 20)->nullable();
            $table->string('personal_email', 100)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('designation', 100)->nullable();
            $table->text('currentaddress')->nullable();
            $table->text('permanentaddress')->nullable();
            $table->string('phoneno', 15)->nullable();
            $table->string('mothecontactno', 15)->nullable();
            $table->string('mother_name', 100)->nullable();
            $table->string('father_name', 100)->nullable();
            $table->string('fathercontactno', 15)->nullable();
            $table->string('resume', 255)->nullable();
            $table->string('nda', 255)->nullable();
            $table->string('marksheet_x', 255)->nullable();
            $table->string('marksheet_xii', 255)->nullable();
            $table->string('bachelor_degree', 255)->nullable();
            $table->string('master_degree', 255)->nullable();
            $table->string('marksheet_ipcc', 255)->nullable();
            $table->string('ca_final', 255)->nullable();
            $table->string('membership_certificate', 255)->nullable();
            $table->string('addidation_qualification', 100)->nullable();
            $table->string('offerappointmentletter', 255)->nullable();
            $table->string('payslipsone', 255)->nullable();
            $table->string('payslipstwo', 255)->nullable();
            $table->string('payslipsthree', 255)->nullable();
            $table->string('relieving_letter', 255)->nullable();
            $table->string('residence_proofone', 255)->nullable();
            $table->string('residence_prooftwo', 255)->nullable();
            $table->string('pancard', 255)->nullable();
            $table->string('pancardno', 11)->nullable();
            $table->string('photograph', 255)->nullable();
            $table->string('aadharcard', 255)->nullable();
            $table->string('adharcardno', 16)->nullable();
            $table->string('bankholder_name', 100)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('account_number', 30)->nullable();
            $table->string('ifsc_code', 11)->nullable();
            $table->string('branch', 100)->nullable();
            $table->string('emergency_name', 100)->nullable();
            $table->string('emergency_relation', 255)->nullable();
            $table->string('emergency_contact_number', 15)->nullable();
            $table->string('emergency1_name', 100)->nullable();
            $table->string('emergency1_relation', 255)->nullable();
            $table->string('emergency1_number', 15)->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->string('gender', 30)->nullable();
            $table->string('linkedin', 255)->nullable();
            $table->text('about');
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
        Schema::dropIfExists('candidateonboardings');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffappointmentlettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffappointmentletters', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->integer('teammember_id')->nullable();
            $table->date('appointmentletterdate')->nullable();
            $table->string('designation', 42)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->date('employeeeffectivedate')->nullable();
            $table->string('organization', 8)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('location', 6)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->integer('salary')->nullable();
            $table->string('salaryremarks', 255)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->integer('noticeperiod')->nullable();
            $table->integer('e_verify')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('otpdate', 20)->nullable();
            $table->integer('otp')->nullable();
            $table->integer('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffappointmentletters');
    }
}

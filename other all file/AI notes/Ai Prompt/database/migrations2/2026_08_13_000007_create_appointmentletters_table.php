<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentlettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointmentletters', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('assignment_id')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->unsignedInteger('teammember_id')->nullable();
            $table->string('Name', 100)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Nature_of_service', 100)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Financial_Year', 10)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Appointment_start_date', 20)->nullable();
            $table->string('Appointment_end_date', 20)->nullable();
            $table->string('Period_of_Appointment', 30)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('types_of_industry', 100)->nullable();
            $table->string('attachment', 255)->nullable();
            $table->string('createdby', 100)->nullable();
            $table->string('updatedby', 100)->nullable();
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
        Schema::dropIfExists('appointmentletters');
    }
}

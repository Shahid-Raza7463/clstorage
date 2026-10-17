<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFullandfinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fullandfinals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id', true, false);
            $table->integer('Name')->nullable();
            $table->string('Designation', 100)->nullable();
            $table->integer('Reporting_Head')->nullable();
            $table->string('Date_of_Joining', 20)->nullable();
            $table->string('Date_of_Resignation', 20)->nullable();
            $table->string('Date_of_Leaving', 20)->nullable();
            $table->string('Notice_Period_Served', 30)->nullable();
            $table->integer('Status')->nullable();
            $table->integer('Assignment_Data_Hanover')->nullable();
            $table->integer('Laptop_Hanover')->nullable();
            $table->integer('Final_Status_of_Full_and_Final')->nullable();
            $table->string('Full_and_Final_to_be_released', 255)->nullable();
            $table->text('Reason_of_Leaving')->nullable();
            $table->text('remark')->nullable();
            $table->string('approved_date', 20)->nullable();
            $table->integer('fnfstatus')->nullable();
            $table->integer('kycstatus')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
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
        Schema::dropIfExists('fullandfinals');
    }
}

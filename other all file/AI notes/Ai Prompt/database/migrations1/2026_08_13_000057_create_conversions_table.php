<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->string('Client_Name', 100)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Contact_Person', 255)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Email_ID', 100)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Mobile_No', 15)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Partner', 100)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Mail_Sent_or_not', 50)->nullable();
            $table->string('Acknowledged', 50)->nullable();
            $table->string('file', 255)->nullable();
            $table->string('date', 20)->nullable();
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
        Schema::dropIfExists('conversions');
    }
}

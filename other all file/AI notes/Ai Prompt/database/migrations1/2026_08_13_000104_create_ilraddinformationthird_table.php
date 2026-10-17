<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlraddinformationthirdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilraddinformationthird', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('informationresource_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('clientlogin_id')->nullable();
            $table->string('Name_of_Partnership', 100)->nullable();
            $table->string('Share_of_profit', 255)->nullable();
            $table->string('Remuneration', 255)->nullable();
            $table->string('Interest', 255)->nullable();
            $table->string('Profit', 255)->nullable();
            $table->string('Capital_Balance', 255)->nullable();
            $table->string('Expenses', 255)->nullable();
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
        Schema::dropIfExists('ilraddinformationthird');
    }
}

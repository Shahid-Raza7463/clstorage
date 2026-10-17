<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlraddinformationfirstTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilraddinformationfirst', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('informationresource_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('clientlogin_id')->nullable();
            $table->string('nameofthecompany', 100)->nullable();
            $table->string('pann', 12)->nullable();
            $table->string('companytype', 30)->nullable();
            $table->string('whethershare', 255)->nullable();
            $table->string('director', 255)->nullable();
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
        Schema::dropIfExists('ilraddinformationfirst');
    }
}

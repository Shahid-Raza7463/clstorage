<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlrfromsourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilrfromsources', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('client_id')->nullable();
            $table->integer('type')->nullable();
            $table->integer('clientlogin_id')->nullable();
            $table->integer('informationresource_id')->nullable();
            $table->string('interestfromsaving', 255)->nullable();
            $table->string('interestfromsavingfile', 255)->nullable();
            $table->string('interestfromfdr', 255)->nullable();
            $table->string('interestfromfdrfile', 255)->nullable();
            $table->string('other', 255)->nullable();
            $table->string('otherfile', 255)->nullable();
            $table->string('anyother', 255)->nullable();
            $table->string('anyotherfile', 255)->nullable();
            $table->string('dividend', 255)->nullable();
            $table->string('dividendfile', 255)->nullable();
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
        Schema::dropIfExists('ilrfromsources');
    }
}

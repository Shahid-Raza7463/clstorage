<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlrpersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilrpersonals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('clientlogin_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('informationresource_id')->nullable();
            $table->string('name', 100)->nullable();
            $table->string('fathersname', 100)->nullable();
            $table->string('pan', 12)->nullable();
            $table->string('panfile', 255)->nullable();
            $table->string('panfilename', 255)->nullable();
            $table->string('adharnofilename', 16)->nullable();
            $table->string('dateofbirth', 20)->nullable();
            $table->string('adharno', 16)->nullable();
            $table->string('adharnofile', 16)->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('ilrpersonals');
    }
}

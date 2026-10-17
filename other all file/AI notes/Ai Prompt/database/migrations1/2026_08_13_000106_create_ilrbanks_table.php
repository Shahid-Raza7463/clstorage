<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlrbanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilrbanks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('clientlogin_id')->nullable();
            $table->integer('informationresource_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('accountno', 30)->nullable();
            $table->string('type', 30)->nullable();
            $table->text('address')->nullable();
            $table->string('ifsc', 11)->nullable();
            $table->string('otherdetail', 255)->nullable();
            $table->string('bankstatement', 100)->nullable();
            $table->string('bankstatementname', 100)->nullable();
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
        Schema::dropIfExists('ilrbanks');
    }
}

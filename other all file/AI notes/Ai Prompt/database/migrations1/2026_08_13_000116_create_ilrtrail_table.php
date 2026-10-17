<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlrtrailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilrtrail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('downloadid')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('clientlogin_id')->nullable();
            $table->string('description', 255)->nullable();
            $table->string('pagetitle', 50)->nullable();
            $table->string('pageid', 30)->nullable();
            $table->string('type', 30)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->integer('page_id')->nullable();
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
        Schema::dropIfExists('ilrtrail');
    }
}

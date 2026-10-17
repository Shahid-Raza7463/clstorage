<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlrfoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilrfolders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('client_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('createdby')->nullable();
            $table->string('name', 100)->nullable();
            $table->string('color', 200)->nullable();
            $table->string('icon', 200)->nullable();
            $table->integer('status')->nullable();
            $table->integer('interviewstatus')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('clientloginid')->nullable();
            $table->string('documentuploaddate', 200)->nullable();
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
        Schema::dropIfExists('ilrfolders');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientloginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientlogins', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('interviewer')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->integer('assignirl')->nullable();
            $table->integer('limitedaccess')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('password', 200)->nullable();
            $table->integer('mailstatus')->nullable();
            $table->integer('twofactorauthentication')->nullable();
            $table->string('remember_token', 200)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('phoneno', 15)->nullable();
            $table->string('permission', 20)->nullable();
            $table->string('status', 30)->nullable();
            $table->integer('type')->nullable();
            $table->unsignedInteger('createdby')->nullable();
            $table->unsignedInteger('updatedby')->nullable();
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
        Schema::dropIfExists('clientlogins');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('createdby')->default(0);
            $table->string('connectionname', 100)->nullable();
            $table->string('linkedin', 255)->nullable();
            $table->string('emailid', 100)->nullable();
            $table->string('phoneno', 15)->nullable();
            $table->string('connectedthrough', 255)->nullable();
            $table->string('connectedemail', 100)->nullable();
            $table->string('connectedphone', 15)->nullable();
            $table->string('relationshipthrough', 255)->nullable();
            $table->text('othercomments')->nullable();
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
        Schema::dropIfExists('connections');
    }
}

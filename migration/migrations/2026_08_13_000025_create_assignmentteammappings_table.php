<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentteammappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignmentteammappings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->bigInteger('assignmentmapping_id')->nullable();
            $table->unsignedInteger('teammember_id')->nullable();
            $table->string('type', 20)->nullable();
            $table->string('fromdate', 20)->nullable();
            $table->string('todate', 20)->nullable();
            $table->integer('status')->default(1);
            $table->integer('viewerteam')->nullable();
            $table->string('teamhour', 30)->nullable();
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
        Schema::dropIfExists('assignmentteammappings');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentmappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignmentmappings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigInteger('id', true, false);
            $table->string('assignmentgenerate_id', 30)->nullable();
            $table->integer('assignment_id')->nullable();
            $table->unsignedInteger('leadpartner')->nullable();
            $table->unsignedInteger('otherpartner')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('periodend', 30)->nullable();
            $table->string('periodstart', 30)->nullable();
            $table->string('year', 10)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('fees', 30)->nullable();
            $table->string('gst', 255)->nullable();
            $table->integer('roleassignment')->nullable();
            $table->integer('independenceform')->nullable();
            $table->string('esthours', 30)->nullable();
            $table->string('stdcost', 30)->nullable();
            $table->string('estcost', 10)->nullable();
            $table->string('filecreationdate', 20)->nullable();
            $table->string('modifieddate', 20)->nullable();
            $table->string('auditcompletiondate', 20)->nullable();
            $table->string('documentationdate', 20)->nullable();
            $table->string('leadpartnerhour', 30)->nullable();
            $table->string('otherpartnerhour', 30)->nullable();
            $table->index(['assignmentgenerate_id'], 'assignmentmappings_assignmentgenerate_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignmentmappings');
    }
}

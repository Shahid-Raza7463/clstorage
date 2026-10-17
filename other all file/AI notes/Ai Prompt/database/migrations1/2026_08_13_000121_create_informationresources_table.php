<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationresourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informationresources', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('client_id')->nullable();
            $table->integer('ilrfolder_id')->nullable();
            $table->string('category', 30)->nullable();
            $table->text('question')->nullable();
            $table->integer('uploadedbyclient')->nullable();
            $table->string('document', 255)->nullable();
            $table->integer('status')->nullable();
            $table->integer('permission')->nullable();
            $table->text('remark')->nullable();
            $table->string('url', 255)->nullable();
            $table->text('Reviewersmarks')->nullable();
            $table->text('incubatee_self_evaluation')->nullable();
            $table->text('mentor_comment')->nullable();
            $table->integer('uploadedby')->nullable();
            $table->integer('updateby')->nullable();
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
        Schema::dropIfExists('informationresources');
    }
}

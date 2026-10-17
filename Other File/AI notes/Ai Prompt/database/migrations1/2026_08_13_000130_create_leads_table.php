<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('client_id')->nullable();
            $table->integer('teammember_id')->nullable();
            $table->string('client_names', 100)->nullable();
            $table->string('contactperson', 100)->nullable();
            $table->string('contactemail', 100)->nullable();
            $table->string('contactphone', 15)->nullable();
            $table->string('designation', 100)->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->string('servicetype', 30)->nullable();
            $table->text('remark')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('concernpartner')->nullable();
            $table->string('commercials', 255)->nullable();
            $table->string('lastmeetingdate', 20)->nullable();
            $table->integer('status')->nullable();
            $table->integer('updatedby')->nullable();
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
        Schema::dropIfExists('leads');
    }
}

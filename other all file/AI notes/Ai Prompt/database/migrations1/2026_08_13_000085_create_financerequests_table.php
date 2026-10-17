<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancerequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financerequests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->string('modal_name', 100)->nullable();
            $table->integer('assetstatus')->nullable();
            $table->string('sno', 30)->nullable();
            $table->string('company_name', 100)->nullable();
            $table->string('mac_address', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('dateofprocurement', 20)->nullable();
            $table->string('kgs', 255)->nullable();
            $table->integer('teammemberid')->nullable();
            $table->string('amount', 30)->nullable();
            $table->string('problem', 255)->nullable();
            $table->string('solution', 255)->nullable();
            $table->string('comment', 255)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('acknowledge')->nullable()->default(0);
            $table->integer('updatedby')->nullable();
            $table->integer('status')->nullable();
            $table->integer('teammember_id')->nullable();
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
        Schema::dropIfExists('financerequests');
    }
}

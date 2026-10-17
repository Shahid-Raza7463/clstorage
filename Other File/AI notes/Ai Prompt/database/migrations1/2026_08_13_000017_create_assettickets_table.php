<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetticketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assettickets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('asset_id')->nullable();
            $table->integer('generateticket_id')->nullable();
            $table->string('subject', 150)->nullable();
            $table->integer('priority')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->text('message')->nullable();
            $table->string('attachment', 255)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('assign_id')->nullable();
            $table->integer('type')->nullable();
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
        Schema::dropIfExists('assettickets');
    }
}

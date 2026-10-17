<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->string('type', 30)->nullable();
            $table->string('item_name', 100)->nullable();
            $table->string('quantity', 255)->nullable();
            $table->string('date_time', 20)->nullable();
            $table->string('item_detail', 100)->nullable();
            $table->string('price', 30)->nullable();
            $table->string('approvedby', 255)->nullable();
            $table->string('item_type', 30)->nullable();
            $table->string('expected_date', 20)->nullable();
            $table->string('sender_name', 100)->nullable();
            $table->string('item_value', 100)->nullable();
            $table->string('receiver', 255)->nullable();
            $table->integer('out_status')->nullable();
            $table->string('reject_for_reaction', 30)->nullable();
            $table->integer('status')->nullable();
            $table->integer('createdby')->nullable();
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
        Schema::dropIfExists('materials');
    }
}

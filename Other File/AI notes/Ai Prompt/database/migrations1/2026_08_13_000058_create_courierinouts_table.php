<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourierinoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courierinouts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->integer('type')->nullable();
            $table->string('tracking', 255)->nullable();
            $table->string('courier_item_name', 100)->nullable();
            $table->integer('assignedto')->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('priority')->nullable();
            $table->integer('status')->nullable();
            $table->string('courier_service', 100)->nullable();
            $table->integer('courier_charges')->nullable();
            $table->string('estimated_date_of_delivery_date', 20)->nullable();
            $table->string('tracking_image', 255)->nullable();
            $table->string('attachment', 255)->nullable();
            $table->integer('handover_to')->nullable();
            $table->string('date_time', 20)->nullable();
            $table->integer('in_status')->nullable();
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
        Schema::dropIfExists('courierinouts');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitylogsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activitylogs_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->bigInteger('id', true, false);
            $table->string('activitytitle', 150)->nullable();
            $table->string('module', 50);
            $table->bigInteger('record_id')->nullable();
            $table->string('action', 30)->nullable();
            $table->bigInteger('performed_by')->nullable();
            $table->integer('teammember_id')->nullable();
            $table->longText('old_data')->nullable()->collation('utf8mb4_bin');
            $table->longText('new_data')->nullable()->collation('utf8mb4_bin');
            $table->longText('changed_fields')->nullable()->collation('utf8mb4_bin');
            $table->string('ip_address', 45)->nullable();
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
        Schema::dropIfExists('activitylogs_details');
    }
}

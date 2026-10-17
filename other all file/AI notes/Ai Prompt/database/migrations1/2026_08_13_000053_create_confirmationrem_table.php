<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmationremTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmationrem', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->integer('id', true, false);
            $table->string('assignmentgenid', 30)->nullable();
            $table->integer('noofdays')->nullable()->default(0);
            $table->integer('max_rem')->nullable()->default(0);
            $table->integer('remindcount')->default(0);
            $table->string('created_by', 200)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
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
        Schema::dropIfExists('confirmationrem');
    }
}

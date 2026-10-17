<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutstandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outstandings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->string('DATE', 20)->nullable();
            $table->string('BILL_NO', 100)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('CLIENT_NAME', 76)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->integer('AMT')->nullable();
            $table->integer('Partner')->nullable();
            $table->string('Status', 5)->nullable()->charset('utf8')->collation('utf8_general_ci');
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
        Schema::dropIfExists('outstandings');
    }
}

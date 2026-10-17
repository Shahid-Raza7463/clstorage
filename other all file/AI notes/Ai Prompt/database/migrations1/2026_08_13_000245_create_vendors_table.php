<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->string('email', 100)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('phoneno', 15)->nullable();
            $table->string('vendorname', 100)->nullable();
            $table->string('benficiaryname', 100)->nullable();
            $table->string('bankname', 100)->nullable();
            $table->string('ifsccode', 11)->nullable();
            $table->string('accountnumber', 30)->nullable();
            $table->string('gstno', 15)->nullable();
            $table->string('pan', 12)->nullable();
            $table->string('panfile', 255)->nullable();
            $table->string('adhar', 16)->nullable();
            $table->string('adharfile', 255)->nullable();
            $table->integer('linksend')->nullable();
            $table->integer('type')->nullable();
            $table->text('vendoraddress')->nullable();
            $table->integer('createdby')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}

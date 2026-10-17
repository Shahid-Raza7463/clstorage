<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlraddinformationsecondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilraddinformationsecond', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('informationresource_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('clientlogin_id')->nullable();
            $table->string('Name_of_the', 100)->nullable();
            $table->string('pannn', 12)->nullable();
            $table->string('Company', 100)->nullable();
            $table->string('Opening_Balance', 255)->nullable();
            $table->string('Cost_of', 30)->nullable();
            $table->string('Number_of_shares', 30)->nullable();
            $table->string('Date_of', 20)->nullable();
            $table->string('Face', 255)->nullable();
            $table->string('Issue_price', 30)->nullable();
            $table->string('Purchase_price', 30)->nullable();
            $table->string('of_Shares', 255)->nullable();
            $table->string('Sales_Consideration', 255)->nullable();
            $table->string('Closing_Balance', 255)->nullable();
            $table->string('Cost_of_Acquisition', 30)->nullable();
            $table->string('beneficiary', 255)->nullable();
            $table->string('authority', 255)->nullable();
            $table->string('outside', 255)->nullable();
            $table->string('Non_Resident', 255)->nullable();
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
        Schema::dropIfExists('ilraddinformationsecond');
    }
}

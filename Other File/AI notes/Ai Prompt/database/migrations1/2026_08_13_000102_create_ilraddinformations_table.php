<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlraddinformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilraddinformations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('informationresource_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('type')->nullable();
            $table->integer('clientlogin_id')->nullable();
            $table->string('Have_you', 255)->nullable();
            $table->string('Have_you_incurred', 255)->nullable();
            $table->string('Have_you_incurred_expenditure', 255)->nullable();
            $table->string('Name_of_Partnership', 100)->nullable();
            $table->string('Share_of_profit', 255)->nullable();
            $table->string('Remuneration', 255)->nullable();
            $table->string('Interest', 255)->nullable();
            $table->string('Profit', 255)->nullable();
            $table->string('Capital_Balance', 255)->nullable();
            $table->string('Expenses', 255)->nullable();
            $table->string('Name_of_the_Company', 100)->nullable();
            $table->string('PAN', 12)->nullable();
            $table->string('Company_Type', 30)->nullable();
            $table->string('Whether_share', 255)->nullable();
            $table->string('DIN', 255)->nullable();
            $table->string('Name_of_the', 100)->nullable();
            $table->string('PANN', 255)->nullable();
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
            $table->string('incometaxcomputation', 30)->nullable();
            $table->string('incometaxcomputationname', 100)->nullable();
            $table->string('itrform', 255)->nullable();
            $table->string('itrformname', 100)->nullable();
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
        Schema::dropIfExists('ilraddinformations');
    }
}

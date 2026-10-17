<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetprocurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assetprocurements', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->string('companyname', 100)->nullable();
            $table->string('itemname', 100)->nullable();
            $table->string('startdate', 20)->nullable();
            $table->string('enddate', 20)->nullable();
            $table->string('placeofpurchase', 100)->nullable();
            $table->integer('teammember_id')->nullable();
            $table->string('amount', 30)->nullable();
            $table->string('bill', 255)->nullable();
            $table->integer('paymenttype')->nullable();
            $table->string('remark', 255)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('Status')->nullable();
            $table->string('payment', 30)->nullable();
            $table->string('processingdate', 20)->nullable();
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
        Schema::dropIfExists('assetprocurements');
    }
}

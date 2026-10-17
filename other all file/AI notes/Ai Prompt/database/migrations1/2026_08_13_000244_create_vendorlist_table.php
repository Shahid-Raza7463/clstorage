<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendorlist', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->integer('vendor_id')->nullable();
            $table->string('itemname', 100)->nullable();
            $table->string('amount', 30)->nullable();
            $table->string('bill', 255)->nullable();
            $table->integer('approver')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('status')->nullable();
            $table->text('remark')->nullable();
            $table->string('payment', 30)->nullable();
            $table->string('paymentdate', 20)->nullable();
            $table->string('paiddate', 20)->nullable();
            $table->string('approvedate', 20)->nullable();
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
        Schema::dropIfExists('vendorlist');
    }
}

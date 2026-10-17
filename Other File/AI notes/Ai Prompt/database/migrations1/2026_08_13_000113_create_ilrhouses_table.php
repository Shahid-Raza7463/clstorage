<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlrhousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilrhouses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('clientlogin_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('type')->nullable();
            $table->integer('informationresource_id')->nullable();
            $table->string('house_type', 30)->nullable();
            $table->string('tenant_name', 100)->nullable();
            $table->string('tenant_adhar', 16)->nullable();
            $table->string('tenant_pan', 12)->nullable();
            $table->string('address_of_house_property', 255)->nullable();
            $table->string('rent_received', 255)->nullable();
            $table->string('rent_receivedfile', 255)->nullable();
            $table->string('rent_amount', 30)->nullable();
            $table->string('rent_amountfile', 255)->nullable();
            $table->string('rent_receivedfilename', 255)->nullable();
            $table->string('rent_amountfilename', 255)->nullable();
            $table->string('tax_paidfilename', 255)->nullable();
            $table->string('paymentfilename', 255)->nullable();
            $table->string('anyotherdetailsfilename', 255)->nullable();
            $table->string('period_vacancy', 30)->nullable();
            $table->string('tax_paid', 30)->nullable();
            $table->string('tax_paidfile', 255)->nullable();
            $table->string('payment', 30)->nullable();
            $table->string('paymentfile', 255)->nullable();
            $table->string('ownership', 255)->nullable();
            $table->string('anyotherdetails', 255)->nullable();
            $table->string('anyotherdetailsfile', 255)->nullable();
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
        Schema::dropIfExists('ilrhouses');
    }
}

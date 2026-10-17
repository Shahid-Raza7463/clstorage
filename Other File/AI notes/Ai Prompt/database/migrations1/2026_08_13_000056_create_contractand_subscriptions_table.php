<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractandSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractand_subscriptions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->integer('kgsentity')->nullable();
            $table->string('warranty', 255)->nullable();
            $table->string('natureofitem', 100)->nullable();
            $table->string('services', 255)->nullable();
            $table->string('dateofcontact', 20)->nullable();
            $table->string('expirydate', 20)->nullable();
            $table->string('contactperson', 100)->nullable();
            $table->string('renewaldue', 255)->nullable();
            $table->string('saleservices', 255)->nullable();
            $table->string('companyname', 100)->nullable();
            $table->string('amount', 30)->nullable();
            $table->string('contactemailid', 100)->nullable();
            $table->string('teammember_id', 30)->nullable();
            $table->integer('Status')->nullable();
            $table->string('createdby', 50)->nullable();
            $table->string('updatedby', 50)->nullable();
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
        Schema::dropIfExists('contractand_subscriptions');
    }
}

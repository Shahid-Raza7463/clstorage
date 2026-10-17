<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlrfromcapitalgainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilrfromcapitalgains', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('clientlogin_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('type')->nullable();
            $table->integer('informationresource_id')->nullable();
            $table->string('assetsold', 255)->nullable();
            $table->string('saledeed', 255)->nullable();
            $table->string('saledeedfile', 255)->nullable();
            $table->string('purchasedate', 20)->nullable();
            $table->string('purchasedeed', 255)->nullable();
            $table->string('purchasedeedfile', 255)->nullable();
            $table->string('purchasedeedfilename', 255)->nullable();
            $table->string('costfilename', 255)->nullable();
            $table->string('anyinvestmentfilename', 255)->nullable();
            $table->string('mutualfundfilename', 255)->nullable();
            $table->string('Purchasefilename', 255)->nullable();
            $table->string('capitalgainfilename', 255)->nullable();
            $table->string('otherfilename', 255)->nullable();
            $table->string('saledeedfilename', 255)->nullable();
            $table->string('cost', 30)->nullable();
            $table->string('costfile', 255)->nullable();
            $table->string('anyinvestment', 255)->nullable();
            $table->string('anyinvestmentfile', 255)->nullable();
            $table->string('mutualfund', 255)->nullable();
            $table->string('mutualfundfile', 255)->nullable();
            $table->string('Purchase', 255)->nullable();
            $table->string('Purchasefile', 255)->nullable();
            $table->string('capitalgain', 255)->nullable();
            $table->string('capitalgainfile', 255)->nullable();
            $table->string('otherfile', 255)->nullable();
            $table->string('other', 255)->nullable();
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
        Schema::dropIfExists('ilrfromcapitalgains');
    }
}

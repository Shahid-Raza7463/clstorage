<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlrdeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilrdeductions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('informationresource_id')->nullable();
            $table->integer('clientlogin_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('type')->nullable();
            $table->string('ppf', 255)->nullable();
            $table->string('ppffile', 255)->nullable();
            $table->string('house_loan', 255)->nullable();
            $table->string('house_loanfile', 255)->nullable();
            $table->string('insurance', 255)->nullable();
            $table->string('insurancefile', 255)->nullable();
            $table->string('mutual_fund', 255)->nullable();
            $table->string('mutual_fundfile', 255)->nullable();
            $table->string('children', 255)->nullable();
            $table->string('childrenfile', 255)->nullable();
            $table->string('investmentfile', 255)->nullable();
            $table->string('investment', 255)->nullable();
            $table->string('amount', 30)->nullable();
            $table->string('amountfile', 255)->nullable();
            $table->string('name_of_donee', 100)->nullable();
            $table->string('pan_of_donee', 12)->nullable();
            $table->string('address_of_done', 255)->nullable();
            $table->string('Mediclaim', 255)->nullable();
            $table->string('Mediclaimfile', 255)->nullable();
            $table->string('citizen', 255)->nullable();
            $table->string('parents', 255)->nullable();
            $table->string('parentsfile', 255)->nullable();
            $table->string('senior', 255)->nullable();
            $table->string('eligible', 255)->nullable();
            $table->string('eligiblefile', 255)->nullable();
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
        Schema::dropIfExists('ilrdeductions');
    }
}

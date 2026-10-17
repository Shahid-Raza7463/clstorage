<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlrfrombusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilrfrombusinesses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('clientlogin_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('type')->nullable();
            $table->integer('informationresource_id')->nullable();
            $table->string('nameofthebusiness', 100)->nullable();
            $table->string('natureofthebusiness', 100)->nullable();
            $table->string('If_company_is_covered', 100)->nullable();
            $table->string('If_company_is_coveredfilename', 255)->nullable();
            $table->string('If_company_is_not_coveredfilename', 255)->nullable();
            $table->string('Books_of_accountsfilename', 255)->nullable();
            $table->string('otherfilename', 255)->nullable();
            $table->string('If_company_is_coveredfile', 255)->nullable();
            $table->string('If_company_is_not_covered', 100)->nullable();
            $table->string('If_company_is_not_coveredfile', 255)->nullable();
            $table->string('Books_of_accounts', 255)->nullable();
            $table->string('Books_of_accountsfile', 255)->nullable();
            $table->string('other', 255)->nullable();
            $table->string('otherfile', 255)->nullable();
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
        Schema::dropIfExists('ilrfrombusinesses');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddSlackUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->string('slack_sso_uid')->nullable();
            $table->string('slack_sso_tid')->nullable();
            $table->string('slack_sso_access_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('slack_sso_uid');
            $table->dropColumn('slack_sso_tid');
            $table->dropColumn('slack_sso_access_token');
        });
    }
}

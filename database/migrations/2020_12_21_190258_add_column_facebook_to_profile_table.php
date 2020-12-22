<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFacebookToProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('facebook')->nullable();
            $table->text('twitter')->nullable();
            $table->text('github')->nullable();
            $table->text('website')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn("facebook");
            $table->dropColumn("twitter");
            $table->dropColumn("github");
            $table->dropColumn("website");
        });
    }
}

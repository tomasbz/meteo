<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddWindMinMaxToSubscribers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscribers', function ($table) {
            $table->boolean('wind_min');
            $table->boolean('wind_max');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscribers', function ($table) {
            $table->dropColumn('wind_min');
            $table->dropColumn('wind_max');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMixDetailToPetRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('pet_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('pet_registrations', 'mixDetail')) {
                $table->string('mix_detail')->nullable();
            }
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pet_registrations', function (Blueprint $table) {
            if (Schema::hasColumn('pet_registrations', 'mixDetail')) {
                $table->dropColumn('mixDetail');
            }
        });
    }
}

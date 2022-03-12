<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreatIntelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threat_intels', function (Blueprint $table) {
            $table->id();
            $table->string('alias');
            $table->string('real_name');
            $table->string('post');
            $table->string('url');
            $table->string('time');
            $table->string('geolocation');
            $table->string('source');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threat_intels');
    }
}

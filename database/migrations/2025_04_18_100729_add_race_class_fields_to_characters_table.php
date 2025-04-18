<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->string('race')->nullable()->after('name');
            $table->string('class')->nullable()->after('race');
            $table->string('subclass')->nullable()->after('class');
        });
    }

    public function down()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn(['race', 'class', 'subclass']);
        });
    }
};

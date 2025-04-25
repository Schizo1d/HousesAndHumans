<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            // Сначала добавляем поле level, если его нет
            if (!Schema::hasColumn('characters', 'level')) {
                $table->integer('level')->default(1)->after('subclass');
            }

            // Затем добавляем поле experience
            $table->integer('experience')->default(0)->after('level');
        });
    }

    public function down()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn(['level', 'experience']);
        });
    }
};

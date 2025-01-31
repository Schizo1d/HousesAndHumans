<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('character_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('character_id'); // Связь с таблицей персонажей
            $table->integer('strength')->default(10); // Сила
            $table->integer('dexterity')->default(10); // Ловкость
            $table->integer('constitution')->default(10); // Телосложение
            $table->integer('intelligence')->default(10); // Интеллект
            $table->integer('wisdom')->default(10); // Мудрость
            $table->integer('charisma')->default(10); // Харизма
            $table->timestamps();

            // Добавляем внешний ключ для связи с таблицей персонажей
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_attributes');
    }
};

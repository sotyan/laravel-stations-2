<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Reservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function(Blueprint $table) {
            $table->id();
            $table->date('date');
            // $table->unsignedBigInteger('schedule_id'); // 外部キー
            // $table->foreign('schedule_id')->references('id')->on('schedules'); // 外部キー
            // $table->unsignedBigInteger('sheet_id'); // 外部キー
            // $table->foreign('sheet_id')->references('id')->on('sheets'); // 外部キー
            $table->foreignId('schedule_id')->constrained()->nullable(); // 外部キー
            $table->foreignId('sheet_id')->constrained()->nullable(); // 外部キー
            $table->string('email', 255)->comment('予約者メールアドレス');
            $table->string('name', 255)->comment('予約者名');
            $table->boolean('is_canceled')->default(false)->comment('予約キャンセル済み');
            $table->unique(['schedule_id', 'sheet_id']); // 複合ユニークキー
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

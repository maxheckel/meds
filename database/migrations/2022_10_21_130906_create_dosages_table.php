<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosages', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Med::class);

            // Take 4 2mg doses every *day*
            $table->enum('interval', ['daily', 'weekly', 'monthly']);

            // Take 4 *2mg* doses every day
            $table->string('amount');
            $table->date('start');
            $table->date('end')->nullable();

            // Take 4 2mg doses every *monday and friday*
            $table->string('dotw')->nullable();

            // Take *4* 2mg doses every day
            $table->float('multiplier');

            $table->string('instructions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosages');
    }
};

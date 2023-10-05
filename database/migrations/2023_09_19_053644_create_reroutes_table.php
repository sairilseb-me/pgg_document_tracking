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
        Schema::create('reroutes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('incoming_id');
            $table->foreign('incoming_id')->references('id')->on('incomings');
            $table->string('from_office')->nullable();
            $table->string('to_office')->nullable();
            $table->integer('status')->default(0);
            $table->text('remarks');
            $table->date('date_rerouted');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reroutes');
    }
};

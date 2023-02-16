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
        Schema::create('app_platform_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('platform_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('app_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('status')->references('id')->on('status')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('expire_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_platform_subscriptions');
    }
};

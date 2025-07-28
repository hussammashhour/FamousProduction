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
        Schema::create('faqables', function (Blueprint $table) {
    $table->id();
    $table->foreignId('faq_id')->constrained()->onDelete('cascade');
    $table->unsignedBigInteger('faqable_id');
    $table->string('faqable_type');
    $table->timestamps();

    $table->index(['faqable_id', 'faqable_type']);
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqables');
    }
};

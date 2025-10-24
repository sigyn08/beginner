<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // 出品者
            $table->unsignedBigInteger('buyer_id')->nullable(); // 購入者
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('set null');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->text('description');
            $table->integer('price');
            $table->string('condition', 50);
            $table->string('image')->nullable(); // メイン画像
            $table->enum('status', ['active', 'sold'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

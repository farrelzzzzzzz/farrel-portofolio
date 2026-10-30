<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkm_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('umkm_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('umkm_categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('umkm_orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('shipping_address');
            $table->decimal('total_amount', 12, 2);
            $table->string('status')->default('pending'); // pending, processed, completed, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('umkm_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('umkm_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('umkm_products')->nullOnDelete();
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->timestamps();
        });

        Schema::create('umkm_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm_order_items');
        Schema::dropIfExists('umkm_orders');
        Schema::dropIfExists('umkm_products');
        Schema::dropIfExists('umkm_categories');
        Schema::dropIfExists('umkm_settings');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Indeksowanie dla products
        Schema::table('products', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('category_id');
            $table->index('Active');
            $table->index(['promote', 'promote_to']);
            $table->index('price');
        });

        // Indeksowanie dla messages
        Schema::table('messages', function (Blueprint $table) {
            $table->index('roomId');
            $table->index('product_id');
            $table->index(['buyer', 'seller']);
        });

        // Indeksowanie dla users
        Schema::table('users', function (Blueprint $table) {
            $table->index('last_seen');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['Active']);
            $table->dropIndex(['promote', 'promote_to']);
            $table->dropIndex(['price']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['roomId']);
            $table->dropIndex(['product_id']);
            $table->dropIndex(['buyer', 'seller']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['last_seen']);
        });
    }
};
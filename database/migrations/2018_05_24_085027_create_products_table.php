<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('Active')->default(1);
            $table->integer('category')->nullable();
            $table->string('Owner')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->boolean('First_owner')->default(0);
            $table->text('images')->nullable();
            $table->boolean('promote')->default(0);
            $table->timestamp('promote_to')->nullable();
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
        Schema::dropIfExists('products');
    }
}
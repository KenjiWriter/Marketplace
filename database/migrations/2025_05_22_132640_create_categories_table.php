<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        // Modify products table to use foreign key
        Schema::table('products', function (Blueprint $table) {
            // First create the new column without constraints
            $table->foreignId('category_id')->nullable()->after('category');
        });

        // Seed the categories table with existing categories
        $categories = [
            ['name' => 'Phones', 'slug' => 'phones', 'icon' => 'ti ti-device-mobile'],
            ['name' => 'Tablets', 'slug' => 'tablets', 'icon' => 'ti ti-device-tablet'],
            ['name' => 'Computers', 'slug' => 'computers', 'icon' => 'ti ti-device-laptop'],
            ['name' => 'Other', 'slug' => 'other', 'icon' => 'ti ti-box'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'icon' => $category['icon'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Migrate existing data
        DB::statement('UPDATE products SET category_id = category WHERE category IS NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });

        Schema::dropIfExists('categories');
    }
}

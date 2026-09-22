<?php

namespace Maeld\Catalog\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class CreateMaeldCatalogItemsTable extends Migration
{
    public function up()
    {
        Schema::create('maeld_catalog_items', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('material')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('order');
            $table->string('photo')->nullable();
            $table->string('price_mode')->default('from');
            $table->decimal('price_from', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('maeld_catalog_items');
    }
}

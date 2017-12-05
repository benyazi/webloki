<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWebsiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('websites', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 100);
			$table->string('domain', 100)->unique();
			$table->boolean('is_publish')->default(false);
			$table->unsignedInteger('template_id');
			$table->timestamps();
		});
		Schema::create('colors', function (Blueprint $table) {
			$table->increments('id');
			$table->string('color' ,20);
			$table->string('custom_font_color')->nullable();
			$table->boolean('is_texture')->default(false);
			$table->string('texture_name')->nullable();
			$table->timestamps();
		});
		Schema::create('color_schemas', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 100);
			$table->boolean('is_inverse')->default(false);
			$table->timestamps();
		});
		Schema::create('schema_colors', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('schema_id');
			$table->unsignedInteger('color_id');
			$table->integer('position')->nullable();
			$table->timestamps();
		});
		Schema::create('templates', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 100);
			$table->text('description')->nullable();
			$table->text('params')->nullable();
			$table->timestamps();
		});
		Schema::create('pages', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('website_id');
			$table->integer('menu_position')->nullable();
			$table->string('slug', 100);
			$table->string('title', 255);
			$table->text('content')->nullable();
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
        //
    }
}

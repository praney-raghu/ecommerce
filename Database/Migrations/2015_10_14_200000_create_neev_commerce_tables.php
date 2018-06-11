<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNeevCommerceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organisation_id')->unsigned();
            $table->string('hsn');

            // Can be used to define if product is physical, virtual (downloadable, service, domain, script run), subscription
            $table->string('type');

            // JSON array of modules to run with arguments eg.
            // [
            //     {
            //         "name": "create_domain",
            //         "param": [
            //             "domain": "test.com",
            //             "registrar":"resellerclub"
            //         ]
            //     }
            // ]
            $table->string('module');

            // $table->integer('currency_id')->unsigned();

            $table->text('name');
            $table->text('description');
            $table->text('meta_title');
            $table->text('meta_description');
            $table->text('meta_keyword');
            $table->text('slug');
            $table->text('tag');
            $table->decimal('cost', 13, 2);
            $table->decimal('qty', 13, 2)->nullable();
            $table->string('unit');
            $table->boolean('visible')->default(true);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
        });

        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organisation_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();

            $table->text('name');
            $table->text('description');
            $table->text('meta_title');
            $table->text('meta_description');
            $table->text('meta_keyword');
            $table->text('slug');
            $table->text('tag');

            $table->integer('sort_order')->default(0);

            $table->boolean('visible')->default(true);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('category')->onDelete('cascade');
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
        });

        // Schema::create('tax', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('organisation_id')->unsigned();

        //     $table->boolean('is_active');
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('category');
    }
}

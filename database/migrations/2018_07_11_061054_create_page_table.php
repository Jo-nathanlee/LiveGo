<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('page')) {
            Schema::create('page', function (Blueprint $table) {
                $table->increments('id');
                $table->string('fb_id');
                $table->string('name');
                $table->string('page_id');
                $table->string('page_name');
                $table->string('page_pic');
                $table->string('page_token');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page');
    }
}

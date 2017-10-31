<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClimbedRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('climbed_routes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');
            $table->integer('climb_session_id');
            $table->integer('category_dict');
            $table->integer('proposed_category_dict');
            $table->integer('route_type_dict');
            $table->integer('ascent_type_dict');
            $table->text('comment');
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
        Schema::dropIfExists('climbed_routes');
    }
}

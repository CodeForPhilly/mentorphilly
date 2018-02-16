<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomingMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incoming_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('number'); 
            $table->text('title'); 
            $table->text('message'); 
            $table->text('outgoingMedia'); 
            $table->text('city'); 
            $table->text('zip'); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incoming_messages');
    }
}

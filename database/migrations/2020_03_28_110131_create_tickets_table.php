<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('admin_id')->default(1)->references('id')->on('users')->onDelete('CASCADE');
            $table->string('subject');
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id')->references('id')->on('ticket_tickets')->onDelete('CASCADE');
            $table->integer('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->text('message');
            $table->timestamps();
        });

        Schema::create('ticket_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id')->references('id')->on('ticket_tickets')->onDelete('CASCADE');
            $table->string('file');
        });

        Schema::create('ticket_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id')->references('id')->on('ticket_tickets')->onDelete('CASCADE');
            $table->tinyInteger('is_seen')->default(0);
            $table->tinyInteger('is_closed')->default(0);
            $table->tinyInteger('is_answered')->default(0);
            $table->tinyInteger('is_taken')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_statuses');
        Schema::dropIfExists('ticket_photos');
        Schema::dropIfExists('ticket_messages');
        Schema::dropIfExists('ticket_tickets');
    }
}

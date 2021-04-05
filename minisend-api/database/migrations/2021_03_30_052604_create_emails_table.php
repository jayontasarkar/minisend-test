<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('recipient');
            $table->string('sender');
            $table->string('subject')->nullable()->index();
            $table->text('text_content')->nullable();
            $table->text('html_content')->nullable();
            $table->enum('status', ['POSTED', 'SENT', 'FAILED'])->default('POSTED');
            $table->timestamps();

            $table->string('user_id')->index();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
}

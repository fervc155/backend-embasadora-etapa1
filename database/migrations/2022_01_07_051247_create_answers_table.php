<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained();
            $table->foreignId('poll_id')->constrained();
            $table->foreignId('poll_status_id')->constrained();

            $table->unsignedBigInteger('interviewed_by');
            $table->unsignedBigInteger('attend_by')->nullable();

            $table->foreign('interviewed_by')->references('id')->on('users');
            $table->foreign('attend_by')->references('id')->on('users');

            $table->text('answers');
            $table->softdeletes();
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
        Schema::dropIfExists('answers');
    }
}

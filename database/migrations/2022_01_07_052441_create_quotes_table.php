<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->text('header');
            $table->string('client_name');
            $table->string('email');
            $table->string('phone');
            $table->string('title');
            $table->string('currency');
            $table->text('content');
            $table->date('start_validity');
            $table->date('end_validity');
            $table->text('first_footer');
            $table->text('second_footer');

            $table->foreignId('client_id')->nullable()->constrained();
            $table->foreignId('answer_id')->nullable()->constrained();
            $table->foreignId('quote_status_id')->default(1)->constrained();
    
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

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
        Schema::dropIfExists('quotes');
    }
}

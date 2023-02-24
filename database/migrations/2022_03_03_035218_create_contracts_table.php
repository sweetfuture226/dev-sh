<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks');
            $table->foreignId('client_id')->constrained('users');
            $table->foreignId('specialist_id')->constrained('users')->nullable();
            $table->timestamp('start_at');
            $table->timestamp('end_at')->nullable();
            $table->integer('duration');
            $table->double('budget');
            $table->string('status');
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
        Schema::dropIfExists('contracts');
    }
}

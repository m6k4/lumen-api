<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->default(Str::uuid());
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('expired_at')->nullable()->default(null);
            $table->string('token')->nullable()->default(null);
            $table->unsignedBigInteger('fk_user_id');

            $table->foreign('fk_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}

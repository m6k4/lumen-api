<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->default(Str::uuid());
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('deleted_at')->nullable()->default(null);
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('password');
            $table->string('email');
            $table->boolean('is_active')->default(true);
        });

        DB::table('users')->insert(
            array(
                'name' => 'zuza',
                'email' => 'name@domain.com',
                'password' => 'Qwerty123',
                'surname' => 'zyuuuz'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

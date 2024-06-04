<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
	        $table->id();
            $table->string("title");
            $table->text("description");
            $table->string("type");
            $table->string("salary");
            $table->date("start_date")->nullable();
            $table->date("expiration_date")->nullable();
            $table->string("is_active")->nullable();
            $table->string('city');
            $table->string('country');
            $table->string('category');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign("company_id")
            ->references('id')->on('companies')->onDelete('cascade');
            $table->foreign("user_id")
            ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};

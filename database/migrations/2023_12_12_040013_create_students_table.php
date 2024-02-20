<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->string('nama');
            $table->unsignedBigInteger('classroom_id');
            $table->string('alamat');
            $table->string('no_telepon');
            $table->enum('jenis_kelamin', ['l', 'p']);
            $table->string('image')->nullable();
            $table->enum('status', ['member', 'nonmember'])->default('nonmember');
            $table->text('password')->default(Hash::make(123));
            $table->timestamps();

            $table->foreign('classroom_id')->references('id')->on('classrooms')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};

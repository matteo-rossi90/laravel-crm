<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id')
                    ->references('id')
                    ->on('types')
                    ->cascadeOnDelete();
            $table->string('name', 50);
            $table->char('VAT', 11);
            $table->string('address', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

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
        Schema::create('ports', function (Blueprint $table) {

            $table->id();

            // Relasi ke negara
            $table->foreignId('country_id')->constrained()->onDelete('cascade');

            // Informasi pelabuhan
            $table->string('port_name');
            $table->string('port_code')->nullable();

            // Lokasi
            $table->string('city')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();

            // Status pelabuhan
            $table->enum('status', [
                'Normal',
                'Busy',
                'Delayed',
                'Closed'
            ])->default('Normal');

            // Keterangan tambahan
            $table->text('description')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ports');
    }
};
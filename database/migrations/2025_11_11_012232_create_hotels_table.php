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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('nomHotel');
            $table->string('addresse');
            $table->decimal('prixNuitee', 10, 2);
            $table->string('numero');
            $table->string('email')->unique();
             $table->enum('devise', ['FCFA', 'Euro', 'Dollar']);
            $table->string('cheminImage');            
            $table->timestamps();
             $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};

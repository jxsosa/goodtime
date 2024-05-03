<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Livewire\on;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->double('bs', 10, 2);
            $table->double('tasa' , 6, 2);
            $table->double('monto', 10, 2);
            $table->integer('ref', false,)->nullable();
            $table->string('descripcion')->nullable();
            $table->enum('tipo', ['entrada', 'salida'])->default('entrada');
            //$table->enum('cuenta', ['cobrar', 'pagar'])->default('cobrar');
            $table->date('fecha_entrega')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cambio_id')->constrained()->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->foreignId('cuenta_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};

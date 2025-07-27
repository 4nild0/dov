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
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->integer('deputado_id'); // 🔧 sem unsigned
            $table->string('tipo_despesa');
            $table->decimal('valor', 10, 2);
            $table->date('data');
            $table->string('fornecedor')->nullable();
            $table->timestamps();

            $table->foreign('deputado_id')
                ->references('id')
                ->on('deputados')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};

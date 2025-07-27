<?php
// database/migrations/xxxx_xx_xx_create_deputados_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeputadosTable extends Migration
{
    public function up()
    {
        Schema::create('deputados', function (Blueprint $table) {
            $table->integer('id')->primary(); // id da API
            $table->string('nome');
            $table->string('partido')->nullable();
            $table->string('uf')->nullable();
            $table->string('foto_url')->nullable();
            $table->string('email')->nullable();
            $table->integer('idLegislatura')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deputados');
    }
}

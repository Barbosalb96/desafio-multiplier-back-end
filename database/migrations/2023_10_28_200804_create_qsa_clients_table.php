<?php

use App\Domain\Client\Entities\Client;
use App\Domain\Client\Entities\Qsa;
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
        Schema::create('qsa_clients', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->constrained('clients');
            $table->foreignIdFor(Qsa::class)->constrained('qsas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qsa_clients');
    }
};

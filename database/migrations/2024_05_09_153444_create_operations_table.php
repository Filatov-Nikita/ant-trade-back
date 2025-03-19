<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Company;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sum');
            $table->foreignIdFor(Company::class)->constrained();
            $table->enum('type', [ 'purchase', 'supply' ]);
            $table->enum('transaction_type', [ 'products', 'cash' ]);
            $table->enum('payment_source', [ 'checking-account', 'self-collection', 'products' ]);
            $table->text('comment')->nullable();
            $table->date('date_from');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};

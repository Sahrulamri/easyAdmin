<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run migrations.
     */
    public function up(): void
    {
        Schema::connection('pgsql_easyadmin')
            ->create('transactions', function (Blueprint $table) {

                $table->id();
                $table->string('transaction_code')->unique();
                $table->string('product_code');
                $table->string('product_name');
                $table->integer('unit_price')->default(0);
                $table->integer('quantity')->default(0);
                $table->integer('total_price')->default(0);
                $table->timestamps();
            });
    }

    /**
     * Reverse migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_easyadmin')
            ->dropIfExists('transactions');
    }
};

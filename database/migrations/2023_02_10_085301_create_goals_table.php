<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('wallets');
            $table->string('name');
            $table->decimal('initial_value', 12, 2);
            $table->decimal('value', 12, 2);
            $table->decimal('amount', 12, 2)->default(0);
            $table->decimal('progress', 12, 2)->default(0);
            $table->string('description')->nullable();
            $table->date('date_final');
            $table->string('profit_wallet')->default(0);
            $table->integer('days_remaining')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goals');
    }
};

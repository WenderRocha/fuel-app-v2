<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('wallets');
            $table->integer('qtd_trades')->default(0);
            $table->integer('qtd_win')->default(0);
            $table->integer('qtd_loss')->default(0);
            $table->integer('qtd_draw')->default(0);
            $table->decimal('total_investment', 12, 2)->default(0);
            $table->decimal('value_win', 12, 2)->default(0);
            $table->decimal('value_loss', 12, 2)->default(0);
            $table->decimal('profit', 12, 2)->default(0);
            $table->decimal('result_percentage', 12, 2)->default(0);
            $table->decimal('result_percentage_day', 12, 2)->default(0);
            $table->decimal('day_balance', 12, 2)->default(0);
            $table->decimal('final_balance', 12, 2)->default(0);
            $table->decimal('average_profit', 12, 2)->default(0);
            $table->decimal('take_progress', 12, 2)->default(0);
            $table->decimal('stop_progress', 12, 2)->default(0);
            $table->string('result_day')->default('no_trade');
            $table->string('key')->default('')->nullable();
            $table->string('highlight')->default('')->nullable();
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
        Schema::dropIfExists('management');
    }
};

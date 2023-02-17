<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTradeRequest;
use App\Http\Requests\UpdateTradeRequest;
use App\Models\Calendar;
use App\Services\Trade\TradeServiceInterface;
use App\Services\Wallet\WalletServiceInterface;
use App\Services\Management\ManagementServiceInterface;

class TradeController extends Controller
{

    public function __construct(
        protected TradeServiceInterface $tradeService,
        protected ManagementServiceInterface $managementServices,
        protected WalletServiceInterface $walletService,
    )
    {

    }


    public function store(StoreTradeRequest $request)
    {


        $wallet = $this->walletService->findWith('managements.trades', $request->wallet_id);
        $management = $wallet->managements()->where('wallet_id', $wallet->id)->whereDate('created_at', '=', date('Y-m-d'))->first();

        //verifica se existe um gerenciamento criado com a data de hoje
        if(is_null($management)) {

            //se nao houver, cria um gerenciamento
           $management = $wallet->managements()->create(['wallet_id' => $wallet->id]);
           $management->update(['day_balance' => $this->managementServices->dayBalance($wallet)]);

        }

        //insere os trades no gerenciamento
        $trade = $management->trades()->create($request->all());

        if($trade) {

            //atualiza o gerenciamento
           $managementUpdate = $management->update([
                'qtd_trades' => $this->tradeService->qtdTrades($management),
                'qtd_win' => $this->tradeService->qtdTradesByResult($management, 'win'),
                'qtd_loss' => $this->tradeService->qtdTradesByResult($management, 'loss'),
                'qtd_draw' => $this->tradeService->qtdTradesByResult($management, 'draw'),
                'total_investment' => $this->tradeService->totalInvestment($management),
                'value_win' => $this->tradeService->getValueByResult($management, 'win'),
                'value_loss' => $this->tradeService->getValueByResult($management, 'loss'),
                'profit' => $this->tradeService->profit($management),
                'final_balance' => $this->managementServices->finalBalance($management),
                'result_percentage' => $this->managementServices->resultPercentage($management, $wallet),
                'result_percentage_day' => $this->managementServices->resultPercentageDay($management, $wallet),
                'average_profit' => $this->managementServices->averageProfit($wallet),
                'take_progress' => $this->managementServices->takeProgress($this->tradeService->profit($management), $wallet),
                'stop_progress' => $this->managementServices->stopProgress($this->tradeService->getValueByResult($management, 'loss'), $wallet),
                'result_day' => $this->managementServices->resultDay($management),
                'key' => $this->managementServices->setKey($management),
                'highlight' => $this->managementServices->setHighlight($management),
            ]);



            //atualiza a carteira
            if($managementUpdate) {

                $wallet = $this->walletService->find($wallet->id);
                $wallet->balance = $this->walletService->finalBalance($wallet, $this->walletService->profit($wallet));
                $wallet->profit = $this->walletService->profit($wallet);
                $wallet->result_percentage = $this->walletService->resultPercentage($wallet);
                $wallet->average_profit = $this->walletService->profit($wallet) / $this->managementServices->qtdManagements($wallet);
                $wallet->take_profit = $this->walletService->takeProfit($wallet);
                $wallet->stop_loss = $this->walletService->stopLoss($wallet);
                $wallet->save();

                /*

                //atualiza os objetivos
                $goals = $wallet->goals()->find(1)->where('profit_wallet', true)->first();

                //dd(($goals));
                $goals->initial_value = $this->walletService->profit($wallet);
                $goals->progress = ($wallet->profit * 100) / $goals->value;
                $goals->save();
                */

                //cria ou atualiza o calendario
                $calendar = $wallet->calendars()->whereDate('created_at', date('Y-m-d'))->first();

                //apenas atualiza o calendario, pois já foi criado um no_trade ao abrir a carteira
                $calendar->update([
                    'wallet_id' => $wallet->id,
                    'key' => $this->managementServices->setKey($management),
                    'highlight' => $this->managementServices->setHighlight($management)
                ]);

                //cria ou atualiza o relatorio
                if(is_null($wallet->report()->whereDate('created_at', '=', date('Y-m-d'))->first())) {
                    $wallet->report()->create([
                        'wallet_id' => $wallet->id,
                        'qtd_trades' => count($management->trades()->get()),
                        'qtd_win' => $this->tradeService->qtdTotalTradesByResult($management, 'win'),
                        'qtd_loss' => $this->tradeService->qtdTotalTradesByResult($management, 'loss'),
                        'qtd_draw' => $this->tradeService->qtdTotalTradesByResult($management, 'draw'),
                    ]);
                }else{

                    $wallet->report()->update([
                        'wallet_id' => $wallet->id,
                        'qtd_trades' => count($management->trades()->get()),
                        'qtd_win' => $this->tradeService->qtdTotalTradesByResult($management, 'win'),
                        'qtd_loss' => $this->tradeService->qtdTotalTradesByResult($management, 'loss'),
                        'qtd_draw' => $this->tradeService->qtdTotalTradesByResult($management, 'draw'),

                    ]);
                }

            }


            return  match($request->trade_result) {
                'win' => back()->toast(" + {$request->currency_symbol} {$request->income}",  'success'),
                'draw' => back()->toast(" {$request->currency_symbol} {$request->income}",  'warning'),
                'loss' => back()->toast(" - {$request->currency_symbol} {$request->value}",  'error')
            };
        }

        return back()->toast('Erro ao lançar trade',  'error');

    }


    public function show(Trade $trade)
    {
        //
    }

    public function edit(Trade $trade)
    {
        //
    }

    public function update(UpdateTradeRequest $request, Trade $trade)
    {
        //
    }

    public function destroy(Trade $trade)
    {
        //
    }
}

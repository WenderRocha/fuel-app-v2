<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Report;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Wallet\WalletServiceInterface;

class WalletController extends Controller
{

    public function __construct(
        protected WalletServiceInterface $walletService
    )
    {

    }

    public function index()
    {

        $id = Auth::user()->id;
        $wallets = User::find($id)->wallets()->get();

        return Inertia::render('Wallet', [
            'title' => 'Carteiras',
            'wallets' => $wallets
        ]);
    }


    public function store(Request $request)
    {

        if(Wallet::create($request->all())) {
            return back()->toast('Carteira criada com sucesso!',  'success');
        }

        return back()->toast('Erro ao criar carteira',  'error');
    }


    public function show($id)
    {

        $wallet = $this->walletService->findWith('managements.trades', $id);
        $management = $wallet->managements()->whereDate('created_at', '=', date('Y-m-d'))->get();

        //se nao houver um gerenciamento, significa que não houve operações no dia
        if(count($management) == 0) {
            $wallet->calendars()->create([
                'wallet_id' => $wallet->id,
                'key' => 'no_trade',
                'highlight' => 'gray'
            ]);
        }


        $calendars = $wallet->calendars->toArray();
        $trades = [];

        foreach ($management as $data) {
            $trades = $data['trades'];
        }

        $report = (!is_null($wallet->report))? $wallet->report->first() : ['qtd_win' => 1];

        return Inertia::render('Management', [
            'title' => $wallet['name'],
            'wallet' => $wallet,
            'report' => $report,
            'management' => $management,
            'trades' => $trades,
            'calendars' =>  $calendars,
            'takeProgress' => (count($management) > 0) ? $management[0]['take_progress'] : 0,
            'stopProgress' => (count($management) > 0) ? $management[0]['stop_progress'] : 0
        ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}

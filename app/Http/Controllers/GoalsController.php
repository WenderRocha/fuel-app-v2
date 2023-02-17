<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGoalsRequest;
use App\Http\Requests\UpdateGoalsRequest;
use App\Models\Goals;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GoalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        $user = Auth::user();
        $user_data = User::with('wallets.goals')->find($user->id);
        $wallets = $user_data->wallets->toArray();
        $wallet = $user_data->wallets->find($id);
        $goals = $wallet->goals->toArray();


        return Inertia::render('Goals', [
            'title' => 'Objetivos',
            'wallets' => $wallets,
            'goals' => $goals
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGoalsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGoalsRequest $request)
    {
        $goals = Goals::create([
            'wallet_id' => 1,
            'name' => $request->name,
            'initial_value' => $request->initial_value,
            'value' => $request->value,
            'description' => $request->description,
            'date_final' => date($request->date_final),
            'progress' => ($request->initial_value * 100) / $request->value
        ]);

        if($goals) {
            return back()->toast('Objetivo cadastrado com sucesso!',  'success');
        }

        return back()->toast('Erro ao cadastrar objetivo',  'error');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Goals  $goals
     * @return \Illuminate\Http\Response
     */
    public function show(Goals $goals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Goals  $goals
     * @return \Illuminate\Http\Response
     */
    public function edit(Goals $goals)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGoalsRequest  $request
     * @param  \App\Models\Goals  $goals
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGoalsRequest $request, Goals $goals)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Goals  $goals
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goals $goals)
    {
        //
    }
}

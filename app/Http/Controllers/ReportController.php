<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Report;
use Illuminate\Support\Facades\Date;

class ReportController extends Controller
{

    public function index()
    {
        Report::create([
            'date' => date('Y-m-d'),
            'wallet_id' => 1,
            'qtdTrades' => 4,
            'qtdWin' => 3,
            'qtdLoss' => 1,
            'qtdDraw' => 0
        ]);
    }


    public function create()
    {
        //
    }

    public function store(StoreReportRequest $request)
    {
        //
    }

    public function show(Report $report)
    {
        //
    }

    public function edit(Report $report)
    {
        //
    }

    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    public function destroy(Report $report)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Wallet;
use App\Models\Management;
use App\Http\Requests\StoreManagementRequest;
use App\Http\Requests\UpdateManagementRequest;
use App\Services\Management\ManagementServiceInterface;

class ManagementController extends Controller
{

    public function __construct(
        protected ManagementServiceInterface $managementService
    )
    {

    }

    public function index()
    {
        $managements = $this->managementService->findAll();
        return Inertia::render('Book', ['managements' => $managements]);
    }


    public function create()
    {
        //
    }


    public function store(StoreManagementRequest $request)
    {
        //
    }

    public function edit(Management $management)
    {
        //
    }

    public function update(UpdateManagementRequest $request, Management $management)
    {
        //
    }

    public function destroy(Management $management)
    {
        //
    }
}

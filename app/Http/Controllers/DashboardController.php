<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Show dashboard with statistics.
     */
    public function index()
    {
        $stats = $this->dashboardService->getStats(auth()->user());

        return view('dashboard', $stats);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\ReportService;

class TransactionController extends Controller
{
    /**
     * @var ReportService
     */
    private $reportService;

    /**
     * TransactionController constructor.
     * @param ReportService $reportService
     */
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function previewReport(int $days = 7)
    {
        $reports = $this->reportService->getReportIn($days);

        return view('report', compact('reports'));
    }
}

<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReportService;

class TransactionActivityController extends Controller
{
	/**
     * @var ReportServices
     */
    private $reportService;

    /**
     * TransactionActivityController constructor.
     * @param ReportService $reportService
     */
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * @param int $days
     * @return \App\Http\Resources\ApiException|ReportCollection
     */
    public function getApiReport(int $days = 7)
    {
        return $this->reportService->getApiReportIn($days);
    }
}

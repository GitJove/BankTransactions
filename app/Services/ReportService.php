<?php

namespace App\Services;

use App\Http\Resources\ApiException;
use App\Http\Resources\ReportCollection;
use App\Queries\Report;
use App\Repositories\Eloquent\Transaction\TransactionRepositoryInterface;
use App\Utilities\CustomLogger\LogMsg;
use Carbon\Carbon;

class ReportService
{
    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    /**
     * TransactionActivityController constructor.
     * @param ReportService $reportService
     */
    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function getApiReportIn($days)
    {
        try {
            return new ReportCollection($this->buildApiDataFrom($days));
        } catch (\Exception $exception) {
            $exception->errorCode = (app()->make(LogMsg::class))
                ->error(__METHOD__, $exception, 'report');
            return new ApiException($exception);
        }
    }

    /**
     * @param $days
     * @return array|\Illuminate\Support\Collection
     */
    private function buildApiDataFrom($days)
    {
        // timestamp result: 2017-12-25 14:15:16
        $dateTimeString = $this->toDateTimeStringFrom($days);
        $result = $this->transactionRepository->getFrom($dateTimeString);
        $result[] = $dateTimeString;

        return $result;
    }

    /**
     * toDateTimeString : 2017-12-25 14:15:16
     * @param $days
     */
    private function toDateTimeStringFrom($days)
    {
        return Carbon::now()->subDays($days)->toDateTimeString();
    }

    /**
     * toDateString : 2017-12-25
     * @param $days
     */
    private function toDateStringFrom($days)
    {
        return Carbon::now()->subDays($days)->toDateString();
    }

    public function getReportIn($days)
    {
        $dateString = $this->toDateStringFrom($days);

        // It should be paginated but I keep it simple for now
        $transactionCollection = $this->transactionRepository->getFrom($dateString);

        // Add date attribute to the collection
        $transactionCollection->date = $dateString;

        return $transactionCollection;
    }
}
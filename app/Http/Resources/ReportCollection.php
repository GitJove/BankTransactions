<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReportCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        /**
         *  The data comes in a structure like this:
         * 
         *      { 
         *          "status": "success",
         *          "date": "2018-01-14 00:18:53",
         *          "data": [
         *             {
         *                 "code": "CM",
         *                 "Unique_Customers": 3,
         *                 "No_of_Deposits": 12,
         *                 "deposit": 15084,
         *                 "No_of_withdraw": 7,
         *                 "withdraw": 1650
         *             },
         *             {
         *                 "code": "BJ",
         *                 "Unique_Customers": 4,
         *                 "No_of_Deposits": 3,
         *                 "deposit": 6888,
         *                 "No_of_withdraw": 2,
         *                 "withdraw": 15701
         *              },
         *       ] 
         *      }
        */
        return [
            'status' => 'success',
            'date' => $this->collection->pop(),
            'data' => $this->collection
        ];
    }
}

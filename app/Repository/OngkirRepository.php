<?php
/**
 * Copyright (c) 2021.
 * Dinokhan
 * PHP Storm
 * Last Modified: 6/13/21, 1:59 AM
 */
namespace App\Repository;
use App\Traits\BaseCRUL;
use Illuminate\Support\Facades\DB;

class OngkirRepository
{
    private $baseCRUL;
    public function __construct(BaseCRUL $baseCRUL)
    {
        $this->baseCRUL = $baseCRUL;
    }
    public function province(){
        $CURLOPT_URL = 'https://pro.rajaongkir.com/api/province';
        $CURLOPT_CUSTOMREQUEST ='GET';

        $response = $this->baseCRUL->API_GET($CURLOPT_URL, $CURLOPT_CUSTOMREQUEST);
        return json_decode($response, true);
    }
    public function city(){

        $CURLOPT_URL = 'https://pro.rajaongkir.com/api/city';
        $CURLOPT_CUSTOMREQUEST ='GET';

        $response = $this->baseCRUL->API_GET($CURLOPT_URL, $CURLOPT_CUSTOMREQUEST);

        return json_decode($response, true);
    }
    public function cost($request){

        $CURLOPT_URL = 'https://pro.rajaongkir.com/api/cost';
        $CURLOPT_CUSTOMREQUEST ='POST';
        $CURLPOST_DATA = [
            'origin' => $request->origin,
            'originType' => $request->originType,
            'destination' => $request->destination,
            'destinationType' => $request->destinationType,
            'weight' => $request->weight,
            'courier' => $request->courier,
        ];

        $response = $this->baseCRUL->API_POST($CURLOPT_URL, $CURLOPT_CUSTOMREQUEST, $CURLPOST_DATA);

        return json_decode($response);
    }
    public function internationalCost($request){

        $CURLOPT_URL = 'https://pro.rajaongkir.com/api/v2/internationalCost';
        $CURLOPT_CUSTOMREQUEST ='POST';
        $CURLPOST_DATA = [
            'origin' => $request->origin,
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier,
        ];

        $response = $this->baseCRUL->API_POST($CURLOPT_URL, $CURLOPT_CUSTOMREQUEST, $CURLPOST_DATA);

        return json_decode($response);
    }
}

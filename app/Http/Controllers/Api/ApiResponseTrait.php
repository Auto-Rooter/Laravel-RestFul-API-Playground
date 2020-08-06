<?php

namespace App\Http\Controllers\Api;

Trait ApiResponseTrait {

    /*
        [
            'data' => 'your data',
            'status' => True/ False,
            'error' => 'error msg'
        ]
    */

    public function apiResponse($data = null, $error = null, $code = 200){
       
        $array = [
            'data' => $data,
            'status' => $code == 200 ? true : false,
            'error' => $error
        ];

        return response($array, $code);
    }
}
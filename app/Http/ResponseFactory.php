<?php
/**
 * Created by PhpStorm.
 * User: dani
 * Date: 2018.10.23.
 * Time: 21:29
 */

namespace App\Http;


use Illuminate\Support\Facades\Response;

class ResponseFactory
{

    public static function make(array $data, int $status = 200) {
        switch (config('base.response_type', 'json')) {
            case 'json':
                return Response::json($data, $status);
                break;
            case 'xml':
                return Response::xml($data, $status);
                break;
            default:
                return Response::json($data, $status);
        }
    }

}
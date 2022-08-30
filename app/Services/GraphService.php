<?php

namespace App\Services;

use GuzzleHttp\Client;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\User;

class GraphService
{
    private static $token = false;
    private static $graph = false;
    private static $guzzle = false;
    private static $initted = false;

    public static function token(){
        return static::$token;
    }

    public static function initClient(){
        self::$graph = new Graph();
        self::$graph->setApiVersion(env("GRAPH_API_VERSION"));
        self::$guzzle = new Client();
    }

    public static function accquireToken(){
        $guzzle = new Client();
        if(!self::$graph){
            self::initClient();
        }
        $url = 'https://login.microsoftonline.com/' . env("GRAPH_TENANT_ID") . '/oauth2/v2.0/token';
        try {
            $token = json_decode($guzzle->post($url, [
                'form_params' => [
                    'client_id' => env("GRAPH_CLIENT_ID"),
                    'client_secret' => env("GRAPH_CLIENT_SECRET"),
                    'scope' => 'https://graph.microsoft.com/.default',
                    'grant_type' => 'client_credentials',
                ],
            ])->getBody()->getContents());
            static::$token = $token->access_token;
            self::$graph->setAccessToken(self::$token);
        }catch (Exception $exception){
//            Log::error($exception);
        }
    }

    public static function getUserInfo($search){
        self::accquireToken();
        $user = self::$graph
            ->createRequest("GET", "/users/" + $search)
            ->setReturnType(User::class)
            ->execute();
        return $user;
    }
}

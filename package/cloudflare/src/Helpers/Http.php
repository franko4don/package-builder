<?php
namespace Frank\Cloudflare\Helpers;

use \GuzzleHttp\Client;
use Exception;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
/*
|--------------------------------------------------------------------------
| Custom Http Client
|--------------------------------------------------------------------------
|
| A customized Http Client Class that enables user make api calls to 
| remote urls from within an app using Guzzle
|
*/


class Http
{
    private static $client;
    private static $response;

    public static function client()
    {
        if (!self::$client)
        self::$client = new Client;
        return self::$client;
    }
    /**
     * Processes response returned by guzzle
     * @param mixed $response
     * @param boolean $toArray
     */
    private static function processResponse(ResponseInterface $response, $toArray = true, $format= 'json')
    {
        switch(self::$response->getStatusCode()){
            case 200:
                return self::getResult($format, $toArray);
            case 201:
                return self::getResult($format, $toArray);
            default:
                return self::$response->getBody();
        }
       
    }

    public static function getStatusCode(){
        return self::$response->getStatusCode();
    }

    private static function getResult($format, $toArray){
        switch($format){
            case 'json':
                return json_decode(self::$response->getBody(), $toArray);
                break;
            case 'xml':
                $xml = simplexml_load_string($response->getBody());
                $json = json_encode($xml);
                return $json;
                break;
            default:
                return json_decode(self::$response->getBody(), $toArray);
        }
    }


    /**
    * Sends a get request to defined url
    * @param string $url 
    * @param array $params
    * @return mixed
    */
   public static function get($url = '', $params = [], $responseToArray = true, $format='json')
   {
        self::$response = self::client()->request('GET', $url, $params);
        
        return self::processResponse(self::$response, $responseToArray, $format);
    }


   /**
    * Sends a post request to defined url
    * @param string $url 
    * @param array $params
    * @return mixed
    */
   public static function post($url = '', $params = [], $responseToArray = true, $format='json')
   {
       try{
            self::$response = self::client()->request('POST', $url, $params);
            return self::processResponse(self::$response, $responseToArray, $format);

       }catch(ClientException $e){ 
            return $e->getResponse()->getBody();
        }
       
       
   }
   
    /**
    * Sends a delete request to defined url
    * @param string $url 
    * @param array $params
    * @return mixed
    */
    public static function delete($url = '', $params = [], $responseToArray = true, $format='json')
    {
        self::$response = self::client()->request('DELETE', $url, $params);
        return self::processResponse(self::$response, $responseToArray, $format);
    }



    /**
     * Sends a put request to defined url
    * @param string $method
    * @param string $url 
    * @param array $params
    * @return mixed
    */
    public static function put($url = '', $params = [], $responseToArray = true, $format='json')
    {
        self::$response = self::client()->request('PUT', $url, $params);
        return self::processResponse(self::$response, $responseToArray, $format);
    }

    /**
     * Sends a patch request to defined url
    * @param string $method
    * @param string $url 
    * @param array $params
    * @return mixed
    */
    public static function patch($url = '', $params = [], $responseToArray = true, $format='json')
    {
        self::$response = self::client()->request('PATCH', $url, $params);
        return self::processResponse(self::$response, $responseToArray, $format);
    }
}
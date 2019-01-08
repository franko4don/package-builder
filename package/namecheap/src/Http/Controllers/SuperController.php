<?php

namespace Frank\Namecheap\Http\Controllers;

use App\Http\Controllers\Controller;
use Frank\Namecheap\Helpers\Http;
use Frank\Namecheap\Helpers\Helper;
use Illuminate\Http\Request;
use Config;
use Response;

class SuperController extends Controller
{

    private $client_ip;
    private $base_url;
    private $api_user;
    private $api_key;
    private $username;
    private $full_url;

    public function __construct(){
        $this->client_ip = $_SERVER['REMOTE_ADDR'];
        $this->base_url = "https://api.namecheap.com/xml.response";
        $this->api_user = Config::get('namecheap.namecheap_username');
        $this->api_key = Config::get('namecheap.namecheap_api_key');
        $this->username = Config::get('namecheap.namecheap_username');
        $this->full_url = "$this->base_url?ApiUser=$this->api_user&ApiKey=$this->api_key&UserName=$this->username&ClientIp=$this->client_ip";
    }

    /**
     * Get full url
     * @return string
     */
    public function getUrl(){
        return $this->full_url;
    }

    /**
     * Convert xml data to json
     * @param $xml string
     * @return json
     */
    public function convertToJson($xml){
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        return json_decode($json,TRUE);
    }

    /**
     * Get the data returned from json
     * @param $data string
     */
    public function getData($data, $command){
        $key = $this->generateDataKey($command);
        $ret = $data['CommandResponse'][$key];
        dd($ret);
    }

    /**
     * Check if request is successful
     * @param $data string
     */
    public function isRequestSuccessful($data){
        return $data['@attributes']['Status'] == 'OK';
    }

    public function generateDataKey($key){
        $array = explode('.', $key);
        if(count($array) < 3){
            throw new \Exception;
        }
        $type = ucfirst(Helper::singularize($array[1]));
        $command = ucfirst(Helper::singularize($array[2]));
        return $type.$command."Result";
    }

}
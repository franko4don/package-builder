<?php

namespace Frank\Namecheap\Http\Controllers;

use App\Http\Controllers\Controller;
use Frank\Namecheap\Helpers\Http;
use Illuminate\Http\Request;
use Config;

class ProcessController extends Controller
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
     * Searches namecheap for a single domain
     * @param mixed $request
     * @return json
     */
    public function searchSingleDomain(Request $request){
        $domain = $request->domain;
        if(is_array($domain)){
            return "Return an array";
        }
        $url = "$this->full_url&Command=namecheap.domains.check&DomainList=$domain";
        return Http::get($url, [], $responseToArray = true, $format='xml');
        
    }

    /**
     * Searches namecheap for multiple domain
     * @param mixed $request
     * @return json
     */
    public function searchMultipleDomains(Request $request){
        $domain = $request->domain;
        if(!is_array($domain)){
            return "Must be an array";
        }
        $domain = implode(',', $domain);
        $url = "$this->full_url&Command=namecheap.domains.check&DomainList=$domain";
        return Http::get($url, [], $responseToArray = true, $format='xml');
        
    }
}
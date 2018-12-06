<?php

namespace Frank\Cloudflare\Http\Controllers;

use App\Http\Controllers\Controller;
use Frank\Cloudflare\Helpers\Http;
use Illuminate\Http\Request;
use Config;

class ProcessController extends Controller
{
    private $headers;
    private $base_url;

    public function __construct(){
        $this->headers = [
            'X-Auth-Key' => Config::get('cloudflare.cloudflare_api_key'),
            'X-Auth-Email' => Config::get('cloudflare.cloudflare_email')
        ];
        $this->base_url = 'https://api.cloudflare.com/client/v4/';
    }

    /**
     * Gets all sites added to account on cloudflare
     * @param mixed $request
     * @return json
     */
    public function getMySites(Request $request){
        
        $per_page = $this->perPage($request);
        $url = $this->base_url."zones$per_page";
        return Http::get(
            $url, 
            ['headers' => $this->headers], 
            $responseToArray = true, 
            $format='json'
        );
    }

    /**
     * Gets all sites added to account on cloudflare
     * @param mixed $request
     * @return json
     */
    public function addSite(Request $request){
        
        $data = $this->getUserAccount();
        $data['name'] = $request->name;
        $per_page = $this->perPage($request);
        $url = $this->base_url."zones";
        $this->headers["Content-Type"] = "application/json";
        
        return Http::post(
            $url, 
            [
                'headers' => $this->headers,
                'json' => $data
            ], 
            true, 
            $format='json'
        );
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


    /**
     * Checks if pagination is specified in request
     * if it is specified and the parameter not an integer
     * the default value set in the config is used
     * @param mixed
     * @return string
     */
    private function perPage(Request $request){
        $per_page = isset($request->per_page) 
                    && is_numeric($request->per_page)
                    ? "?per_page=$request->per_page" 
                    : "?per_page=".Config::get('cloudflare.default_result_per_page');
        return $per_page;
    }

    /**
     * Gets all sites added to account on cloudflare
     * @param mixed $request
     * @return json
     */
    public function getUserAccount(){
        $url = $this->base_url."accounts";
        $response = Http::get(
                    $url, 
                    ['headers' => $this->headers], 
                    $responseToArray = true, 
                    $format='json'
                );
        $account = [
            "account" => [
                    "name" => $response['result'][0]['name'], 
                    "id" => $response['result'][0]['id']]
            ];
        
        return $account;
    }


}
<?php

namespace Frank\Namecheap\Http\Controllers;

use Frank\Namecheap\Helpers\Http;
use Illuminate\Http\Request;

class ProcessController extends SuperController
{

    /**
     * Searches namecheap for a single domain
     * @param mixed $request
     * @return json
     */
    public function searchSingleDomain(Request $request){
        $domain = $request->domain;
        $command = 'namecheap.domains.check';
        if(is_array($domain)){
            return "Return an array";
        }
        $url = $this->getUrl()."&Command=$command&DomainList=$domain";
        $data = $this->convertToJson(Http::get($url));
        return $data;
    }

    /**
     * Searches namecheap for multiple domain
     * @param mixed $request
     * @return json
     */
    public function searchMultipleDomains(Request $request){
        $domain = $request->domain;
        $command = 'namecheap.domains.check';
        if(!is_array($domain)){
            return "Must be an array";
        }
        $domain = implode(',', $domain);
        $url = $this->getUrl()."&Command=$command&DomainList=$domain";
        $data = $this->convertToJson(Http::get($url));
        return $data;
    }

    /**
     * Get domain info
     * @param mixed $request
     * @return json
     */
    public function getDomainInfo(Request $request){
        $domain = $request->domain;
        $command = 'namecheap.domains.getInfo';
        $url = $this->getUrl()."&Command=$command&DomainName=$domain";
        $data = $this->convertToJson(Http::get($url));
        return $data;
        
    }
}
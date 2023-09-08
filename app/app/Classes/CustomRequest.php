<?php

namespace App\Classes;

use Illuminate\Support\Facades\Log;
use stdClass;

class CustomRequest {
    private $curl,
            $contentType,
            $customHeaders;


    public  $route,
            $body,
            $response;
    public function __construct() {
        $this->contentType = 'application/x-www-form-urlencoded';
    }

    public function setRoute($route) {
        $this->route = $route;
        return $this;
    }

    public function setContentType($contentType) {
        $this->contentType = $contentType;
        return $this;
    }

    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    public function setHeaders($headers) {
        $this->customHeaders = [];
        foreach ($headers as $key => $value)
            $this->customHeaders[] = $key . ': ' . $value;
        return $this;
    }

    private function prepare() {
        $this->curl = curl_init();

        $headers = [];
        if ($this->customHeaders) {
            foreach ($this->customHeaders as $value) {
                $headers[] = $value;
            }
        }

        if ($this->contentType) {
            $headers[] = 'Content-Type: ' . $this->contentType;
        }

        if (count($headers) > 0)
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->curl, CURLOPT_URL, $this->route);

        if ($this->body)
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->body);
    }

    private function handleResponse($response) {
        Log::info(json_encode($response));
        $this->response = new CustomRequestResponse($response, curl_getinfo($this->curl));
        return $response !== false;
    }

    public function get() {
        $resp = true;
        $this->prepare();
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');

        $resp = $this->handleResponse(curl_exec($this->curl));

        curl_close($this->curl);
        return $resp;
    }

    public function post() {
        $resp = true;
        $this->prepare();
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');

        $resp = $this->handleResponse(curl_exec($this->curl));

        curl_close($this->curl);
        return $resp;
    }

    public function put() {
        $resp = true;
        $this->prepare();
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PUT');

        $resp = $this->handleResponse(curl_exec($this->curl));

        curl_close($this->curl);
        return $resp;
    }

    public function patch() {
        $resp = true;
        $this->prepare();
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PATCH');

        $resp = $this->handleResponse(curl_exec($this->curl));

        curl_close($this->curl);
        return $resp;
    }

    public function delete() {
        $resp = true;
        $this->prepare();
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $resp = $this->handleResponse(curl_exec($this->curl));

        curl_close($this->curl);
        return $resp;
    }
}

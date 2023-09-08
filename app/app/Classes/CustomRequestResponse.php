<?php

namespace App\Classes;

class CustomRequestResponse {
    public  $code,
            $asJson,
            $asString;

    public function __construct($curlBody, $curlInfo) {
        if ($curlBody === false) {
            $this->code =       404;
            $this->asJson =     null;
            $this->asString =   null;
        } else {
            $this->code =       $curlInfo['http_code'];
            $this->asJson =     json_decode($curlBody) ?? null;
            $this->asString =   $curlBody;
        }
    }
}

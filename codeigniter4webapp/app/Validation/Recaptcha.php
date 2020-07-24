<?php

namespace App\Validation;

class Recaptcha{

    public function validateRecaptcha(string $recaptcha_challenge, string &$error = null){
        //url: https://www.google.com/recaptcha/api/siteverify
        //method: post
        //secret:    Required. The shared key between your site and reCAPTCHA.
        //response    Required. The user response token provided by the reCAPTCHA client-side integration on your site.
        //remoteip    Optional. The user's IP address.
        //
        //API RESPONSE:
        //{
        //   "success": true|false,
        //   "challenge_ts": timestamp,  // timestamp of the challenge load (ISO format yyyy-MM-dd'T'HH:mm:ssZZ)
        //   "hostname": string,         // the hostname of the site where the reCAPTCHA was solved
        //   "error-codes": [...]        // optional
        // }
        //$recaptcha_challenge = "hola";
        $url =  "https://www.google.com/recaptcha/api/siteverify";
        $secret  = env('captcha_secret');
        $response = $recaptcha_challenge;

        $postdata = http_build_query(["secret"=>$secret,"response"=>$response]);
        $opts = ['http' =>
            [
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            ]
        ];
        $context  = stream_context_create($opts);
        $result = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        $check = json_decode($result);
        if(!$check->success){
            $error = 'No se ha superado la prueba del captcha';
        }
        return $check->success;
    }
}
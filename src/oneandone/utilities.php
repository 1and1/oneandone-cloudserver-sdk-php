<?php

namespace src\oneandone;

use Exception;

trait Utilities {

    public static function buildUrl($base, $extension = null, $params = null) {
        
        // Convert query params object to query string (if needed)
        if($params) {

            $query_string = http_build_query($params);

            $url = BASE_URL . VERSION . $base . $extension . QUESTION_MARK . $query_string;

        }else {
            
            $url = BASE_URL . VERSION . $base . $extension;

        }

        return $url;

    }

    public static function cleanArray($array) {

        foreach($array as $key => $value) {

            if($value == null) {
                unset($array[$key]);
            }

        }

        return $array;

    }

    public static function checkResponse($message, $status) {

        // Check for server error 
        if($status == 500) {
            throw new Exception("Internal Server Error.  Please try again.");
        };

        // Check response status
        if(in_array($status, SUCCESS_CODES) == False) {
            throw new Exception($message);
        };

    }

}
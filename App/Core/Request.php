<?php

namespace App\Core;

class Request
{
    /**
     * Fetch the request URI.
     *
     * @return string
     */
    public static function uri()
    {
        $ur = trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'
        );
        if(strripos($ur,'myHomeProject')>= 0)
        {
           $array = explode('myHomeProject', $ur);
            return $array[count($array)-1];
        }

        return $ur;
    }

    /**
     * Fetch the request method.
     *
     * @return string
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}

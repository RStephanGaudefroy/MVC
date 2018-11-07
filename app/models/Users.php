<?php

namespace app\models;

class Users
{
    private static $rules = [
        'username' => 'required|isString',
        'email' => 'required|email',
        'password' => 'required|isString',
        'passwordConf' => 'required|isString'
    ];

    public static function getRules()
    {
        return self::$rules;
    }
}
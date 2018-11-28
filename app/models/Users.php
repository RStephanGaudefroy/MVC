<?php

namespace app\models;

class Users
{
    /**
     * Define rules for this model
     */
    private static $rules = [
        'username' => 'required|isString',
        'email' => 'required|email',
        'password' => 'required|isString',
        'passwordConf' => 'required|isString'
    ];

    /**
     * @return $rules
     */
    public static function getRules()
    {
        return self::$rules;
    }
}
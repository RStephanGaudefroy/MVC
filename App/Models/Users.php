<?php

namespace App\Models;

class Users extends Model
{
    // Define rules for users validation
    private static $rules = [
        'username' => 'string|required',
        'email' => 'email|required|unique',
        'password' => 'string|required',
        'passwordConf' => 'string|required'
    ];

    /**
     * call Validator class
     * @param array array_validate -> content data from the form post
     */
    public static function validate($array_validate)
    {
        return $response = self::callValidate(self::$rules, $array_validate);
    }

    
}

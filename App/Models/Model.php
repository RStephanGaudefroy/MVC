<?php

namespace App\Models;

use \Core\Validator as VALIDATE;

class Model
{
    // Define array to content error response by validator class
    private static $response = array();
    
    /**
     * Define what rules correspond with array validate
     * @param array $rule -> content rules at model call this function
     * @param array $array_validate ->content element of method post controller
     * @return array result -> content response of validation returns by class Validator
     */
    static function callValidate(array $rules, array $array_validate) : array
    {
        foreach ($rules as $key  => $rule)
        {
            //echo $key . ' : ' . $rule . '<br>';
            foreach ($array_validate as $field => $data)
            {
                if ($field === $key)
                {
                    $result = VALIDATE::Validate($rule, $data, $field);
                    
                    if (count($result) > 0 )
                        self::$response[] = $result;
                }
            }
        }
        
        return self::$response;
    } 
}
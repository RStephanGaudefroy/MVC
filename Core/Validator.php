<?php
/**
 * Custom class Validator
 * use array rules from any models and data from $_REQUEST object
 * use array content a methods for validate data
 */

namespace Core;

class Validator
{
    // Define array content method for a validation
    private static $array_method = [
        'required' => 'required',
        'string' => 513, // string filter
        'int' => 257,    // int filter
        'email' => 274   // email filter
    ];

    /**
     * @param array rule -> content rule(s) for validation data
     * @param array data -> contant post data at form
     * @return array result -> content error message if validation is false
     */
    public static function Validate($rules, $data, $field)
    {
        $array_rules =  explode('|', $rules);
        
        $result = array();
        
        foreach ($array_rules as $rule)
        {
            foreach ( self::$array_method as $key => $method)
            {
                if ( $key === $rule)
                {
                    // method required
                    if ($key === 'required')
                    {
                        if (empty($data))
                        {
                            $result['message'] = 'this field '. $field .' is required';
                        }
                    }
                    // method FILTER
                    elseif (is_int($method))
                    {   
                        if (!filter_var($data, $method))
                        {
                            $result['message'] = 'this field '. $field .' is invalid';
                        }
                    }
                }
            }
        }
        
        return $result;
    }
}
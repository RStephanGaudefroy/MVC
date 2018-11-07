<?php

namespace app\core;

class Validator
{
    private $data = [];
    private $errors = [];
    private $rules = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }
    
    
    public function validate():array
    {
        
        foreach ($this->data as $dataKey => $dataValue)
        {
            foreach ($this->rules as $ruleKey => $ruleValue)
            {
                if ( $dataKey === $ruleKey)
                {
                    $r = explode('|', $ruleValue);
                    foreach ($r as $method)
                    {
                        //print_r($dataKey .' : '. $method . ' : ' . $dataValue . '</br>');
                        $this->$method($dataKey, $dataValue);
                    }
                }
            }
        }
        
        return $this->errors;
    }

    /**
     * 
     */
    private function setErrors(string $key, string $message)
    {
        $this->errors[$key] = $message;
    }

    /**
     * 
     */
    private function required($key, $data)
    {
        if ( $data == null || strlen($data) <= 0 )
            $this->setErrors( $key, "Le champs $key est requis" ); 
    }

    /**
     * 
     */
    private function isString($key, $data)
    {
        if ( !is_string( $data ) )
            $this->setErrors( $key, "Le champs $key doit être une chaine de caractere." ); 
    }

    /**
     * 
     */
    private function email($key, $data)
    {
        if ( !filter_var( $data, FILTER_VALIDATE_EMAIL ) )
            $this->setErrors( $key, "Le champs $key n'est pas un email valide." );     
    }
}


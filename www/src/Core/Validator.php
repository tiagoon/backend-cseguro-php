<?php 

namespace App\Core;

class Validator {

    protected $errors   = [];
    protected $patterns = [
        'name'      => "/^[A-Z][a-z]+(\s[A-Z][a-z]+)*\s[A-Z][a-z]+(\s[A-Z][a-z]+)*$/",
        'phone'     => "/^\\+?[1-9][0-9]{7,14}$/",
        'email'     => "/^\\S+@\\S+\\.\\S+$/",
        'date'      => "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",
        'city'      => "/^[a-zA-Z0-9]*[a-zA-Z]+[a-zA-Z0-9]*$/",
        'id'        => "/[^0-9]/",
        'document' => "[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}"
    ];

    
    public function getErrors()
    {
        return $this->errors;
    }


    public function name($value, bool $required)
    {
        if ($required && ($value == null || strlen($value) == '')) {
            array_push($this->errors, 'O campo nome é obrigatório');
        }
        return $this;
        
        if(!preg_match($this->patterns['name'], $value)) {
            array_push($this->errors, 'Informe um nome e sobrenome válidos');
        }
        return $this;
    }


    public function email($value, bool $required)
    {
        if ($required && ($value == null || strlen($value) == '')) {
            array_push($this->errors, 'O campo email é obrigatório');
        }
        return $this;
        
        if(!preg_match($this->patterns['email'], $value)) {
            array_push($this->errors, 'O campo email é inválido');
        }
        return $this;
    }
    
    public function phone($value, bool $required=false)
    {
        if ($required && ($value == null || strlen($value) == '')) {
            array_push($this->errors, 'O campo telefone é obrigatório');
        }
        return $this;

        if(!preg_match($this->patterns['phone'], $value)) {
            array_push($this->errors, 'O telefone é inválido');
        }
        return $this;
    }


    public function date($value, bool $required=false)
    {
        if ($required && ($value == null || strlen($value) == '')) {
            array_push($this->errors, 'O campo data é obrigatório');
        }
        return $this;

        if(!preg_match($this->patterns['date'], $value)) {
            array_push($this->errors, 'A data é inválida');
        }
        return $this;
    }

    public function city($value, bool $required=false)
    {
        if ($required && ($value == null || strlen($value) == '')) {
            array_push($this->errors, 'O campo cidade é obrigatório');
        }
        return $this;

        if(!preg_match($this->patterns['city'], $value)) {
            array_push($this->errors, 'O campo cidade é inválido');
        }
        return $this;
    }

    public function id($value, bool $required)
    {
        if ($required && ($value == null || strlen($value) == '')) {
            array_push($this->errors, 'O ID é obrigatório');
        }
        return $this;

        if(!preg_match($this->patterns['id'], $value)) {
            array_push($this->errors, 'Informe um ID válido');
        }
        return $this;
    }

    public function companyName($value, bool $required)
    {
        if ($required && ($value == null || strlen($value) == '')) {
            array_push($this->errors, 'O nome é obrigatório');
        }
        return $this;

        if(!preg_match($this->patterns['name'], $value)) {
            array_push($this->errors, 'Informe um nome válido');
        }
        return $this;
    }

    public function document($value, bool $required)
    {
        if ($required && ($value == null || strlen($value) == '')) {
            array_push($this->errors, 'O CNPJ é obrigatório');
        }
        return $this;

        if(!preg_match($this->patterns['document'], $value)) {
            array_push($this->errors, 'Informe um CNPJ válido');
        }
        return $this;
    }

    public function address($value, bool $required)
    {
        if ($required && ($value == null || strlen($value) == '')) {
            array_push($this->errors, 'O Endereço é obrigatório');
        }
        return $this;
    }
}

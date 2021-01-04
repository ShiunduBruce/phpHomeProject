<?php
class User
{
    function __construct($name, $SSN, $email, $phone, $password, $address) 
    {
        $this->name = $name;
        $this->SSN = $SSN;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->address = $address;
    }
}
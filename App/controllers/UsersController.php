<?php
namespace App\Controllers;
use JsonStorage;
use User;

class UsersController
{
    public function create()
    {
        return view('signup');
    }
    public function store()
    {
        $errors = [];
        if (! empty($_POST['fullName']) && ! empty($_POST['SSN']) && ! empty($_POST['address'])
        && ! empty($_POST['email']) && ! empty($_POST['password']) 
            &&  ! empty($_POST['confirmPassword'])  && ! empty($_POST['phoneNumber']) ) 
        {
            $passWordOne = $this->read('password');
            $passWordTwo = $this->read('confirmPassword');    
            $name  = $this->read('fullName');
            $SSN  = $this->read('SSN');
            $email = $this->read('email');
            $address = $this->read('address');
            $phone = $this->read('phoneNumber');
            
            $errors = $this->validate($name, $SSN, $email, $phone, $passWordOne, $address, $passWordTwo);

            if(count($errors) == 0)
            {
                $this->save($name, $SSN, $email, $phone, $passWordOne, $address);
                return redirect('login');
            }                            
                
        }
        else
            $errors ['fields'] =  "Missing input fields";

        return view('signup', ['errors' => $errors]);        
    }
    public function save($name, $SSN, $email, $phone, $passWordOne, $address)
    {
        $storage = new JsonStorage('C:\xampp\htdocs\myHomeProject\database\users.json');
        $user = new User($name, $SSN, $email, $phone, $passWordOne, $address);           
        $storage->add($user);
        $storage->save();
    }
    public function validate($name, $SSN, $email, $phone, $passWordOne, $address, $passWordTwo)
    {
        $errors = [];
        if( count(explode(' ', $name) ) <= 1  || ! preg_match("/^([a-zA-Z' ]+)$/",$name) )
        $errors ['name'] = 'Invalid name. Please input your full name ';

        if(!is_numeric($SSN) || strlen((string)$SSN) != 9)
            $errors ['SSN'] = 'Invalid Social security number';
        
        //if( ! preg_match('/^(?:\\d+ [a-zA-Z ]+, ){4}[a-zA-Z ]+$/', $address) )
        //    $errors ['address'] = 'Invalid street address';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            $errors ['email'] = 'Invalid email';

        if(!preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $phone))
            $errors ['phone'] = 'Invalid phone number';

        if($passWordOne != $passWordTwo || strlen($passWordOne) < 4)
            $errors ['password'] = 'Invalid password. Please note the passwords have to match and be atleast 4 characters long';
        
        $storage = new JsonStorage('C:\xampp\htdocs\myHomeProject\database\users.json');
        if(count($storage->findAll(['email'=>$email])) > 0)
            $errors ['exists'] = 'Username with given email already exists';
           
        return $errors;
                
    }
    public function read($name)
    {
        return trim(htmlspecialchars($_POST[$name]));
    }
}
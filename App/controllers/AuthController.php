<?php

namespace App\Controllers;
use JsonStorage;

class AuthController
{
    
    /**
     * Show the login page.
     */
    public function show()
    {
        return view('login');
    }
    public function logout()
    {
        session_start();
        unset($_SESSION["username"]);
        unset($_SESSION["loggedin"]);
        if (isset($_SESSION['bookedTime']))
            unset($_SESSION["bookedTime"]);
        if(isset($_SESSION['currentBooking']) )
            unset($_SESSION["currentBooking"]);
        if(isset($_SESSION['hasBooking']) )
            unset($_SESSION["hasBooking"]);
            
        return redirect('');
    }
    public function authenticate()
    {
        session_start();

        $errors = [];
        if (isset($_POST['username']) 
               && isset($_POST['password'])) 
        {
            $email = trim(htmlspecialchars(($_POST['username'])));
            $USERS = new JsonStorage(path('users.json'));
            $currentUser = $USERS->findOne(['email'=> $email]);
            if( isset($currentUser))
            {
                if (trim( htmlspecialchars($_POST['password'])) == $currentUser['password'])
                {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $currentUser;
                    
                    return redirect('');
                }
                else
                    $errors [] = 'Invalid user name or password';        
            }
            else
                $errors [] = 'Invalid user name or password';        
               
        }
        return view('login', ['errors' => $errors]);
    }
}

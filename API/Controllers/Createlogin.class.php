<?php

namespace App\Controller ;

class User extends controler{

    private function createUser($type,$payload)
    {
                $username= $payload['username'];
                $email= $payload['email'];
                $password= $payload['password'];
                $creationRequest= 'INSERT INTO users (first_name,email,password,created_at,update_at) VALUES ("'.$username.'","'.$email.'","'.$password.'","'.now().'","'.now().'")';

    }
    public function post($payload)
    {
        return parent::post(self::createUser('insert',$payload));
    }

}
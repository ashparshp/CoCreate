<?php

namespace App\Models;

class User
{
    public $username;
    public $password;
    public $email;

    public function __construct($username, $password, $email)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public static function createusers()
    {
        return [
            new self("ashparsh", 123456, "ashparsh@gmail.com"),
            new self("pandey", 123456, "pandey@gmail.com"),
        ];
    }

    public static function userexists($username, $password)
    {
        foreach (self::createusers() as $post) {
            if ($post->username == $username) {
                return true;
            }
        }
        return false;
    }
}

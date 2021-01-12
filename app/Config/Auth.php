<?php

namespace Config;

class Auth extends \Myth\Auth\Config\Auth
{
    public $allowRegistration = false;
    
    public $defaultUserGroup = 'staff';
    
    public $allowRemembering = true;
    
    public $activeResetter = false;
    
    public $requireActivation = false;
        
    public $views = [
        'login' => 'App\Views\login\login',
        'register' => 'Myth\Auth\Views\register',
        'forgot' => 'Myth\Auth\Views\forgot',
        'reset' => 'Myth\Auth\Views\reset',
        'emailForgot' => 'Myth\Auth\Views\emails\forgot',
        'emailActivation' => 'Myth\Auth\Views\emails\activation',
    ];   
}

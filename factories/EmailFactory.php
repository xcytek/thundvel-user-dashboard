<?php


use Services\IEmail;

class EmailFactory
{

    public static $instance;

    public static function getInstance() : EmailFactory
    {

        if (is_null(static::$instance) === true) {

            return new EmailFactory();

        }

        return static::$instance;

    }

    public static function getService($service) : IEmail
    {

        $class = '\\Services\\' . $service;

        if (class_exists($class) === true) {

            return new $class();

        }

        throw new Exception("Invalid email instance.", 404);

    }

}
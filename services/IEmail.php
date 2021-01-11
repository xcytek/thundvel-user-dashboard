<?php


namespace Services;


interface IEmail
{

    public function sendRecovery(array $data) : bool;

}
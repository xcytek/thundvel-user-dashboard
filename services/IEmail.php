<?php


namespace Services;


interface IEmail
{

    public function sendRecovery(array $data) : bool;

    public function sendVerifyAccount(array $data): bool;

}
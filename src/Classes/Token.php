<?php

class Token
{
    public static function createRandom()
    {
        return bin2hex(random_bytes(32)); // 64 chars
    }

    public static function hash($token)
    {
        return hash('sha256', $token);
    }
}

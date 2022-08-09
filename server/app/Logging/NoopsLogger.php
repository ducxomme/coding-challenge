<?php


namespace App\Logging;

use App\Logging\Logger;

/** 何もしないLogger（主にテスト用） */
final class NoopsLogger implements Logger
{
    public function debug(String $message, $context = [])
    {
        return;
    }

    public function info(String $message, $context = [])
    {
        return;
    }

    public function warn(String $message, $context = [])
    {
        return;
    }

    public function error(String $message, $context = [])
    {
        return;
    }

    public function fatal(String $message, $context = [])
    {
        return;
    }
}

<?php

namespace App\Logging;

use App\Logging\Formatters\ApplicationLogFormatter;

class Customizer
{
    /**
     * Customize the given logger instance.
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(app()->make(ApplicationLogFormatter::class));
        }
    }
}
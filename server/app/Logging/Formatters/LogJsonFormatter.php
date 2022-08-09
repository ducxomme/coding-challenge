<?php
declare(strict_types=1);

namespace App\Logging\Formatters;

use Monolog\Formatter\JsonFormatter;

/**
 * Class LogJsonFormatter
 * @package App\Logging\Formatters
 */
final class LogJsonFormatter extends JsonFormatter
{
    /**
     * @param int $batchMode
     * @param bool $appendNewline
     */
    public function __construct($batchMode = self::BATCH_MODE_JSON, $appendNewline = true)
    {
        parent::__construct($batchMode, $appendNewline);
        $this->includeStacktraces();
    }
}

<?php
declare(strict_types=1);

namespace App\Logging\Formatters;

use Carbon\Carbon;
use Illuminate\Hashing\HashManager;
use Monolog\Formatter\NormalizerFormatter;

/**
 * Class ApplicationLogFormatter
 * @package App\Logging\Formatters
 */
class ApplicationLogFormatter extends NormalizerFormatter
{
    /**
     * @var array
     */
    private $keys = [
        'query',
        'bind',
    ];

    /**
     * ログフォーマッタ
     * @param array $record
     * @return string
     */
    public function format(array $record): string
    {
        $formatted = parent::format($record);
        $requestId = $_SERVER['HTTP_REQUEST_ID'] ?? 'no-request-id';
        $segments = [
            'requestId' => $requestId,
            'datetime' => $formatted['datetime'],
            'level_name' => $formatted['level_name'],
        ];

        foreach ($this->keys as $key) {
            if (isset($formatted['context'][$key])) {
                $segments[$key] = $formatted['context'][$key];
            }
        }
        return json_encode($segments) . PHP_EOL;
    }
}
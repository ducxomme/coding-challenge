<?php
declare(strict_types=1);

namespace App\Logging;

// use GuzzleHttp\Handler\StreamHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;

/**
 * Class SQLQueryLogger
 * @package App\Logging
 */
class SQLQueryLogger
{
    public function __invoke(array $config)
    {
        // 引数の $config には、config/logging.php で sqlQueryLog に設定した path とか days とかが入ってる！

        // 'debug' とかの文字列をMonologが使えるログレベルに変換
        $level = Logger::toMonologLevel($config['level']);

        // 日ごとにログローテートするハンドラ作成
        $handler = new RotatingFileHandler($config['path'], $config['days'], $level);

        // 改行コードを出力する＆カラのコンテキストを出力しないフォーマッタを設定
        $handler->setFormatter(new LineFormatter(null, null, true, true));

        // Monologインスタンス作成してハンドラ設定して返却
        $logger = new Logger('SQL');  // ロガー名は 'SQL' にした。これはログに出力される
        $logger->pushHandler($handler);
        return $logger;
    }
}

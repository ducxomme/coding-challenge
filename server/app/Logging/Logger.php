<?php
declare(strict_types=1);


namespace App\Logging;

/** Loggerのインターフェイス */
interface Logger
{
    /**
     * デバッグ情報
     * システムの動作状況に関する詳細な情報
     *
     * @param String $message
     * @param array $context
     * @return mixed
     */
    public function debug(String $message, $context = []);

    /**
     * 情報
     * 実行時の何らかの注目すべき事象（開始や終了など）。
     * メッセージ内容は簡潔に止めるべき
     *
     * @param String $message
     * @param array $context
     * @return mixed
     */
    public function info(String $message, $context = []);

    /**
     * 警告
     * DeprecatedとなったAPIの使用、APIの不適切な使用、エラーに近い事象など。
     * 実行時に生じた異常とは言い切れないが正常とも異なる何らかの予期しない問題
     *
     * @param String $message
     * @param array $context
     * @return mixed
     */
    public function warn(String $message, $context = []);

    /**
     * エラー
     * 予期しないその他の実行時エラー。コンソール等に即時出力することを想定
     *
     *
     * @param String $message
     * @param array $context
     * @return mixed
     */
    public function error(String $message, $context = []);

    /**
     * 致命的なエラー
     * プログラムの異常終了を伴うようなもの。コンソール等に即時出力することを想定
     *
     * @param String $message
     * @param array $context
     * @return mixed
     */
    public function fatal(String $message, $context = []);
}
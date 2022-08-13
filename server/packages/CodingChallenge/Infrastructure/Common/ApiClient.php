<?php
declare(strict_types=1);

namespace CodingChallenge\Infrastructure\Common;

use Exception;
use Log;

/**
 * Class ApiClient
 */
final class ApiClient
{
    /**
     * @param string $url
     * @return array
     * @throws Exception
     */
    public static function get(string $url): array
    {
        $ch = curl_init();

        // オプション設定
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す

        // ヘッダー追加オプション
        curl_setopt($ch, CURLOPT_HTTPHEADER, []);

        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        curl_close($ch);

        if ($httpCode !== 200) {
            Log::error('API でエラーがありました。');
            Log::info("$url $response");
            throw new Exception('API でエラーがありました。');
        }

        $result = json_decode($response, true);;

        return $result;
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\InvalidJwtException;
use Closure;
use Illuminate\Http\Request;
use App\Logging\Logger;
use \Illuminate\Support\Facades\Config;
use \Illuminate\Support\Facades\DB;

final class IdentifyUser
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * IdentifyUser constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws InvalidJwtException
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->bearerToken();
            list($header, $payload, $signature) = explode('.', $token);
            $decoded = json_decode(base64_decode($payload), true);

            // nginx によって注入された request-id を使って一連の処理をトレースする
            $requestId = $_SERVER['HTTP_REQUEST_ID'] ?? 'no-request-id';

            $companyRoot = $decoded['company_root'];
            $iss = $decoded['iss'];
            $tenantId = $decoded['tenant_id'];
            $this->logger->info("requestId: $requestId, company: $companyRoot, iss: $iss, tenantId: $tenantId");

            // 個社スキーマ名指定
            $dbCompanyPreDatabase = getenv('DB_COMPANY_PRE_DATABASE');
            $database = $dbCompanyPreDatabase . $companyRoot;
            Config::set('database.connections.mysql.database', $database);

            $dbEncrypt = env('DB_ENCRYPT');
            $password = '';
            if (isset($dbEncrypt) && $dbEncrypt) {
                $password = base64_decode(str_rot13(getenv("DB_PASSWORD")));
            } else {
                $password = getenv("DB_PASSWORD");
            }
            Config::set('database.connections.mysql.password', $password);

            // https://github.com/laravel/framework/blob/2555bf6ef6e6739e5f49f4a5d40f6264c57abd56/src/Illuminate/Database/DatabaseManager.php#L198
            DB::purge('mysql');

            return $next($request);
        } catch (\Exception $e) {
            // API Gatewayでチェックが走っているのでこの中には到達しないはず
            // 到達した場合は異常事態
            $requestId = $_SERVER['HTTP_REQUEST_ID'] ?? 'no-request-id';
            $this->logger->error("[$requestId] invalid jwt when identifying tenant", ['exception' => $e]);
            throw new InvalidJwtException(__LINE__, $e);
        }
    }
}
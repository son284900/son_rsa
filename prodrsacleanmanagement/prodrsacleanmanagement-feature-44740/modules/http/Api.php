<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/06
 */
namespace Modules\http;

/**
 * Class Api
 * @package Modules\http
 * @author y_kishimoto
 */
class Api extends Client implements ClientInterface
{

    /**
     * @var
     */
    private static $_instance;

    /**
     * @param string $method
     * @param string $uri
     * @param string $path
     * @param array $headers
     * @return Api
     */
    public static function getInstance(string $method, string $uri, string $path, array $headers = []): Api
    {
        self::$_instance = new self($method, $uri, $path, $headers);

        return self::$_instance;
    }

    /**
     * レスポンス
     */
    public function response()
    {
        $params = [
            'headers' => $this->getHeaders(),
            'port' => 28680,
        ];

        if ($this->getFormParams() !== null) {
            $params['form_params'] = $this->getFormParams();
        }

        $res = $this->getClient()->request($this->getMethod(), $this->getPath(), $params);

        $responseBody = (string) $res->getBody();

        return $responseBody;
    }
}

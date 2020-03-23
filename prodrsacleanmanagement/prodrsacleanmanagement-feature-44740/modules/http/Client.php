<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/06
 */

namespace Modules\http;

/**
 * Class Client
 * @package Modules\http
 * @author y_kishimoto
 */
class Client
{

    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DEL = 'DELETE';

    /**
     * @var \GuzzleHttp\Client
     */
    private $_client;

    /**
     * @var string
     */
    private $_uri;

    /**
     * @var string
     */
    private $_path;

    /**
     * @var array
     */
    private $_headers;

    /**
     * @var string
     */
    private $_method;

    private $_formParams;

    /**
     * Client constructor.
     * @param string $method
     * @param string $uri
     * @param string $path
     * @param array $headers
     */
    public function __construct(string $method, string $uri, string $path = null, $headers = [])
    {
        $this->_method = $method;
        $this->_uri = $uri;
        $this->_path = $path;
        $this->_headers = $headers;

        $this->_client  = new \GuzzleHttp\Client([
            'base_uri' => $uri
        ]);
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient(): \GuzzleHttp\Client
    {
        return $this->_client;
    }

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function setClient(\GuzzleHttp\Client $client): void
    {
        $this->_client = $client;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->_uri;
    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri): void
    {
        $this->_uri = $uri;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->_path;
    }

    /**
     * @param string $path
     * @return Client
     */
    public function setPath(string $path): Client
    {
        $this->_path = $path;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->_headers;
    }

    /**
     * @param array $headers
     * @return Client
     */
    public function setHeaders(array $headers): Client
    {
        $this->_headers = $headers;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->_method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->_method = $method;
    }

    /**
     * @return mixed
     */
    public function getFormParams()
    {
        return $this->_formParams;
    }

    /**
     * @param mixed $formParams
     * @return Client
     */
    public function setFormParams($formParams): Client
    {
        $this->_formParams = $formParams;

        return $this;
    }
}

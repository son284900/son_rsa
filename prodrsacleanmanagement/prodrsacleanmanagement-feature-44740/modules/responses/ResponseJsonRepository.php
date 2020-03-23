<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/06
 */
namespace Modules\responses;

use Modules\BuildInterface;

/**
 * Class ResponseJsonRepository
 *
 * @package Modules\responses
 * @author y_kishimoto
 */
class ResponseJsonRepository extends ResponseAbstract implements BuildInterface
{

    /**
     * Singleton インスタンス
     *
     */
    private static $singleton;

    /**
     * @var array
     */
    private $_repository;

    /**
     * @var
     */
    private $_responseString;

    /**
     * @var string
     */
    private $_status;

    /**
     * @var array
     */
    private $_result;

    /**
     * @var array
     */
    private $_data;

    /**
     * @var string
     */
    private $_message;

    /**
     * @var string
     */
    private $_code;

    /**
     * @var array
     */
    private $_errors;

    /**
     * ResponseJsonRepository constructor.
     */
    private function __construct()
    {
        $this->_repository = [

        ];

        $this->_responseString = '';
        $this->_status = '';
        $this->_result = array();
        $this->_data = array();
        $this->_message = '';
        $this->_code = '';
        $this->_errors = array();
    }

    /**
     * Singleton
     *
     */
    public static function getInstance()
    {
        if (self::$singleton === null) {
            self::$singleton = new ResponseJsonRepository();
        }

        return self::$singleton;
    }

    /**
     * @return array
     */
    public function getRepository(): array
    {
        return $this->_repository;
    }

    /**
     * @param array $repository
     * @return ResponseJsonRepository
     */
    public function setRepository(array $repository): ResponseJsonRepository
    {
        $this->_repository = $repository;

        return $this;
    }

    /**
     * @return json
     */
    public function getResponseString()
    {
        return $this->_responseString;
    }

    /**
     * Json レスポンスをjson_encodeしてセット
     *
     * @param string $responseString
     * @return ResponseJsonRepository
     */
    public function setResponseString($responseString): ResponseJsonRepository
    {
        $this->_responseString = $responseString;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->_status;
    }

    /**
     * @param string $status
     * @return ResponseJsonRepository
     */
    public function setStatus(string $status): ResponseJsonRepository
    {
        $this->_status = $status;

        return $this;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->_result;
    }

    /**
     * @param array $result
     * @return ResponseJsonRepository
     */
    public function setResult(array $result): ResponseJsonRepository
    {
        $this->_result = $result;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->_data;
    }

    /**
     * @param array $data
     * @return ResponseJsonRepository
     */
    public function setData(array $data): ResponseJsonRepository
    {
        $this->_data = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->_message;
    }

    /**
     * @param string $message
     * @return ResponseJsonRepository
     */
    public function setMessage(string $message): ResponseJsonRepository
    {
        $this->_message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->_code;
    }

    /**
     * @param string $errCode
     * @return ResponseJsonRepository
     */
    public function setCode(string $code): ResponseJsonRepository
    {
        $this->_code = $code;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->_errors;
    }

    /**
     * @param array $errors
     * @return ResponseJsonRepository
     */
    public function setErrors(array $errors): ResponseJsonRepository
    {
        $this->_errors = $errors;

        return $this;
    }

    /**
     * 構築
     *
     * @return mixed
     */
    public function build()
    {
        if ($this->_responseString !== null) {
            $buf = json_decode($this->_responseString, true);

            $this->setStatus($buf['status'])
                ->setData($buf['result']['data'])
                ->setMessage($buf['result']['message'])
                ->setCode($buf['result']['code'])
                ->setErrors($buf['result']['errors']);
        }
    }
}

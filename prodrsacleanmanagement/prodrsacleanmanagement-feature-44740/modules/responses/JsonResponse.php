<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/06
 */

namespace Modules\responses;

use Illuminate\Http\Response;
use PhpParser\Node\Expr\Cast\Array_;

/**
 * Class JsonResponse
 *
 * @package Modules\responses
 * @author y_kishimoto
 */
class JsonResponse extends ResponseAbstract implements ResponseInterface
{

    /**
     * Singleton インスタンス
     *
     */
    private static $singleton;

    /**
     * レスポンスステータス OKの場合
     */
    public const STATUS_OK = 'success';

    /**
     * レスポンスステータス NGの場合
     */
    public const STATUS_NG = 'failed';


    /**
     * JsonResponse constructor.
     */
    private function __construct()
    {
        self::$singleton = $this->setResponse(self::getTemplate());
    }

    /**
     * Singleton
     *
     * @return JsonResponse
     */
    public static function getInstance(): JsonResponse
    {
        if (self::$singleton === null) {
            self::$singleton = new JsonResponse();
        }

        return self::$singleton;
    }

    /**
     * リスポンス テンプレート 取得
     *
     * @return array
     */
    public static function getTemplate(): array
    {
        return [
            'status' => '',
            'result' => [
                'data' => array(),
                'message' => '',
                'code' => '',
                'errors' => array(),
            ],
        ];
    }

    /**
     * ステータス取得
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->response['status'];
    }

    /**
     * ステータスセット
     *
     * @param string $status
     * @return JsonResponse
     */
    public function setStatus(string $status): JsonResponse
    {
        $this->response['status'] = $status;

        return $this;
    }

    /**
     * 結果データ
     *
     * @param array $result
     * @return JsonResponse
     */
    public function setResult(array $result): JsonResponse
    {
        $this->response['result'] = $result;

        return $this;
    }

    /**
     * セットデータ
     *
     * @param array $data
     * @return JsonResponse
     */
    public function setData($data): JsonResponse
    {
        $this->response['result']['data'] = $data;

        return $this;
    }

    /**
     * データ取得
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->response['result']['data'];
    }

    /**
     * メッセージセット
     *
     * @param string $message
     * @return JsonResponse
     */
    public function setMessage(string $message): JsonResponse
    {
        $this->response['result']['message'] = $message;

        return $this;
    }

    /**
     * メッセージ取得
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->response['result']['message'];
    }

    /**
     * コード取得
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->response['result']['code'];
    }

    /**
     * コードセット
     *
     * @param string $code
     * @return JsonResponse
     */
    public function setCode(string $code): JsonResponse
    {
        $this->response['result']['code'] = $code;

        return $this;
    }

    /**
     * セットエラー
     *
     * @param array $errors
     * @return JsonResponse
     */
    public function setErrors($errors): JsonResponse
    {
        $this->response['result']['errors'] = $errors;

        return $this;
    }

    /**
     * エラー取得
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->response['result']['errors'];
    }

    /**
     * Jsonレスポンス
     */
    public function response(): Response
    {
        return response($this->response);
    }
}

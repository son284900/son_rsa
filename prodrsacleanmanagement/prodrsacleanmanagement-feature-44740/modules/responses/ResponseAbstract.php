<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/06
 */
namespace Modules\responses;

use Modules\CoreInterface;

/**
 * Class ResponseAbstract
 *
 * @package Modules\responses
 * @author y_kishimoto
 */
abstract class ResponseAbstract implements CoreInterface
{

    /**
     * レスポンスデータ
     *
     * @var array
     */
    protected $response;

    /**
     * ステータス
     *
     * @var int
     */
    protected $status = 200;

    /**
     * ヘッダー
     *
     * @var array
     */
    protected $header = [];

    /**
     * Singleton
     *
     */
    abstract public static function getInstance();

    /**
     * レスポンスセット
     *
     * @param array $response
     * @return ResponseAbstract
     */
    public function setResponse(array $response): ResponseAbstract
    {
        $this->response = $response;

        return $this;
    }
}

<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/06
 */
namespace Modules\http;

interface ClientInterface
{
    /**
     * レスポンス
     *
     * @return mixed
     */
    public function response();
}

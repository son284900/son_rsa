<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/09
 */
namespace Modules\db;

use Modules\CoreInterface;

/**
 * Class DbAbstract
 * @package Modules\Db
 * @author y_kishimoto
 */
abstract class DbAbstract implements CoreInterface
{
    /**
     * 接続
     *
     * @return mixed
     */
    abstract public function connector();
}

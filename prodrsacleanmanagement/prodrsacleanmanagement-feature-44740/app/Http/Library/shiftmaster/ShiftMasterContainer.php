<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/09
 */

namespace App\Http\Library\shiftmaster;

use Modules\ContainerAbstract;
use Pimple\Container;
use App\Models\MasterRsShiftModel;

/**
 * Class ShiftMasterContainer
 *
 * @package App\Http\Library
 * @author y_kishimoto
 */
class ShiftMasterContainer extends ContainerAbstract
{
    /**
     * 定数 KEYタイプ ShiftMaster
     */
    public const KEY_SHIFT_MASTER = 'shift.master';

    /**
     * 定数 KEYタイプ モデル 清掃シフトマスタ
     */
    public const KEY_MODEL1 = 'model.m_rscleaningshift';

    /**
     * 定数 KEYタイプ SEARCH BUILDER
     */
    public const KEY_SEARCH_BUILDER = 'shift.master.search.builder';

    /**
     * インスタンス
     *
     * @var ShiftMasterContainer
     */
    private static $_instance;

    /**
     * ShiftMasterContainer constructor.
     * @param Container $container
     */
    private function __construct(Container $container)
    {
        $this->container = $container;

        $this->container[self::KEY_MODEL1] = function () {
            return new MasterRsShiftModel();
        };

        $this->container[self::KEY_SEARCH_BUILDER] = function () {
            return new ShiftMasterSearchBuilder();
        };

        $this->container[self::KEY_SHIFT_MASTER] = function ($c) {
            return new ShiftMaster($c[self::KEY_PARAMS], $c[self::KEY_MODEL1], $c[self::KEY_SEARCH_BUILDER]);
        };
    }

    /**
     * Singleton
     *
     * @param Container $container
     * @return ShiftMasterContainer
     */
    public static function getInstance(Container $container): ShiftMasterContainer
    {
        if (self::$_instance === null) {
            self::$_instance = new ShiftMasterContainer($container);
        } else {
            self::$_instance->container[self::KEY_SHIFT_MASTER]->setParams(
                $container[self::KEY_PARAMS]
            );
        }

        return self::$_instance;
    }
}

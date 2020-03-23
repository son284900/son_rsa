<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/03/02
 */

namespace App\Http\Library\cleanstatusmaster;

use Modules\ContainerAbstract;
use Pimple\Container;
use App\Models\MasterRsCleanStatusModel;

/**
 * Class CleanStatusMasterContainer
 *
 * @package App\Http\Library
 * @author y_kishimoto
 */
class CleanStatusMasterContainer extends ContainerAbstract
{
    /**
     * 定数 KEYタイプ CleanStatusMaster
     */
    public const KEY_CLEAN_STATUS_MASTER = 'clean.status.master';

    /**
     * 定数 KEYタイプ モデル 清掃ステータスマスタ
     */
    public const KEY_MODEL1 = 'model.m_rscleaningstatus';

    /**
     * 定数 KEYタイプ SEARCH BUILDER
     */
    public const KEY_SEARCH_BUILDER = 'clean.status.master.search.builder';

    /**
     * インスタンス
     *
     * @var CleanStatusMasterContainer
     */
    private static $_instance;

    /**
     * CleanStatusMasterContainer constructor.
     * @param Container $container
     */
    private function __construct(Container $container)
    {
        $this->container = $container;

        $this->container[self::KEY_MODEL1] = function () {
            return new MasterRsCleanStatusModel();
        };

        $this->container[self::KEY_SEARCH_BUILDER] = function () {
            return new CleanStatusMasterSearchBuilder();
        };

        $this->container[self::KEY_CLEAN_STATUS_MASTER] = function ($c) {
            return new CleanStatusMaster($c[self::KEY_PARAMS], $c[self::KEY_MODEL1], $c[self::KEY_SEARCH_BUILDER]);
        };
    }

    /**
     * Singleton
     *
     * @param Container $container
     * @return CleanStatusMasterContainer
     */
    public static function getInstance(Container $container): CleanStatusMasterContainer
    {
        if (self::$_instance === null) {
            self::$_instance = new CleanStatusMasterContainer($container);
        } else {
            self::$_instance->container[self::KEY_CLEAN_STATUS_MASTER]->setParams(
                $container[self::KEY_PARAMS]
            );
        }

        return self::$_instance;
    }
}

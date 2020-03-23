<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/06
 */
namespace Modules;

use Pimple\Container;

/**
 * Class ContainerAbstract
 * @package Modules
 * @author y_kishimoto
 */
abstract class ContainerAbstract
{
    /**
     * 定数 KEYタイプ REQUEST
     */
    public const KEY_REQUEST = 'request';

    /**
     * 定数 KEYタイプ パラメータ
     */
    public const KEY_PARAMS = 'params';

    /**
     * @var Container
     */
    protected $container;

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @param Container $container
     */
    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }
}

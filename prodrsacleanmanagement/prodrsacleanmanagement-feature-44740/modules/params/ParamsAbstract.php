<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/06
 */
namespace Modules\params;

use Illuminate\Http\Request;

/**
 * Class ParamsAbstract
 * @package Modules\params
 * @author y_kishimoto
 */
abstract class ParamsAbstract
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var null
     */
    protected $id;

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
}

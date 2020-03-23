<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/06
 */
namespace Modules\params;

use Illuminate\Http\Request;

/**
 * Class Params
 * @package Modules\params
 * @author y_kishimoto
 */
class Params extends ParamsAbstract
{
    /**
     * Params constructor.
     * @param Request $request
     * @param $id
     */
    public function __construct(Request $request, $id = null)
    {
        $this->request = $request;
        $this->id = $id;
    }
}

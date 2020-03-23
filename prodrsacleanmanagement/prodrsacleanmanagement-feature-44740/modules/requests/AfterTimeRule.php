<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/26
 */

namespace Modules\requests;

use Illuminate\Contracts\Validation\Rule;
use Modules\date\Date;

/**
 * Class AfterTimeRule
 *
 * @package Modules\requests
 * @author y_kishimoto
 */
class AfterTimeRule implements Rule
{
    /**
     * @var string
     */
    protected $_axis;

    /**
     * @var array
     */
    protected $_parameters;

    /**
     * @var string
     */
    protected $_property;

    /**
     * AfterTimeRule constructor.
     */
    public function __construct(string $axis, array $parameters = [], ?string $property = null)
    {
        $this->_axis = $axis;
        $this->_parameters = $parameters;
        $this->_property = $property;
    }

    /**
     * 検証
     *
     * @return
     */
    public function passes($attribute, $value)
    {
        if ($this->_property === null) {
            $this->_property = $attribute;
        }

        $date = new Date();

        // 基準時間
        $axisTime = $date->createDateTime($this->_parameters[$this->_axis]);

        // 検証対象時間
        $inspectionTime = $date->createDateTime($value);

        return $inspectionTime->gte($axisTime);
    }

    /**
     * メッセージ
     *
     * @return string
     */
    public function message()
    {
        return ':attribute '.'is the time after '.$this->_axis;
    }
}

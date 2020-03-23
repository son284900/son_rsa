<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/26
 */

namespace Modules\requests;

use Illuminate\Contracts\Validation\Rule;
use Modules\date\Date;
use Carbon\Carbon;

/**
 * Class BetweenTimeRule
 *
 * @package Modules\requests
 * @author y_kishimoto
 */
class BetweenTimeRule implements Rule
{
    /**
     * @var string
     */
    protected $_axisStart;

    /**
     * @var string
     */
    protected $_axisEnd;

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
    public function __construct(string $axisStart, string $axisEnd, array $parameters = [], ?string $property = null)
    {
        $this->_axisStart = $axisStart;
        $this->_axisEnd = $axisEnd;
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

        // 基準 開始時間
        $axisStartTime = $date->createDateTime($this->_parameters[$this->_axisStart]);

        // 基準 終了時間
        $axisEndTime = $date->createDateTime($this->_parameters[$this->_axisEnd]);

        // 検証対象時間
        $inspectionTime = $date->createDateTime($value);

        return Carbon::parse($inspectionTime)->between($axisStartTime, $axisEndTime);
    }

    /**
     * メッセージ
     *
     * @return string
     */
    public function message()
    {
        return ':attribute ' . 'is between time ' .$this->_axisStart.' and '.$this->_axisEnd;
    }
}

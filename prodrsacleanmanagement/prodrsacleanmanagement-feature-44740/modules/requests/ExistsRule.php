<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/25
 */

namespace Modules\requests;

use Illuminate\Contracts\Validation\Rule;
use Modules\db\ModelAbstract;

/**
 * Class ExistsRule
 *
 * @package Modules\requests
 * @author y_kishimoto
 */
class ExistsRule implements Rule
{
    /**
     * @var ModelAbstract
     */
    protected $_model;

    /**
     * @var string
     */
    protected $_property;

    /**
     * ExistsRule constructor.
     */
    public function __construct(ModelAbstract $model, ?string $property = null)
    {
        $this->_model = $model;
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

        $model = $this->_model->searchQuery();

        return $model->where($this->_property, $value)->exists();
    }

    /**
     * メッセージ
     *
     * @return string
     */
    public function message()
    {
        return ':attribute data does not exist.';
    }
}

<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/25
 */

namespace App\Http\Requests\shiftmaster;

use Modules\requests\RequestAbstract;
use Modules\requests\ExistsRule;
use App\Models\MasterRsShiftModel;

/**
 * Class ShiftMasterShowRequest
 *
 * @package App\Http\Requests
 * @author y_kishimoto
 */
class ShiftMasterShowRequest extends RequestAbstract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [
                new ExistsRule(new MasterRsShiftModel())
            ],
        ];
    }

    /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages(): array
    {
        return [
        ];
    }
}

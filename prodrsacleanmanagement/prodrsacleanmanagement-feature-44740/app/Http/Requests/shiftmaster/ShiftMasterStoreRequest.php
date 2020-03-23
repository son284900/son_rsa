<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/23
 */

namespace App\Http\Requests\shiftmaster;

use Modules\requests\RequestAbstract;
use Modules\requests\AfterTimeRule;
use Modules\requests\BetweenTimeRule;
use Modules\requests\ExistsRule;
use App\Models\MasterRsShiftModel;

/**
 * Class ShiftMasterStoreRequest
 *
 * @package App\Http\Requests
 * @author y_kishimoto
 */
class ShiftMasterStoreRequest extends RequestAbstract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $parameters = $this->request->all();
        return [
            'cleaningshiftcode' => 'required | string | max:3',
            'shiftstarttime' => 'required | date_format:Hi',
            'shiftendtime' => [
                'required',
                'date_format:Hi',
                new AfterTimeRule('shiftstarttime', $parameters)
            ],
            'breakstarttime' => [
                'nullable',
                'date_format:Hi',
                new BetweenTimeRule('shiftstarttime', 'shiftendtime', $parameters)
            ],
            'breakendtime' => [
                'nullable',
                'date_format:Hi',
                new AfterTimeRule('breakstarttime', $parameters),
                new BetweenTimeRule('shiftstarttime', 'shiftendtime', $parameters)
            ],
            'name' => 'required | string | max:30',
            'shortname' => 'nullable | string | max:10',
            'description' => 'nullable | string | max:200',
            'sequence' => 'nullable | integer ',
            'deleted_at' => 'nullable | date_format:Y-m-d H:i:s',
            'id' => [
                'nullable',
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

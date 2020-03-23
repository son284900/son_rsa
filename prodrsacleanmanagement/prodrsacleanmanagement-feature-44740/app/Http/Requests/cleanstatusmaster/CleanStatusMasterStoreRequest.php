<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/23
 */

namespace App\Http\Requests\cleanstatusmaster;

use Modules\requests\RequestAbstract;
use Modules\requests\ExistsRule;
use App\Models\MasterRsCleanStatusModel;

/**
 * Class CleanStatusMasterStoreRequest
 *
 * @package App\Http\Requests
 * @author y_kishimoto
 */
class CleanStatusMasterStoreRequest extends RequestAbstract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cleaningstatusname' => 'required | string | max:15',
            'description' => 'nullable | string | max:200',
            'sequence' => 'nullable | integer ',
            'deleted_at' => 'nullable | date_format:Y-m-d H:i:s',
            'id' => [
                'nullable',
                new ExistsRule(new MasterRsCleanStatusModel())
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

<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/03/02
 */

namespace App\Http\Requests\cleanstatusmaster;

use Modules\requests\RequestAbstract;
use Modules\requests\ExistsRule;
use App\Models\MasterRsCleanStatusModel;

/**
 * Class CleanStatusMasterShowRequest
 *
 * @package App\Http\Requests
 * @author y_kishimoto
 */
class CleanStatusMasterShowRequest extends RequestAbstract
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

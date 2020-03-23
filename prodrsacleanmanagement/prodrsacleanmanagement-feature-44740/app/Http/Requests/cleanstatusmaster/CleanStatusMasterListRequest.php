<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/03/02
 */

namespace App\Http\Requests\cleanstatusmaster;

use Modules\requests\RequestAbstract;
use Illuminate\Validation\Rule;

/**
 * Class CleanStatusMasterListRequest
 *
 * @package App\Http\Requests
 * @author y_kishimoto
 */
class CleanStatusMasterListRequest extends RequestAbstract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'q' => 'present',
            'limit' => 'present|integer',
            'offset' => 'present|integer',
            'sort' => ['present','json','not_regex:/[0-9]+/'],
            'in_deleted' => ['integer','nullable', Rule::in(config('request.IN_DELETED_ITEM'))],
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
            'sort.not_regex' => 'The sort must be a valid JSON string.',
        ];
    }
}

<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/23
 */

namespace App\Http\Requests\cleanstatusmaster;

use Modules\requests\RequestAbstract;
use Illuminate\Validation\Rule;

/**
 * Class CleanStatusMasterDeleteRequest
 *
 * @package App\Http\Requests
 * @author y_kishimoto
 */
class CleanStatusMasterDeleteRequest extends RequestAbstract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'delete_ids' => 'required | array',
            'delete_ids.*' => 'integer',
            'delete_type' => ['required','integer', Rule::in(config('request.DELETE_TYPE_ITEM'))],
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

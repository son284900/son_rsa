<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/06
 */

namespace App\Http\Requests;

use Modules\requests\RequestAbstract;

/**
 * Class AuthRequest
 *
 * @package App\Http\Requests
 * @author y_kishimoto
 */
class AuthRequest extends RequestAbstract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login_id' => 'required|string',
            'password' => 'required|string',
            'user_company_id' => 'required|string',
            'device_uuid' => 'required|string',
            'device_name' => 'required|string',
            'device_os_name' => 'required|string',
            'device_os_version' => 'required|string',
            'hardware_name' => 'required|string',
            'notice_room_service' => 'nullable|string',
            'notice_room_status' => 'nullable|string',
            'browser_info' => 'nullable|string',
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
            'login_id.required' => 'ログインIDを入力してください',
            'login_id.string' => 'ログインIDは文字列で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.string' => 'パスワードは文字列で入力してください',
            'user_company_id.required' => 'クライアントIDを入力してください',
            'user_company_id.string' => 'クライアントIDは文字列で入力してください',
            'device_uuid.required' => '端末固有IDを入力してください',
            'device_uuid.string' => '端末固有IDは文字列で入力してください',
            'device_name.required' => '端末名称を入力してください',
            'device_name.string' => '端末名称は文字列で入力してください',
            'device_os_name.required' => 'OS名称を入力してください',
            'device_os_name.string' => 'OS名称は文字列で入力してください',
            'device_os_version.required' => 'OSバージョンを入力してください',
            'device_os_version.string' => 'OSバージョンは文字列で入力してください',
            'hardware_name.required' => 'ハードウェア名を入力してください',
            'hardware_name.string' => 'ハードウェア名は文字列で入力してください',
            'notice_room_service.string' => 'ルームサービス通知設定は文字列で入力してください',
            'notice_room_status.string' => 'ルームステータス通知設定は文字列で入力してください',
            'browser_info.string' => 'ブラウザ情報は文字列で入力してください',
        ];
    }
}

<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/06
 */
namespace App\Http\Controllers\api\auth;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
// use App\Http\Library\Auth\AuthContainer;
// use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Modules\Controller;
use Modules\params\Params;
use Modules\responses\JsonResponse;
use Pimple\Container;

/**
 * ログインアカウント コントローラ クラス
 *
 * @package api
 * @subpackage auth
 * @author y_kishimoto
 * @since PHP7.4
 */
class LoginAccountController extends Controller
{
    /**
     * ログイン
     *
     * @param AuthRequest $req
     * @return Response
     */
    public function login(AuthRequest $req): Response
    {
        return JsonResponse::getInstance()->response();
    }

    /**
     * ログアウト
     *
     * @param Request $req
     * @return Response
     */
    public function logout(Request $req): Response
    {
        return JsonResponse::getInstance()->response();
    }
}

<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/03/02
 */

namespace App\Http\Controllers\api\master;

use App\Http\Requests\cleanstatusmaster\CleanStatusMasterListRequest;
use App\Http\Requests\cleanstatusmaster\CleanStatusMasterDeleteRequest;
use App\Http\Requests\cleanstatusmaster\CleanStatusMasterStoreRequest;
use App\Http\Requests\cleanstatusmaster\CleanStatusMasterShowRequest;
use Illuminate\Http\Response;
use Modules\Controller;
use Modules\params\Params;
use Modules\responses\JsonResponse;
use Pimple\Container;
use App\Http\Library\cleanstatusmaster\CleanStatusMasterContainer;

/**
 * 清掃ステータスマスタ コントローラ クラス
 *
 * @package api
 * @subpackage master
 * @author y_kishimoto
 * @since PHP7.4
 */
class CleanStatusMasterController extends Controller
{
    /**
     *  一覧
     *
     * @param CleanStatusMasterListRequest $req
     * @return Response
     */
    public function list(CleanStatusMasterListRequest $req): Response
    {
        JsonResponse::getInstance()->setResponse(JsonResponse::getTemplate());

        $container = new Container();
        $container[CleanStatusMasterContainer::KEY_REQUEST] = $req;
        $container[CleanStatusMasterContainer::KEY_PARAMS] = new Params($req);

        $c = CleanStatusMasterContainer::getInstance($container)->getContainer();
        $c[CleanStatusMasterContainer::KEY_CLEAN_STATUS_MASTER]->list();

        return JsonResponse::getInstance()->response();
    }

    /**
     * 詳細
     *
     * @param CleanStatusMasterShowRequest $req
     * @param int $id
     * @return Response
     */
    public function show(CleanStatusMasterShowRequest $req, int $id): Response
    {
        JsonResponse::getInstance()->setResponse(JsonResponse::getTemplate());

        $container = new Container();
        $container[CleanStatusMasterContainer::KEY_REQUEST] = $req;
        $container[CleanStatusMasterContainer::KEY_PARAMS] = new Params($req, $id);

        $c = CleanStatusMasterContainer::getInstance($container)->getContainer();
        $c[CleanStatusMasterContainer::KEY_CLEAN_STATUS_MASTER]->show();

        return JsonResponse::getInstance()->response();
    }

    /**
     * 登録
     *
     * @param CleanStatusMasterStoreRequest $req
     * @return Response
     */
    // public function store(CleanStatusMasterStoreRequest $req): Response
    // {
    //     JsonResponse::getInstance()->setResponse(JsonResponse::getTemplate());
    //     return JsonResponse::getInstance()->response();
    // }

    /**
     * 更新
     *
     * @param CleanStatusMasterStoreRequest $req
     * @param int $id
     * @return Response
     */
    public function update(CleanStatusMasterStoreRequest $req, int $id): Response
    {
        JsonResponse::getInstance()->setResponse(JsonResponse::getTemplate());

        $container = new Container();
        $container[CleanStatusMasterContainer::KEY_REQUEST] = $req;
        $container[CleanStatusMasterContainer::KEY_PARAMS] = new Params($req, $id);

        $c = CleanStatusMasterContainer::getInstance($container)->getContainer();
        $c[CleanStatusMasterContainer::KEY_CLEAN_STATUS_MASTER]->update();

        return JsonResponse::getInstance()->response();
    }

    /**
     * 削除
     *
     * @param CleanStatusMasterDeleteRequest $req
     * @param int $id
     * @return Response
     */
    public function delete(CleanStatusMasterDeleteRequest $req): Response
    {
        JsonResponse::getInstance()->setResponse(JsonResponse::getTemplate());

        $container = new Container();
        $container[CleanStatusMasterContainer::KEY_REQUEST] = $req;
        $container[CleanStatusMasterContainer::KEY_PARAMS] = new Params($req);

        $c = CleanStatusMasterContainer::getInstance($container)->getContainer();
        $c[CleanStatusMasterContainer::KEY_CLEAN_STATUS_MASTER]->delete();

        return JsonResponse::getInstance()->response();
    }
}

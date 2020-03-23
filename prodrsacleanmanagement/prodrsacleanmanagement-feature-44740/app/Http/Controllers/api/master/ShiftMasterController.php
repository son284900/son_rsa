<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/08
 */

namespace App\Http\Controllers\api\master;

use App\Http\Requests\shiftmaster\ShiftMasterListRequest;
use App\Http\Requests\shiftmaster\ShiftMasterDeleteRequest;
use App\Http\Requests\shiftmaster\ShiftMasterStoreRequest;
use App\Http\Requests\shiftmaster\ShiftMasterShowRequest;
use Illuminate\Http\Response;
use Modules\Controller;
use Modules\params\Params;
use Modules\responses\JsonResponse;
use Pimple\Container;
use App\Http\Library\shiftmaster\ShiftMasterContainer;

/**
 * 清掃シフトマスタ コントローラ クラス
 *
 * @package api
 * @subpackage master
 * @author y_kishimoto
 * @since PHP7.4
 */
class ShiftMasterController extends Controller
{
    /**
     *  一覧
     *
     * @param ShiftMasterListRequest $req
     * @return Response
     */
    public function list(ShiftMasterListRequest $req): Response
    {
        JsonResponse::getInstance()->setResponse(JsonResponse::getTemplate());

        $container = new Container();
        $container[ShiftMasterContainer::KEY_REQUEST] = $req;
        $container[ShiftMasterContainer::KEY_PARAMS] = new Params($req);

        $c = ShiftMasterContainer::getInstance($container)->getContainer();
        $c[ShiftMasterContainer::KEY_SHIFT_MASTER]->list();

        return JsonResponse::getInstance()->response();
    }

    /**
     * 詳細
     *
     * @param ShiftMasterShowRequest $req
     * @param int $id
     * @return Response
     */
    public function show(ShiftMasterShowRequest $req, int $id): Response
    {
        JsonResponse::getInstance()->setResponse(JsonResponse::getTemplate());

        $container = new Container();
        $container[ShiftMasterContainer::KEY_REQUEST] = $req;
        $container[ShiftMasterContainer::KEY_PARAMS] = new Params($req, $id);

        $c = ShiftMasterContainer::getInstance($container)->getContainer();
        $c[ShiftMasterContainer::KEY_SHIFT_MASTER]->show();

        return JsonResponse::getInstance()->response();
    }

    /**
     * 登録
     *
     * @param ShiftMasterStoreRequest $req
     * @return Response
     */
    public function store(ShiftMasterStoreRequest $req): Response
    {
        JsonResponse::getInstance()->setResponse(JsonResponse::getTemplate());

        $container = new Container();
        $container[ShiftMasterContainer::KEY_REQUEST] = $req;
        $container[ShiftMasterContainer::KEY_PARAMS] = new Params($req);

        $c = ShiftMasterContainer::getInstance($container)->getContainer();
        $c[ShiftMasterContainer::KEY_SHIFT_MASTER]->store();

        return JsonResponse::getInstance()->response();
    }

    /**
     * 更新
     *
     * @param ShiftMasterStoreRequest $req
     * @param int $id
     * @return Response
     */
    public function update(ShiftMasterStoreRequest $req, int $id): Response
    {
        JsonResponse::getInstance()->setResponse(JsonResponse::getTemplate());

        $container = new Container();
        $container[ShiftMasterContainer::KEY_REQUEST] = $req;
        $container[ShiftMasterContainer::KEY_PARAMS] = new Params($req, $id);

        $c = ShiftMasterContainer::getInstance($container)->getContainer();
        $c[ShiftMasterContainer::KEY_SHIFT_MASTER]->update();

        return JsonResponse::getInstance()->response();
    }

    /**
     * 削除
     *
     * @param ShiftMasterDeleteRequest $req
     * @param int $id
     * @return Response
     */
    public function delete(ShiftMasterDeleteRequest $req): Response
    {
        JsonResponse::getInstance()->setResponse(JsonResponse::getTemplate());

        $container = new Container();
        $container[ShiftMasterContainer::KEY_REQUEST] = $req;
        $container[ShiftMasterContainer::KEY_PARAMS] = new Params($req);

        $c = ShiftMasterContainer::getInstance($container)->getContainer();
        $c[ShiftMasterContainer::KEY_SHIFT_MASTER]->delete();

        return JsonResponse::getInstance()->response();
    }
}

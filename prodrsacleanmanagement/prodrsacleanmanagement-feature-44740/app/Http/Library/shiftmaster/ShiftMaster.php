<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/09
 */

namespace App\Http\Library\shiftmaster;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Modules\db\ModelAbstract;
use Modules\db\SearchBuilderAbstract;
use Modules\params\ParamsAbstract;
use Modules\responses\JsonResponse;
use Modules\responses\ResponseConfig;
use Modules\date\Date;

/**
 * Class ShiftMaster
 *
 * @package App\Http\Library
 * @author y_kishimoto
 */
class ShiftMaster
{
    /**
     * @var Params
     */
    private $_params;

    /**
     * @var Request
     */
    private $_request;

    /**
     * @var null
     */
    private $_id;

    /**
     * @var MasterRsShiftModel
     */
    private $_masterRsShiftModel;

    /**
     * @var ShiftMasterSearchBuilder
     */
    private $_searchBuilder;

    /**
     * ShiftMaster constructor.
     * @param ParamsAbstract $params
     * @param ModelAbstract $masterRsShiftModel
     * @param SearchBuilderAbstract $searchBuilder
     */
    public function __construct(
        ParamsAbstract $params,
        ModelAbstract $masterRsShiftModel,
        SearchBuilderAbstract $searchBuilder
    ) {
        $this->setParams($params);
        $this->_masterRsShiftModel = $masterRsShiftModel;
        $this->_searchBuilder = $searchBuilder;
    }

    /**
     * Params セット
     *
     * @param ParamsAbstract $params
     */
    public function setParams(ParamsAbstract $params)
    {
        $this->_request = $params->getRequest();
        $this->_id = $params->getId();
    }

    /**
     * 一覧取得処理
     *
     * @return void
     */
    public function list(): void
    {
        try {
            $this->_searchBuilder
                ->setKeyword($this->_request->input('q'))
                ->setLimit($this->_request->input('limit'))
                ->setOffset($this->_request->input('offset'))
                ->setSort($this->_request->input('sort'))
                ->setInDeleted(intval($this->_request->input('in_deleted')));

            $result = $this->_masterRsShiftModel->getList($this->_searchBuilder) ?? [];
        } catch (\Exception $e) {
            throw new HttpResponseException(
                JsonResponse::getInstance()
                    ->setStatus(JsonResponse::STATUS_NG)
                    ->setMessage(ResponseConfig::MESSAGES['UNEXPECTED'])
                    ->setCode(ResponseConfig::CODES['UNEXPECTED'])
                    ->setData([])
                    ->setErrors(['exception' => $e->getMessage()])
                    ->response()
            );
        }

        // レスポンスセット
        JsonResponse::getInstance()
            ->setStatus(JsonResponse::STATUS_OK)
            // ->setMessage('success. '.'(['.$_SERVER['REQUEST_METHOD'].'] '.$_SERVER['REQUEST_URI'].')')
            ->setMessage(ResponseConfig::MESSAGES['SUCCESS'])
            ->setCode(ResponseConfig::CODES['SUCCESS'])
            ->setData($result);
    }

    /**
     * 詳細取得処理
     *
     * @return void
     */
    public function show(): void
    {
        try {
            $result = $this->_masterRsShiftModel->getDetail($this->_id) ?? [];

            $date = new Date();
            $workTime = $date->getTimeDiff($result->shiftstarttime, $result->shiftendtime);
            $breakTime = $date->getTimeDiff($result->breakstarttime, $result->breakendtime);
            $result->worktime = sprintf('%.1f', $workTime - $breakTime);
        } catch (\Exception $e) {
            throw new HttpResponseException(
                JsonResponse::getInstance()
                    ->setStatus(JsonResponse::STATUS_NG)
                    ->setMessage(ResponseConfig::MESSAGES['UNEXPECTED'])
                    ->setCode(ResponseConfig::CODES['UNEXPECTED'])
                    ->setData([])
                    ->setErrors(['exception' => $e->getMessage()])
                    ->response()
            );
        }

        // レスポンスセット
        JsonResponse::getInstance()
            ->setStatus(JsonResponse::STATUS_OK)
            ->setMessage(ResponseConfig::MESSAGES['SUCCESS'])
            ->setCode(ResponseConfig::CODES['SUCCESS'])
            ->setData($result);
    }

    /**
     * 登録処理
     *
     * @return void
     */
    public function store(): void
    {
        try {
            $this->_masterRsShiftModel->begin();
            $insertData = [];
            $this->_makeShiftMasterData($insertData);

            $insertId = $this->_masterRsShiftModel->insert($insertData);

            $result = [
                'shift_master_insert_id' => $insertId,
            ];

            $this->_masterRsShiftModel->commit();
        } catch (\Exception $e) {
            $this->_masterRsShiftModel->rollback();

            throw new HttpResponseException(
                JsonResponse::getInstance()
                    ->setStatus(JsonResponse::STATUS_NG)
                    ->setMessage(ResponseConfig::MESSAGES['UNEXPECTED'])
                    ->setCode(ResponseConfig::CODES['UNEXPECTED'])
                    ->setData([])
                    ->setErrors(['exception' => $e->getMessage()])
                    ->response()
            );
        }

        // レスポンスセット
        JsonResponse::getInstance()
            ->setStatus(JsonResponse::STATUS_OK)
            // ->setMessage('success. '.'(['.$_SERVER['REQUEST_METHOD'].'] '.$_SERVER['REQUEST_URI'].')')
            ->setMessage(ResponseConfig::MESSAGES['SUCCESS'])
            ->setCode(ResponseConfig::CODES['SUCCESS'])
            ->setData($result);
    }

    /**
     * 更新処理
     *
     * @return void
     */
    public function update(): void
    {
        try {
            $this->_masterRsShiftModel->begin();
            $updateData = [];
            $this->_makeShiftMasterData($updateData, false);

            $this->_masterRsShiftModel->update('id', $this->_id, $updateData, []);

            $result = [
                'shift_master_update_id' => $this->_id,
            ];

            $this->_masterRsShiftModel->commit();
        } catch (\Exception $e) {
            $this->_masterRsShiftModel->rollback();

            throw new HttpResponseException(
                JsonResponse::getInstance()
                    ->setStatus(JsonResponse::STATUS_NG)
                    ->setMessage(ResponseConfig::MESSAGES['UNEXPECTED'])
                    ->setCode(ResponseConfig::CODES['UNEXPECTED'])
                    ->setData([])
                    ->setErrors(['exception' => $e->getMessage()])
                    ->response()
            );
        }

        // レスポンスセット
        JsonResponse::getInstance()
            ->setStatus(JsonResponse::STATUS_OK)
            // ->setMessage('success. '.'(['.$_SERVER['REQUEST_METHOD'].'] '.$_SERVER['REQUEST_URI'].')')
            ->setMessage(ResponseConfig::MESSAGES['SUCCESS'])
            ->setCode(ResponseConfig::CODES['SUCCESS'])
            ->setData($result);
    }

    /**
     * 削除処理
     *
     * @return void
     */
    public function delete(): void
    {
        try {
            $this->_masterRsShiftModel->begin();

            $deleteIds = $this->_request->input('delete_ids');
            $deleteType = $this->_request->input('delete_type');

            switch ($deleteType) {
                case 1:
                    $this->_masterRsShiftModel->delete('id', $deleteIds, []);
                    break;
                case 2:
                    $this->_masterRsShiftModel->destroy('id', $deleteIds, []);
                    break;
            }

            $result = [
                'delete_ids' => $deleteIds,
            ];

            $this->_masterRsShiftModel->commit();
        } catch (\Exception $e) {
            $this->_masterRsShiftModel->rollback();

            throw new HttpResponseException(
                JsonResponse::getInstance()
                    ->setStatus(JsonResponse::STATUS_NG)
                    ->setMessage(ResponseConfig::MESSAGES['UNEXPECTED'])
                    ->setCode(ResponseConfig::CODES['UNEXPECTED'])
                    ->setData([])
                    ->setErrors(['exception' => $e->getMessage()])
                    ->response()
            );
        }

        // レスポンスセット
        JsonResponse::getInstance()
            ->setStatus(JsonResponse::STATUS_OK)
            // ->setMessage('success. '.'(['.$_SERVER['REQUEST_METHOD'].'] '.$_SERVER['REQUEST_URI'].')')
            ->setMessage(ResponseConfig::MESSAGES['SUCCESS'])
            ->setCode(ResponseConfig::CODES['SUCCESS'])
            ->setData($result);
    }

    /**
     * 登録/更新データ 作成
     *
     * @return void
     */
    private function _makeShiftMasterData(&$data, $isInsert = true): void
    {
        $data = [
            "systemusercompanyid" => 'C01', // TODO: アクセスTokenから取得する
            "facilityid" => '001', // TODO: アクセスTokenから取得する
            "cleaningshiftcode" => $this->_request->input("cleaningshiftcode"),
            "shiftstarttime" => $this->_request->input("shiftstarttime"),
            "shiftendtime" => $this->_request->input("shiftendtime"),
            "breakstarttime" => $this->_request->input("breakstarttime"),
            "breakendtime" => $this->_request->input("breakendtime"),
            "name" => $this->_request->input("name"),
            "shortname" => $this->_request->input("shortname"),
            "description" => $this->_request->input("description"),
            "sequence" => $this->_request->input("sequence") ?? 1,
            "deleted_at" => $this->_request->input("deleted_at"),
            "createuseraccountid" => '1' , // TODO: アクセスTokenから取得する
            "changeuseraccountid" => '1', // TODO: アクセスTokenから取得する
        ];
    }
}

<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/03/02
 */

namespace App\Http\Library\cleanstatusmaster;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Modules\db\ModelAbstract;
use Modules\db\SearchBuilderAbstract;
use Modules\params\ParamsAbstract;
use Modules\responses\JsonResponse;
use Modules\responses\ResponseConfig;

/**
 * Class CleanStatusMaster
 *
 * @package App\Http\Library
 * @author y_kishimoto
 */
class CleanStatusMaster
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
     * @var MasterRsCleanStatusModel
     */
    private $_masterRsCleanStatusModel;

    /**
     * @var CleanStatusMasterSearchBuilder
     */
    private $_searchBuilder;

    /**
     * CleanStatusMaster constructor.
     * @param ParamsAbstract $params
     * @param ModelAbstract $masterRsCleanStatusModel
     * @param SearchBuilderAbstract $searchBuilder
     */
    public function __construct(
        ParamsAbstract $params,
        ModelAbstract $masterRsCleanStatusModel,
        SearchBuilderAbstract $searchBuilder
    ) {
        $this->setParams($params);
        $this->_masterRsCleanStatusModel = $masterRsCleanStatusModel;
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

            $result = $this->_masterRsCleanStatusModel->getList($this->_searchBuilder) ?? [];
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
     * 詳細取得処理
     *
     * @return void
     */
    public function show(): void
    {
        try {
            $result = $this->_masterRsCleanStatusModel->getDetail($this->_id) ?? [];
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
    }

    /**
     * 更新処理
     *
     * @return void
     */
    public function update(): void
    {
        try {
            $this->_masterRsCleanStatusModel->begin();
            $updateData = [];
            $this->_makeCleanStatusMasterData($updateData, false);

            $this->_masterRsCleanStatusModel->update('id', $this->_id, $updateData, []);

            $result = [
                'clean_state_master_update_id' => $this->_id,
            ];

            $this->_masterRsCleanStatusModel->commit();
        } catch (\Exception $e) {
            $this->_masterRsCleanStatusModel->rollback();

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
     * 削除処理
     *
     * @return void
     */
    public function delete(): void
    {
        try {
            $this->_masterRsCleanStatusModel->begin();

            $deleteIds = $this->_request->input('delete_ids');
            $deleteType = $this->_request->input('delete_type');

            switch ($deleteType) {
                case 1:
                    $this->_masterRsCleanStatusModel->delete('id', $deleteIds, []);
                    break;
                case 2:
                    $this->_masterRsCleanStatusModel->destroy('id', $deleteIds, []);
                    break;
            }

            $result = [
                'delete_ids' => $deleteIds,
            ];

            $this->_masterRsCleanStatusModel->commit();
        } catch (\Exception $e) {
            $this->_masterRsCleanStatusModel->rollback();

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
     * 登録/更新データ 作成
     *
     * @return void
     */
    private function _makeCleanStatusMasterData(&$data, $isInsert = true): void
    {
        $data = [
            "systemusercompanyid" => 'C01', // TODO: アクセスTokenから取得する
            "facilityid" => '001', // TODO: アクセスTokenから取得する
            "cleaningstatusname" => $this->_request->input("cleaningstatusname"),
            "description" => $this->_request->input("description"),
            "sequence" => $this->_request->input("sequence") ?? 1,
            "deleted_at" => $this->_request->input("deleted_at"),
            "createuseraccountid" => '1' , // TODO: アクセスTokenから取得する
            "changeuseraccountid" => '1', // TODO: アクセスTokenから取得する
        ];
    }
}

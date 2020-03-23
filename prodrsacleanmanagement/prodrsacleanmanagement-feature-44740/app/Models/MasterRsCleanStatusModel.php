<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/03/02
 */
namespace App\Models;

use Modules\db\ModelAbstract;
use Modules\db\SearchBuilderAbstract;

/**
 * Class MasterRsCleanStatusModel
 *
 * @package App\Models
 * @author y_kishimoto
 */
class MasterRsCleanStatusModel extends ModelAbstract
{
    /**
     * DB
     *
     * @var string
     */
    protected $connection = 'rsa';

    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'm_rscleaningstatus';

    /**
    *自動更新
    *
    * @var bool
    */
    protected $autoUpdateFlg = true;


    /**
     * 一覧取得
     *
     * @param SearchBuilderAbstract $search
     * @return mixed
     */
    public function getList(SearchBuilderAbstract $search)
    {
        $model = $this->searchQuery();

        $search->setQuery($model)
            ->build()
            ->getQuery()
            ->select([
                $this->table . '.id AS cleanstatusmasterid',
                $this->table . '.systemusercompanyid',
                $this->table . '.facilityid',
                $this->table . '.cleaningstatuscode',
                $this->table . '.cleaningstatusname',
                $this->table . '.sequence',
                $this->table . '.createtimestamp',
                $this->table . '.changetimestamp',
                $this->table . '.deleted_at',
            ]);

        $data = $model->get();

        return $data;
    }

    /**
     * $idに応じた清掃ステータスマスタ詳細を取得
     *
     * @param $id
     * @return mixed
     */
    public function getDetail($id)
    {
        $model = $this->searchQuery();

        $model
            ->select([
                $this->table . '.id AS cleanstatusmasterid',
                $this->table . '.systemusercompanyid',
                $this->table . '.facilityid',
                $this->table . '.cleaningstatuscode',
                $this->table . '.cleaningstatusname',
                $this->table . '.description',
                $this->table . '.sequence',
                $this->table . '.createtimestamp',
                $this->table . '.changetimestamp',
                $this->table . '.deleted_at',
            ])->where($this->table.'.id', $id);

        $data = $model->first();

        return $data;
    }
}

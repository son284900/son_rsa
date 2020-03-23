<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/09
 */
namespace App\Models;

use Modules\db\ModelAbstract;
use Modules\db\SearchBuilderAbstract;

/**
 * Class MasterRsShiftModel
 *
 * @package App\Models
 * @author y_kishimoto
 */
class MasterRsShiftModel extends ModelAbstract
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
    protected $table = 'm_rscleaningshift';

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
                $this->table . '.id AS shiftmasterid',
                $this->table . '.systemusercompanyid',
                $this->table . '.facilityid',
                $this->table . '.cleaningshiftcode',
                $this->table . '.shiftstarttime',
                $this->table . '.shiftendtime',
                $this->table . '.breakstarttime',
                $this->table . '.breakendtime',
                $this->table . '.name',
                $this->table . '.sequence',
                $this->table . '.createtimestamp',
                $this->table . '.changetimestamp',
                $this->table . '.deleted_at',
            ]);

        $data = $model->get();

        return $data;
    }

    /**
     * $idに応じたシフトマスタ詳細を取得
     *
     * @param $id
     * @return mixed
     */
    public function getDetail($id)
    {
        $model = $this->searchQuery();

        $model
            ->select([
                $this->table . '.id AS shiftmasterid',
                $this->table . '.systemusercompanyid',
                $this->table . '.facilityid',
                $this->table . '.cleaningshiftcode',
                $this->table . '.shiftstarttime',
                $this->table . '.shiftendtime',
                $this->table . '.breakstarttime',
                $this->table . '.breakendtime',
                $this->table . '.name',
                $this->table . '.shortname',
                $this->table . '.description',
                $this->table . '.sequence',
                $this->table . '.createuseraccountid',
                $this->table . '.createtimestamp',
                $this->table . '.changeuseraccountid',
                $this->table . '.changetimestamp',
                $this->table . '.deleted_at',
            ])->where($this->table.'.id', $id);

        $data = $model->first();

        return $data;
    }
}

<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/09
 */
namespace Modules\db;

/**
 * Class ModelAbstract
 *
 * @package Modules\Db
 * @author y_kishimoto
 */
abstract class ModelAbstract extends Db
{
    /**
     * DB
     *
     * @var string
     */
    protected $connection;

    /**
     * テーブル名
     *
     * @var string
     */
    protected $table;

    /**
     *  テーブル名 取得
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     *  テーブル名 セット
     *
     * @param string
     */
    public function setTable(string $table)
    {
        $this->table = $table;
    }

    /**
     *  テーブル 取得
     *
     * @return ModelAbstract
     */
    public function table()
    {
        $this->query = $this->query->table($this->table);

        return $this;
    }

    /**
     * トランザクション開始
     *
     * @return void
     */
    public function begin()
    {
        $this->connector()->getQuery()->beginTransaction();
    }

    /**
     * コミット
     *
     * @return void
     */
    public function commit()
    {
        $this->connector()->getQuery()->commit();
    }

    /**
     * ロールバック
     *
     * @return void
     */
    public function rollback()
    {
        $this->connector()->getQuery()->rollBack();
    }

    /**
     * 検索クエリ
     *
     * @return mixed
     */
    public function searchQuery()
    {
        return $this->connector()
            ->table()
            ->getQuery();
    }

    /**
     * 登録処理
     *
     * @param array $data
     * @return mixed
     */
    public function insert(array $data): int
    {
        if ($this->autoUpdateFlg) {
            $data['createtimestamp'] = date("Y-m-d H:i:s");
            $data['changetimestamp'] = date("Y-m-d H:i:s");
        }

        $insertId = $this->connector()
            ->table()
            ->getQuery()
            ->insertGetId($data);

        return $insertId;
    }

    /**
     * 更新処理
     *
     * @param $key
     * @param mixed $id int or array
     * @param array $data
     * @param array $wheres
     * @return mixed
     */
    public function update($key, $id, array $data, $wheres = [])
    {
        $data['changetimestamp'] = date("Y-m-d H:i:s");

        $model = $this->connector()
           ->table()
           ->getQuery();

        if (is_array($id)) {
            $model = $model->whereIn($key, $id);
        } else {
            $model = $model->where($key, '=', $id);
        }

        foreach ($wheres as $columnName => $value) {
            $model = $model->where($columnName, '=', $value);
        }

        $update = $model->update($data);

        return $update;
    }

    /**
     * 論理削除処理
     *
     * @param $key
     * @param $id
     * @param array $wheres
     * @return mixed
     */
    public function delete($key, $id, $wheres = [])
    {
        $model = $this->connector()
            ->table()
            ->getQuery();

        if (is_array($id)) {
            $model = $model->whereIn($key, $id);
        } else {
            $model = $model->where($key, '=', $id);
        }

        foreach ($wheres as $columnName => $value) {
            $model = $model->where($columnName, '=', $value);
        }

        $delete = $model->update(['deleted_at' => date("Y-m-d H:i:s"), 'changetimestamp' => date("Y-m-d H:i:s")]);

        return $delete;
    }

    /**
     * 物理削除
     *
     * @param $key
     * @param $id
     * @param array $wheres
     * @return mixed
     */
    public function destroy($key, $id, $wheres = [])
    {
        $model = $this->connector()
            ->table()
            ->getQuery();

        if (is_array($id)) {
            $model = $model->whereIn($key, $id);
        } else {
            $model = $model->where($key, '=', $id);
        }

        foreach ($wheres as $columnName => $value) {
            $model = $model->where($columnName, '=', $value);
        }

        $delete = $model->delete();

        return $delete;
    }
}

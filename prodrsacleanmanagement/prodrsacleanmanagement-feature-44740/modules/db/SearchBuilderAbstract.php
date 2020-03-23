<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/09
 */

namespace Modules\db;

/**
 * Class SearchBuilderAbstract
 * @package Modules\Db
 * @author y_kishimoto
 */
abstract class SearchBuilderAbstract
{
    /**
     * @var
     */
    protected $query;

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var string
     */
    protected $sort;

    /**
     * @var int
     */
    protected $inDeleted;

    /**
     * 検索条件構築
     *
     * @return SearchBuilderAbstract
     */
    abstract public function build(): SearchBuilderAbstract;

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     * @return SearchBuilderAbstract
     */
    public function setQuery(&$query): SearchBuilderAbstract
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return SearchBuilderAbstract
     */
    public function setLimit(int $limit): SearchBuilderAbstract
    {
        // 0の場合は、全件取得の条件になる
        if ($limit > 0) {
            $this->limit = $limit;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return SearchBuilderAbstract
     */
    public function setOffset(int $offset): SearchBuilderAbstract
    {
        $this->offset = $offset ?? 0;

        return $this;
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param string $orderBy
     * @return SearchBuilderAbstract
     */
    public function setSort(string $sort): SearchBuilderAbstract
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param mixed $isDeleted
     * @return SearchBuilderAbstract
     */
    public function setInDeleted(int $inDeleted): SearchBuilderAbstract
    {
        $this->inDeleted = $inDeleted;

        return $this;
    }

    /**
     * 並び順の共通処理
     * 　指定が無い場合はIDの昇順
     *
     * @return SearchBuilderAbstract
     */
    public function sort(): SearchBuilderAbstract
    {
        $data = json_decode($this->sort, true);

        if (!empty($data)) {
            foreach ($data as $orderKey => $value) {
                $this->query = $this->query->orderBy($orderKey, $value);
            }
        } else {
            $this->query = $this->query->orderBy('id', 'asc');
        }

        return $this;
    }

    /**
     * ページネーションの共通処理
     *
     * @return SearchBuilderAbstract
     */
    public function pagination(): SearchBuilderAbstract
    {
        if ($this->limit !== null) {
            $this->query = $this->query->limit($this->limit);
        }

        if ($this->offset !== null) {
            $this->query = $this->query->offset($this->offset);
        }

        return $this;
    }

    /**
     * 削除データ取り扱いの共通処理
     *
     * @return SearchBuilderAbstract
     */
    public function inDeleted(): SearchBuilderAbstract
    {
        if (!($this->inDeleted > 0)) {
            $this->query = $this->query->whereNull('deleted_at');
        }

        return $this;
    }

    public function eq(string $key, $value)
    {
    }
}

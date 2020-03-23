<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/03/02
 */
namespace App\Http\Library\cleanstatusmaster;

use Modules\db\SearchBuilderAbstract;

/**
 * Class CleanStatusMasterSearchBuilder
 *
 * @package App\Http\Library
 * @author y_kishimoto
 */
class CleanStatusMasterSearchBuilder extends SearchBuilderAbstract
{
    private $_table = 'm_rscleaningstatus';
    private $_keyword;

    public function setKeyword($keyword): CleanStatusMasterSearchBuilder
    {
        $this->_keyword = $keyword;
        return $this;
    }

    /**
     * 検索条件構築
     *
     * @return SearchBuilderAbstract
     */
    public function build(): SearchBuilderAbstract
    {
        $this->sort();
        $this->pagination();
        $this->inDeleted();

        if ($this->_keyword !== null) {
            $this->query->where(function ($query) {
                $query->where($this->_table . '.cleaningstatusname', 'like', '%'.$this->_keyword.'%');
            });
        }

        return $this;
    }
}

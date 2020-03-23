<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/09
 */
namespace App\Http\Library\shiftmaster;

use Modules\db\SearchBuilderAbstract;

/**
 * Class ShiftMasterSearchBuilder
 *
 * @package App\Http\Library
 * @author y_kishimoto
 */
class ShiftMasterSearchBuilder extends SearchBuilderAbstract
{
    private $_table = 'm_rscleaningshift';
    private $_keyword;

    public function setKeyword($keyword): ShiftMasterSearchBuilder
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
                $query->where($this->_table . '.name', 'like', '%'.$this->_keyword.'%')
                    ->orWhere($this->_table . '.shortname', 'like', '%'.$this->_keyword.'%');
            });
        }

        return $this;
    }
}

<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/23
 */
namespace Modules\date;

use Carbon\Carbon;

/**
 * Class Date
 * @package Modules\date
 * @author y_kishimoto
 */
class Date
{

    private $_date;

    /**
     * Params constructor.
     * @param string $dateString
     */
    public function __construct(string $dateString = null)
    {
        $this->_date = new Carbon($dateString);
    }

    /**
     * Datetimeを取得する
     * @return string
     */
    public function getDatetime() : string
    {
        return $this->_date->now()->format('Y-m-d H:i:s');
    }

    /**
     * Dateを取得する
     * @return string
     */
    public function getDate() : string
    {
        return $this->_date->now()->format('Y-m-d');
    }

    /**
     * 時間から日時作成
     *
     * @param string $time (0000) hhmm
     * @return object 日時
     */
    public function createDateTime(string $time = null)
    {
        $times = $this->_timeSplit($time);
        $date = new Carbon();
        $date->setTime($times[0], $times[1], 00);

        return $date;
    }

    /**
     * 時間の差分を返す
     *
     * @param string $startTime (0000) hhmm
     * @param string $endTime (0000) hhmm
     * @return float (時間単位))
     */
    public function getTimeDiff(string $startTime = null, string $endTime = null) : float
    {
        $result = $this->createDateTime($startTime)
                        ->diffInMinutes($this->createDateTime($endTime));

        return $result/60;
    }

    /**
     * 時間を分解して返す
     *
     * @param string $time (0000) hhmm
     * @return array
     */
    private function _timeSplit(string $time = null) : array
    {
        $result = ['00','00'];
        $split = str_split($time, 2);

        if (count($split) === 2) {
            $result = $split;
        }

        return $result;
    }
}

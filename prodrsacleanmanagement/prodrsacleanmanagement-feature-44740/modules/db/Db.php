<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/09
 */
namespace Modules\db;

/**
 * Class Db
 *
 * @package Modules\db
 * @author y_kishimoto
 */
class Db extends DbAbstract
{

    protected $db;

    protected $connection;

    protected $query;

    /**
     * Db constructor.
     */
    public function __construct()
    {
        $this->db = app()->make('db');
    }

    /**
     * 接続
     *
     * @return mixed
     */
    public function connector()
    {
        if ($this->connection !== null) {
            $this->query = $this->db->connection($this->connection);
        }
        return $this;
    }

    /**
     * @param string $connection
     * @return Db
     */
    public function setConnection(string $connection): Db
    {
        $this->db = $this->db->connection($connection);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }
}

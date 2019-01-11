<?php

class Time
{
    var $idtime, $time;

    /**
     * Time constructor.
     * @param $idtime
     * @param $time
     */
    public function __construct($idtime, $time)
    {
        $this->idtime = $idtime;
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getIdtime()
    {
        return $this->idtime;
    }

    /**
     * @param mixed $idtime
     */
    public function setIdtime($idtime)
    {
        $this->idtime = $idtime;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /* Load time */
    public function loadTime($id){
        $ret = array();
        $sql = "select * from time t where t.idtime = '".$id."'";
        $data = new DataProvider();
        $list = $data::execQuery($sql);

        while ($row = mysqli_fetch_assoc($list)) {
            $id = $row["idtime"];
            $time = $row["time"];

            $t = new Time($id, $time);
            array_push($ret, $t);
        }

        return $ret;
    }


}
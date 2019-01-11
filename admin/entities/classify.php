<?php
require_once 'helper/DataProvider.php';
class Classify {
var $CId, $CName;
        
public function __construct($CId, $CName) {
    $this->CId = $CId;
    $this->CName = $CName;
}

public function getCId() {
    return $this->CId;
}

public function getCName() {
    return $this->CName;
}

public function setCId($CId) {
    $this->CId = $CId;
}

public function setCName($CName) {
    $this->CName = $CName;
}

public static function LoadClassify()
{
    $sql = "select * from classify";
    $arr = array();
    $list = DataProvider::execQuery($sql);
    
    while($row = mysql_fetch_array($list))
    {
        $Id = $row["CId"];
        $Name = $row["CName"];
        $c = new Classify($Id,$Name);
        
        array_push($arr, $c);
    }
	        return $arr;
}
        
    
} 
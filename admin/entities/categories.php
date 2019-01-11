<?php
require DOCUMENT_ROOT . '/helper/DataProvider.php';

class categories {

    var $catId, $catName;

    function __construct($catId, $catName) {
        $this->catId = $catId;
        $this->catName = $catName;
    }

    public function getCatId() {
        return $this->catId;
    }

    public function getCatName() {
        return $this->catName;
    }

    public function setCatId($catId) {
        $this->catId = $catId;
    }

    public function setCatName($catName) {
        $this->catName = $catName;
    }

    // Lấy danh sách danh mục đang có trong CSDL
    public static function loadAll() {
        $ret = array();
    
        $sql = "select * from categories";
        $list = DataProvider::execQuery($sql);

        while ($row = mysql_fetch_array($list)) {
            $id = $row["CatId"];
            $name = $row["CatName"];
            $c = new categories($id, $name);
            
            array_push($ret, $c);
        }

        return $ret;
    }
   
    public static function getCategoryById($id){
        $ret = array();
        $sql = "select * from categories where CatId = $id ";
        $list = DataProvider::execQuery($sql);
        while( $row = mysql_fetch_array($list) ){
            $id = $row["CatId"];
            $name = $row["CatName"];
            $c = new categories($id, $name);
            
            array_push($ret, $c);
        }
        return $ret[0];
    }
		
}
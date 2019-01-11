<?php 
require_once '/helper/DataProvider.php';

class Blog {

    var $blogId, $blogName, $blogDetail, $author, $created_at;

    function __construct($blogId, $blogName, $blogDetail, $author, $created_at) {
        $this->blogId = $catId;
        $this->blogName = $blogName;
        $this->blogDetail = $blogDetail;
        $this->author = $author;
        $this->created_at = $created_at;
    }
    // Lấy danh sách tin tuc đang có trong CSDL
    public static function loadAll() {
        $ret = array();
    
        $sql = "select * from blog";
        $list = DataProvider::execQuery($sql);

        while ($row = mysql_fetch_array($list)) {
            $id = $row["id"];
            $name = $row["title"];
            $content = $row["content"];
            $author = $row["author"];
            $created_at = $row["created_at"];
            $c = new categories($id, $name, $content, $author, $created_at);
            
            array_push($ret, $c);
        }

        return $ret;
    }
        
    public static function loadBlogLimit($offset,$productPerPage) {
        $ret = array();
       
		$sql = "select * from blog limit $offset,$productPerPage";
		
        $list = DataProvider::execQuery($sql);

        while ($row = mysql_fetch_array($list)) {
            $blogId = $row["id"];
            $blogName = $row["title"];
            $blogDetail = $row["content"];
            $author = $row["author"];
            $created_at = $row["created_at"];
			
            $p = new Blog($blogId, $blogName, $blogDetail, $author, $created_at);
            array_push($ret, $p);
        }

        return $ret;
    }
}
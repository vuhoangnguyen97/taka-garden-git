
<?php
require_once 'Products.php';
class Search{
	
	public static function SearchName($noidung,$nsx,$gia)
	{
		if($nsx ==0 )
			$nsx = '%';
		if($loai ==0)
			$loai = '%';
		$ret = array();
		$sql = "select * from products 
				where catid like '$nsx' and price < $gia and ProName like '%$noidung%'
                ORDER BY price DESC";
                
        $list = DataProvider::execQuery($sql);

        while ($row = mysql_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $catId = $row["CatID"];
			$view = $row["NView"];
            $dayAdd = $row["DayAdd"];
			$classify =$row["Classify"];
			
            $p = new Products($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd,$classify);
            array_push($ret, $p);
        }

        return $ret;
    }
	public static function SearchNameLimit($noidung,$nsx,$gia,$offset,$productPerPage)
	{
		if($nsx ==0 )
			$nsx = '%';
		if($loai ==0)
			$loai = '%';
		$ret = array();
		$sql = "select * from products 
				where catid like '$nsx' and price < $gia and proname like '%$noidung%'
				ORDER BY price DESC limit $offset,$productPerPage";
        $list = DataProvider::execQuery($sql);

        while ($row = mysql_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $catId = $row["CatID"];
			$view = $row["NView"];
            $dayAdd = $row["DayAdd"];
			$classify =$row["Classify"];
			
            $p = new Products($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd,$classify);
            array_push($ret, $p);
        }

        return $ret;
    }
}
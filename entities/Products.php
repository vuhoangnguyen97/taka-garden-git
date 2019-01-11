<?php
// require_once('../helper/DataProvider.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//require_once $_SERVER['DOCUMENT_ROOT'] . '/taka_garden/helper/DataProvider.php';
//require $_SERVER['DOCUMENT_ROOT']  . '/taka_garden/helper/DataProvider.php';
Class Products
{
    var $proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd, $classify, $onsale, $salesprice;

    function __construct($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd, $classify, $onsale = 0, $salesprice = 0)
    {
        $this->proId = $proId;
        $this->proName = $proName;
        $this->tinyDes = $tinyDes;
        $this->fullDes = $fullDes;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->catId = $catId;
        $this->view = $view;
        $this->dayAdd = $dayAdd;
        $this->classify = $classify;
        $this->onsale = $onsale;
        $this->salesprice = $salesprice;
    }

    public function getProId()
    {
        return $this->proId;
    }

    public function getProName()
    {
        return $this->proName;
    }

    public function getTinyDes()
    {
        return $this->tinyDes;
    }

    public function getFullDes()
    {
        return $this->fullDes;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getCatId()
    {
        return $this->catId;
    }

    public function getView()
    {
        return $this->view;
    }

    public function getDayAdd()
    {
        return $this->dayAdd;
    }

    public function getClassify()
    {
        return $this->classify;
    }

    public function setClassify($classify)
    {
        $this->Classify = $classify;
    }

    public function setView($proId)
    {
        $this->view = $proId;
    }

    public function setDayAdd($proId)
    {
        $this->dayAdd = $proId;
    }

    public function setProId($proId)
    {
        $this->proId = $proId;
    }

    public function setProName($proName)
    {
        $this->proName = $proName;
    }

    public function setTinyDes($tinyDes)
    {
        $this->tinyDes = $tinyDes;
    }

    public function setFullDes($fullDes)
    {
        $this->fullDes = $fullDes;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function setCatId($catId)
    {
        $this->catId = $catId;
    }

    public static function saveProducts($param)
    {
        $sql = "INSERT INTO products (ProName, CatID, Price,TinyDes,FullDes,Classify,Quantity,NView,DayAdd, onsale, salesprice)
    VALUES ('" . $param['ProName'] . "', '" . $param['CatID'] . "', '" . $param['Price'] . "', '" . $param['TinyDes'] . "', '" . $param['FullDes'] . "', '1', '" . $param['Quantity'] . "', '1', '" . date('Y-m-d') . "', '".$param['onsale']."', '".$param['salesprice']."')";

        $result = DataProvider::execNonQueryIdentity($sql);
        return $result;
    }

    /*------------Load ALL-------*/
    public static function loadProductsAll()
    {
        $ret = array();

        $sql = "select * from products";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $view = $row["NView"];
            $dayAdd = $row["DayAdd"];
            $catId = $row["CatID"];
            $classify = $row["Classify"];
            $onsale = $row["onsale"];
            $salesprice = $row["salesprice"];

            $p = new Products($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd, $classify, $onsale, $salesprice);
            array_push($ret, $p);
        }

        return $ret;
    }

    /*--- Load data for chart ---*/
    public static function loadProductsChart()
    {
        $ret = array();

        $sql = "select * from products";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            $tinyDes = "";
            $fullDes = "";
            $price = $row["Price"];
            $quantity = "";
            $view = "";
            $dayAdd = "";
            $catId = "";
            $classify = "";
            $onsale = "";
            $salesprice = "";

            $p = new Products($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd, $classify, $onsale, $salesprice);
            array_push($ret, $p);
        }

        return $ret;
    }


    /* -----------------------load product theo NHA SAN XUAT--------------*/
    public static function loadProductsByCatId($p_catId)
    {
        $ret = array();

        $sql = "select * from products where CatID = $p_catId";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $view = $row["NView"];
            $dayAdd = $row["DayAdd"];
            $salesprice = $row["salesprice"];
            $catId = $p_catId;
            $classify = $row["Classify"];
            $onsale = $row['onsale'];
            $p = new Products($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd, $classify, $onsale, $salesprice);
            array_push($ret, $p);
        }

        return $ret;
    }

    /* -----------------------load product theo Loai Mat hang--------------*/
    public static function loadProductsByCId($p_cId)
    {
        $ret = array();

        $sql = "select * from products where Classify = $p_cId and Quantity >0";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $view = $row["NView"];
            $dayAdd = $row["DayAdd"];
            $catId = $row["CatID"];
            //$catId = $p_catId;
            //$classify = $p_cId;

            $p = new Products($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd, $p_cId);
            array_push($ret, $p);
        }

        return $ret;
    }

    /* -----------------------load product theo id TUNG SAN PHAM va tang luot view--------------*/

    public static function loadProductByProId($p_proId)
    {

        $sql = "select * from products where ProID = $p_proId";
        $list = DataProvider::execQuery($sql);
        if ($row = mysqli_fetch_array($list)) {

            //$proId = $row["ProID"];
            //$proId = $p_proId;
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $catId = $row["CatID"];
            $view = $row["NView"];
            $dayAdd = $row["DayAdd"];
            $classify = $row["Classify"];
            $onsale = $row['onsale'];
            $salesprice = $row['salesprice'];

            $p = new Products($p_proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd, $classify, $onsale, $salesprice);
            return $p;
        }

        return NULL;
    }

    /*------------cap nhat so luot xem-------*/

    public static function AddView($p_proId)
    {
        $sql = "update products set nview= nview+1 where ProID = $p_proId";
        DataProvider::execQuery($sql);
    }

    /*------------cap nhat so luot xem-------*/

    public static function UpdateQuantity($p_proId, $sl)
    {
        $sql = "update products set Quantity= Quantity-$sl where ProID = $p_proId";
        DataProvider::execQuery($sql);
    }
//phan trang san pham
    /*------------Load product co gioi han-------*/
    public static function loadProductsLimit($p_catId, $price, $offset, $productPerPage)
    {
        $ret = array();
        if ($price == 0) {
            $price = 9999999999999999;
        }
        if ($p_catId == -1)
            $sql = "select * from products limit $offset,$productPerPage";
        else
            $sql = "select * from products where CatId = $p_catId and Price <= $price limit $offset,$productPerPage";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $catId = $row["CatID"];
            $view = $row["NView"];
            $dayAdd = $row["DayAdd"];
            $classify = $row["Classify"];

            $p = new Products($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd, $classify);
            array_push($ret, $p);
        }

        return $ret;
    }

    /*------------Load product co gioi han theo loai sp-------*/
    public static function loadProductsLimitClassify($p_cId, $offset, $productPerPage)
    {
        $ret = array();
        $sql = "select * from products where Classify = $p_cId limit $offset,$productPerPage";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $catId = $row["CatID"];
            $view = $row["NView"];
            $dayAdd = $row["DayAdd"];
            //$classify =$p_cId;

            $p = new Products($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd, $p_cId);
            array_push($ret, $p);
        }

        return $ret;
    }

    /*------------Load product New ADD-------*/
    public static function loadProductsNew()
    {
        $ret = array();
        $sql = "select * from products ORDER BY DayAdd DESC limit 0,10";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $catId = $row["CatID"];
            $view = $row["NView"];
            $dayAdd = $row["DayAdd"];
            $classify = $row["Classify"];

            $p = new Products($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd, $classify);
            array_push($ret, $p);
        }

        return $ret;
    }

    /*------------Load product nhieu luot view-------*/
    public static function loadProductsView()
    {
        $ret = array();
        $sql = "select * from products  ORDER BY NView DESC limit 0,10";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $catId = $row["CatID"];
            $view = $row["NView"];
            $dayAdd = $row["DayAdd"];
            $classify = $row["Classify"];

            $p = new Products($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd, $classify);
            array_push($ret, $p);
        }

        return $ret;
    }

    /*------------Load product ban chay-------*/
    public static function loadProductsTopSale()
    {
        $ret = array();
        $sql = "select p.ProID,p.ProName,p.Price, SUM(od.quantity) from products p,orderdetails od 
				where p.ProID = od.ProId
				GROUP BY p.ProID
				ORDER BY od.quantity DESC limit 0,10";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            //$tinyDes = $row["TinyDes"];
            //$fullDes = $row["FullDes"];
            $price = $row["Price"];
            //$quantity = $row["Quantity"];
            //$catId = $row["CatID"];
            //$view = $row["NView"];
            //$dayAdd = $row["DayAdd"];
            //$classify =$row["Classify"];

            $p = new Products($proId, $proName, '', '', $price, '', '', '', '', '');
            array_push($ret, $p);
        }

        return $ret;
    }

    /*------------Load product cung loai-------*/
    public static function loadProductsCungLoai($loaisp, $pid)
    {
        $ret = array();
        $sql = "select ProID,ProName from products  
				where ProID != $pid and classify = $loaisp
				ORDER BY NView DESC limit 0,5";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            //$tinyDes = $row["TinyDes"];
            //$fullDes = $row["FullDes"];
            //$price = $row["Price"];
            //$quantity = $row["Quantity"];
            //$catId = $row["CatID"];
            //$view = $row["NView"];
            //$dayAdd = $row["DayAdd"];
            //$classify =$row["Classify"];

            $p = new Products($proId, $proName, '', '', '', '', '', '', '', '');
            array_push($ret, $p);
        }

        return $ret;
    }

    /*------------Load product cung nha sx-------*/
    public static function loadProductsCungNSX($nsx, $pid)
    {
        $ret = array();
        $sql = "select ProID,ProName from products  
				where ProID != $pid and Catid = $nsx
				ORDER BY Price DESC limit 0,5";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            //$tinyDes = $row["TinyDes"];
            //$fullDes = $row["FullDes"];
            //$price = $row["Price"];
            //$quantity = $row["Quantity"];
            //$catId = $row["CatID"];
            //$view = $row["NView"];
            //$dayAdd = $row["DayAdd"];
            //$classify =$row["Classify"];

            $p = new Products($proId, $proName, '', '', '', '', '', '', '', '');
            array_push($ret, $p);
        }

        return $ret;
    }
    public static function loadProductsFlashSale()
    {
        $ret = array();

        $sql = "select * from products where onsale = 1";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $view = $row["NView"];
            $dayAdd = $row["DayAdd"];
            $salesprice = $row["salesprice"];
            $catId = $row['CatID'];
            $classify = $row["Classify"];
            $onsale = $row["onsale"];

            $p = new Products($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId, $view, $dayAdd, $classify,$onsale, $salesprice );
            array_push($ret, $p);
        }

        return $ret;
    }

    public static function updateProduct($params){
        // print_r($params);die();
        $id = $params['id'];
        $ProName = $params['ProName'];
        $Quantity = $params['Quantity'];
        $Price = $params['Price'];
        $onsale = $params['onsale'];
        $salesprice = $params['salesprice'];
        $TinyDes = $params['TinyDes'];
        $FullDes = $params['FullDes'];
        $catId = $params['catId'];  

        $sql = "update products set ProName= '$ProName', CatID = $catId, Price = $Price, onsale = $onsale, salesprice = $salesprice, FullDes = '$FullDes', Quantity = $Quantity where ProID = $id";
        DataProvider::execQuery($sql);
        return true;
    }

    public static function delete($id){
        $sql = "DELETE FROM products where ProID = $id";
        DataProvider::execQuery($sql);
        return true;
    }

    /* SELECT Giá*/
    public static function loadPrice()
    {
        $ret = array();

        $sql = "select p.Price from products p";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $price = $row["Price"];

            array_push($ret, $price);
        }

        return $ret;
    }
} // end class

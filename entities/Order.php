<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/taka_garden/helper/DataProvider.php';
class Order {

    var $orderID, $orderDate, $userID, $total, $hoten, $sdt, $email, $status;

    function __construct($orderID, $orderDate, $userID, $total, $hoten, $sdt, $email, $status=0) {
        $this->orderID = $orderID;
        $this->orderDate = $orderDate;
        $this->userID = $userID;
        $this->total = $total;
        $this->hoten = $hoten;
        $this->sdt = $sdt;
        $this->email = $email;
        $this->status = $status;
    }

    public function getOrderID() {
        return $this->orderID;
    }

    public function getOrderDate() {
        return $this->orderDate;
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getTotal() {
        return $this->total;
    }
    public function getHoTen() {
        return $this->hoten;
    }

    public function getSdt() {
        return $this->sdt;
    }

    public function getEmail() {
        return $this->email;
    }


    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }

    public function setOrderDate($orderDate) {
        $this->orderDate = $orderDate;
    }

    public function setUserID($userID) {
        $this->userID = $userID;
    }

    public function setTotal($total) {
        $this->total = $total;
    }
    public function setHoTen($hoten) {
        $this->hoten = $hoten;
    }
    public function setSdt($sdt) {
        $this->sdt = $sdt;
    }
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }



    public function add() {
		
        $str_order_date = date('Y-m-d H:i:s', $this->orderDate);

        $sql = "insert into orders (orderDate, user, total, hoten, sdt, email, status) values ('$str_order_date', '$this->userID' , $this->total, '$this->hoten','$this->sdt','$this->email', 0)";
		
        $this->orderID = DataProvider::execNonQueryIdentity($sql);
    }

    public static function loadAll(){
        $ret = array();

        $sql = "select * from orders";
        $list = DataProvider::execQuery($sql);

        while ($row = mysqli_fetch_array($list)) {
            $orderId = $row["orderId"];
            $orderDate = $row["orderDate"];
            $user = $row["user"];
            $total = $row["total"];
            $hoten = $row["hoTen"];
            $sdt = $row["sdt"];
            $email = $row["email"];
            $status = $row["status"];
            $note = $row["note"];

            $p = new Order($orderId, $orderDate, $user, $total, $hoten, $sdt, $email, $status, $note);
            array_push($ret, $p);
        }

        return $ret;
    }

    public static function loadOrderbyId($id){
        $sql = "select * from orders where orderID = $id";
        $list = DataProvider::execQuery($sql);
        if ($row = mysqli_fetch_array($list)) {

            $orderId = $row["orderId"];
            $orderDate = $row["orderDate"];
            $user = $row["user"];
            $total = $row["total"];
            $hoten = $row["hoTen"];
            $sdt = $row["sdt"];
            $email = $row["email"];
            $status = $row["status"];
            $note = $row["note"];
            $p = new Order($orderId, $orderDate, $user, $total, $hoten, $sdt, $email, $status, $note);
            return $p;
        }

        return NULL;
    }

    public static function loadOrderDetail($id){
        $ret = array();

        $sql = "SELECT o.*, p.proName, p.proID FROM orderdetails o LEFT JOIN products p on o.ProId = p.ProID  where o.orderID = $id ";
        $list = DataProvider::execQuery($sql);
        
        while ($row = mysqli_fetch_array($list)) {
            $p = array(
                'orderId' => $row["orderID"],
                'proID' => $row['proID'],
                'proName' => $row['proName'],
                'quantity' => $row['quantity'],
                'price' => $row['price'],
                'amount' => $row['amount'],
                
            );
            array_push($ret, $p);
        }

        return $ret;
    }

    public static function updateOrder($id, $params){
        $note = isset($params['note']) ? $params['note'] : '';
        $status = isset($params['status']) ? $params['status'] : 0;
        $sql = "update orders set note= '$note', status = $status where orderId = $id";
        // var_dump($sql);die();
        DataProvider::execQuery($sql);
        return true;
    }

    public static function delete($id){
        $sql = "DELETE FROM orders where orderId = $id";
        DataProvider::execQuery($sql);
        return true;
    }
}

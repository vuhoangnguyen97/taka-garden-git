<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . './entities/Order.php';
    define("SERVER1", "localhost");
    define("DB1", "quanlytaka");
    define("UID1", "root");
    define("PWD1", "");

    $month = (isset($_GET['month'])? $_GET['month']: 0);
    $year = (isset($_GET['year'])? $_GET['year']: 0);

    function execQuery($sql)
    {
        $cn = mysqli_connect(SERVER1, UID1, PWD1, DB1) or die ('Không thể kết nối tới DataProviderMain');
        mysqli_set_charset($cn, 'UTF8');

        $result = mysqli_query($cn, $sql);
        if (!$result) {
            die ('Câu truy vấn bị sai');
        }

        return $result;
    }

    function pivotData($month, $year){

        $query = "SELECT * FROM orders o where YEAR(o.orderDate) = $year AND MONTH(o.orderDate) = $month";
        $ret = array();

        $list = execQuery($query);
        while ($row = mysqli_fetch_array($list)) {
            $orderId = $row["orderId"];
            $orderDate = $row["orderDate"];
            $user = $row["user"];
            $total = $row["total"];
            $hoten = $row["hoTen"];
            $sdt = $row["sdt"];
            $email = $row["email"];
            $status = $row["status"];
//            $note = $row["note"];

            $p = new Order($orderId, $orderDate, $user, $total, $hoten, $sdt, $email, $status);
            array_push($ret, $p);
        }

        return $ret;
    }

    $list = pivotData($month, $year);
    $listJSON = json_encode($list, JSON_UNESCAPED_UNICODE);
    echo $listJSON;
?>
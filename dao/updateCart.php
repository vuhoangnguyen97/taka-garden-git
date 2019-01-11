<?php
    if (isset($_POST['txtSoLuong'])) {

        $date = time();
        $user = isset($_SESSION['CurrentUser']);
        if ($user == null) {
            $hoTen = $_POST['txtHoTen'];
            $sdt = $_POST['txtSoDienThoai'];
            $email = $_POST['txtEmail'];
        } else {
            $hoTen = '';
        }
        $total = 0;
        foreach ($_SESSION['Cart'] as $masp => $solg) {
            $p = Products::loadProductByProId($masp);
            if ($p->onsale) {
                $amount = $p->salesprice * $solg;
            } else {
                $amount = $p->getPrice() * $solg;
            }
            $total += $amount;
            Products::UpdateQuantity($masp, $solg);
        }
        $o = new Order(-1, $date, $user, $total, $hoTen, $sdt, $email);
        // var_dump($o);die();
        $o->add();
        // thêm nhiều dòng chi tiết hoá đơn

        foreach ($_SESSION['Cart'] as $masp => $solg) {
            $p = Products::loadProductByProId($masp);
            if ($p->onsale) {
                $amount = $p->salesprice * $solg;
                $detail = new OrderDetail(-1, $o->getOrderID(), $masp, $solg, $p->salesprice, $amount);
            } else {
                $amount = $p->getPrice() * $solg;
                $detail = new OrderDetail(-1, $o->getOrderID(), $masp, $solg, $p->getPrice(), $amount);
            }
            $detail->add();
        }
    }
?>
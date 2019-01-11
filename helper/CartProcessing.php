<?php


class CartProcessing {

    public static function addItem($masp, $solg) {

        if (array_key_exists($masp, $_SESSION['Cart'])) {
            $_SESSION['Cart'][$masp] += $solg;
        } else {
            $_SESSION['Cart'][$masp] = $solg;
        }
    }

    public static function countQuantity() {
        $ret = 0;
        foreach ($_SESSION['Cart'] as $masp => $solg) {
            $ret += $solg;
        }

        return $ret;
    }

    public static function removeItem($proId) {
        foreach ($_SESSION['Cart'] as $key => $val) {
            if ($key == $proId) {
                unset($_SESSION['Cart'][$key]);
                return;
            }
        }
    }

    public static function updateItem($proId, $quantity) {
        foreach ($_SESSION['Cart'] as $key => $val) {
            if ($key == $proId) {
                $_SESSION['Cart'][$key] = $quantity;
                return;
            }
        }
    }

}

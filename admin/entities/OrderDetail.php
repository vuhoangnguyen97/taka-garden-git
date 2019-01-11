<?php


class OrderDetail {

    var $id, $orderID, $proID, $quantity, $price, $amount;

    function __construct($id, $orderID, $proID, $quantity, $price, $amount) {
        $this->id = $id;
        $this->orderID = $orderID;
        $this->proID = $proID;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->amount = $amount;
    }

    public function getId() {
        return $this->id;
    }

    public function getOrderID() {
        return $this->orderID;
    }

    public function getProID() {
        return $this->proID;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }

    public function setProID($proID) {
        $this->proID = $proID;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function add() {

        $sql = "insert into OrderDetails (OrderID, ProID, Quantity, Price, Amount)
                values($this->orderID, $this->proID, $this->quantity, $this->price, $this->amount)";

        DataProvider::execQuery($sql);
    }

}

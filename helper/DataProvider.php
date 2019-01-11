<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataProvider
 *
 * @author Zenit
 */
define("SERVER", "localhost");
define("DB", "quanlytaka");
define("UID", "root");
define("PWD", "");

class DataProvider
{

    public static function execQuery($sql)
    {
        $cn = mysqli_connect(SERVER, UID, PWD, DB) or die ('Không thể kết nối tới DataProviderMain');
        mysqli_set_charset($cn, 'UTF8');

        $result = mysqli_query($cn, $sql);
        if (!$result) {
            die ('Câu truy vấn bị sai');
        }

        return $result;
    }

    public static function execNonQueryAffectedRows($sql)
    {
        $cn = mysqli_connect(SERVER, UID, PWD, DB) or die ('Không thể kết nối tới DataProviderMain');
        mysqli_set_charset($cn, 'UTF8');

        if (!mysqli_query($cn,$sql))
            die("Lỗi truy vấn: " . mysql_error());

        $affected_rows = mysqli_affected_rows($cn);
        mysqli_close($cn);

        return $affected_rows;
    }

    public static function execNonQueryIdentity($sql)
    {
        $cn = mysqli_connect(SERVER, UID, PWD, DB) or die ('Không thể kết nối tới database');
        mysqli_set_charset($cn, 'UTF8');


        if (!mysqli_query($cn, $sql ))
            die("Lỗi truy vấn: " . mysql_error());

        $id = mysqli_insert_id($cn);
        mysqli_close($cn);

        return $id;
    }

}

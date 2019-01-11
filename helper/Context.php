<?php
require_once DOCUMENT_ROOT . '/taka_garden/entities/User.php';


class Context
{

    public static function isLogged()
    {

        $ret = false;

        if ($_SESSION['IsLogin'] == 1) {
            $ret = true;
        } /*else
			 if (isset($_COOKIE["UserName"])) {
            $username = $_COOKIE["UserName"];
            $u = User::getInfo($username);

            $_SESSION['IsLogin'] = 1;
            $_SESSION['CurrentUser'] = (array) $u;
            
            $ret = true;
        	}*/

        return $ret;
    }

    public static function destroy()
    {
        $_SESSION['IsLogin'] = 0;
        unset($_SESSION['CurrentUser']);

        unset($_SESSION['Cart']);

        /*if (isset($_COOKIE['UserName'])) {
            unset($_COOKIE['UserName']);
            setcookie('UserName', '', time() - 3600); // empty value and old timestamp
        }*/
    }

}

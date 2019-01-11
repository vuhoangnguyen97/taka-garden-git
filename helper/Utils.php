<?php
class Utils {
    public static function RedirectTo($url) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $url");
    }

}

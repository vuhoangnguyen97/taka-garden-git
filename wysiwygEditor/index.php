<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="ckeditor/ckeditor.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
        if (isset($_POST['btnPost'])) {
            $html = $_POST['editor1'];
            echo $html;
        }
        ?>


        <form method="POST" name="frmMain" id="frmMain" action="">
            <textarea name="editor1" id="editor1" rows="10" cols="80"></textarea>
            <script type="text/javascript">
                CKEDITOR.replace('editor1');
            </script>
            <input type="submit" name="btnPost" id="btnPost" value="Post" />
        </form>
    </body>
</html>

<?php
 function flash( $name = '', $message = '', $class = 'success fadeout-message' )
    {
    //We can only do something if the name isn't empty
    if( !empty( $name ) ){
            //No message, create it
			
            if( !empty( $message ) && empty( $_SESSION[$name] ) )
            {
				//var_dump($name);
				//print_r($_SESSION[$name]);die('11');
                if( !empty( $_SESSION[$name] ) )
                {
                    unset( $_SESSION[$name] );
                }
                
                $_SESSION[$name] = $message;
            }
            //Message exists, display it
            elseif( !empty( $_SESSION[$name] ) && empty( $message ) )
            {
				//var_dump($_SESSION[$name]);die('22');
                echo '<div class="" id="msg-flash">'.$_SESSION[$name].'</div>';
            }
            unset($_SESSION[$name]);
        }
    }
?>
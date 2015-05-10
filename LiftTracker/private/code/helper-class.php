<?php

    /**
     * A class containing helper functions.
     */
    class Helper
    {
        /**
         * Creates an instance of a helper.
         */
        public function Helper()
        { }
        
        /**
         * Relocates the user to the given url.
         * @param string $url The desired destination.
         */
        protected function Relocate($url)
        {
            header( "Location:" . $url );

            exit();
        }

        /**
         * Redircts the user through a secured connection.
         */
        protected function SecureConnection($requestedPage = "")
        {
            $url = $requestedPage;

            if ( !isset( $_SERVER['HTTPS'] ) )
            {
                if (empty($requestedPage))
                {
                    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                }
                else
                {
                    $url = 'https://' . $_SERVER['HTTP_HOST'] . $requestedPage;
                }
            }

            $this->Relocate($url);
        }

        /**
         * Redirects the user through an un-secure connection.
         */
        protected function UnsecureConnection($requestedPage = "")
        {
            $url = $requestedPage;

            if (isset($_SERVER['HTTPS']))
            {
                if(empty($requestedPage))
                {
                    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                }
                else
                {
                    $url = 'http://' . $_SERVER['HTTP_HOST'] . $requestedPage;
                }            
            }

            $this->Relocate($url);
        }
        
        /**
         * Redirects to a new page.
         * @param string $url The relative or absolute url of the page to go to.
         * @param boolean $secureConn Indicates whether or not the user should be redirected using a secure connection or not.
         */
        public function Redirect($url, $secureConn = FALSE)
        {
            if ($secureConn == TRUE)
            {
                $this->SecureConnection($url);
            }
            else
            {
                $this->UnsecureConnection($url);
            }
        }

        /**
         * Gets and returns a valid email address string pattern.
         * @return string The pattern.
         */
        public function GetValidEmailPattern()
        {
            return "/^[^@]*@[^@]*\.[^@]*$/";
        }

        /**
         * Gets the relative url for a controller action.
         * @param string $controller The controller file.
         * @param string $action The action to request from the controller.
         * @return string The relative url.
         */
        public function GetControllerScript( $controller, $action )
        {
            $script = $controller . "?" . "action" . "=" . $action;

            return $script;
        }

        /**
         * Get the requested URI.
         * @return string The requested URI.
         */
        public function GetRequestedUri( )
        {
            $uri = urlencode($_SERVER['REQUEST_URI']);

            return $uri;
        }

        /**
         * Converts a date string to the convientional format.
         * @param string $dateIn The current date string.
         * @return string The reformated date string.
         */
        public function ToDisplayDate( $dateIn )
        {
            $phpDate = strtotime( $dateIn );

            if ( $phpDate == FALSE )
            {
                return "";
            }
            else
            {
                return date( 'm/d/Y', $phpDate );
            }		
        }

        /**
         * Converts a date string to the mySQL format.
         * @param string $dateIn The date string.
         * @return string The mySQL fomrated date string.
         */
        public function ToMySQLDate( $dateIn )
        {
            $phpDate = strtotime( $dateIn );

            if ( $phpDate == FALSE )
            {
                return "";
            }
            else
            {
                return date( 'Y-m-d', $phpDate );
            }		
        }

        /**
         * Removes all special character slashes from information collected from the server.
         */
        public function AdjustQuotes( )
        {
            if ( get_magic_quotes_gpc( ) == true )
            {
                array_walk_recursive( $_GET, 'StripSlashes_GPC' );
                array_walk_recursive( $_POST, 'StripSlashes_GPC' );
                array_walk_recursive( $_COOKIE, 'StripSlashes_GPC' );
                array_walk_recursive( $_REQUEST, 'StripSlashes_GPC' );
            }
        }

        /**
         * Removes all special character slashes from a string.
         * @param string $value The string to remove slashes.
         */
        public function StripSlashes_GPC( &$value )
        {
            $value = stripslashes( $value );
        }
    }
?>
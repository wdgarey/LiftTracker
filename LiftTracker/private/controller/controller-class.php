<?php
    /**
     * An object containing the base controller functionallity.
     */
    class Controller
    {
        /**
         * The file paths of the base controller.
         * @var string
         */
        private $paths;
        
        /**
         * The model of the controller.
         * @var string
         */
        private $model;
        
        /**
         * The helper class.
         * @var Helper
         */
        private $helper;
        
        /**
         * The actions of the controller.
         * @var string 
         */
        private $actions;
        
        /**
         * The identifiers that this controller is using.
         * @var Identifiers
         */
        private $identifiers;
        
        /**
         * Gets the file paths of this controller.
         * @return Paths The file paths.
         */
        public function GetPaths()
        {
            return $this->paths;
        }
        
        /**
         * Sets the file paths of this controller.
         * @param Paths $paths The file paths for this controller to use.
         */
        protected function SetPaths($paths)
        {
            $this->paths = $paths;
        }
        
        /**
         * Gets the model that this controller is using.
         * @return Model The model that the controller is using.
         */
        public function GetModel()
        {
            return $this->model;
        }
        
        /**
         * Sets the model for this controller to use.
         * @param Model $model The model for this controller to use.
         */
        protected function SetModel($model)
        {
            $this->model = $model;
        }
        
        /**
         * Gets the helper of the controller.
         * @return Helper The helper.
         */
        public function GetHelper()
        {
            return $this->helper;
        }
        
        /**
         * Sets the helper of the controller.
         * @param Helper $helper The helper.
         */
        protected function SetHelper($helper)
        {
            $this->helper = $helper;
        }
        
        /**
         * Gets the actions being used by this controller.
         * @return Actions The actions that the controller is using.
         */
        public function GetActions()
        {
            return $this->actions;
        }
        
        /**
         * Sets the actions of the controller.
         * @param Actions $actions The actions for the controller to use.
         */
        protected function SetActions($actions)
        {
            $this->actions = $actions;
        }
        
        /**
         * Gets the identifiers that this controller is using.
         * @return Identifiers The identifiers.
         */
        public function GetIdentifiers()
        {
            return $this->identifiers;
        }
        
        /**
         * Sets the idnetifiers for this controller to use.
         * @param Identifiers $identifiers The identifiers.
         */
        protected function SetIdentifiers($identifiers)
        {
            $this->identifiers = $identifiers;
        }
        
        /**
         * Gets the user that is currently logged in.
         * @return \User The user.
         */
        protected function GetUser()
        {
            $model = $this->GetModel();
            $paths = $this->GetPaths();
            
            require_once ($paths->GetUserClassFile());
            
            $user = new User();
            $userIdIdentifier = $user->GetIdIdentifier();
            
            if (isset($_SESSION[$userIdIdentifier]))
            {
                $id = $_SESSION[$userIdIdentifier];
                
                $user = $model->GetUser($id);
            }
            
            return $user;
        }
        
        /**
         * Sets the user that is currently logged in.
         * @param \User $user The user to set.
         */
        protected function SetUser($user)
        {
            $id = $user->GetId();
            $userIdIdentifier = $user->GetIdIdentifier();
            
            $_SESSION[$userIdIdentifier] = $id;
        }
        
        /**
         * Creates an instance of a base controller.
         * @param Paths $paths The file paths for the controller to use.         
         */
        public function Controller($paths)
        {
            error_reporting(E_ALL);
            
            require_once($paths->GetModelClassFile());
            require_once($paths->GetHelperClassFile());
            require_once($paths->GetActionsClassFile());
            require_once($paths->GetIdentifiersClassFile());
            
            $model = new Model($this);
            $helper = new Helper();
            $actions = new Actions();            
            $identifiers = new Identifiers();
            
            $this->SetPaths($paths);
            $this->SetModel($model);
            $this->SetHelper($helper);
            $this->SetActions($actions);
            $this->SetIdentifiers($identifiers);
            
            $this->StartSession();
            
            $helper->AdjustQuotes();
        }
        
        /**
        * Starts the PHP session if it does not already exist.
        */
        protected function StartSession()
        {
            if (!isset($_SESSION))
            {
                session_start( );
            }
        }
        
        /**
         * Ends the PHP session if it exists.
         */
        protected function EndSession()
        {
            if (isset($_SESSION))
            {
                session_unset();

                session_destroy();
            }
        }
        
        /**
         * Gets the URL of the given action.
         * @param string $action The action.
         * @param array $params The name-value pairs to pass as parameters.
         * @return string The url.
         */
        protected function GetUrl($action, $params = array())
        {
            $paths = $this->GetPaths();
            $helper = $this->GetHelper();
            
            $script = $helper->GetControllerScript($paths->GetIndexFile(), $action);
            
            foreach ($params as $name => $value)
            {
                $script .= '&' . $name . '=' . $value;
            }
            
            return $script;
        }
        
        /**
         * Indicates whether or not the user is logged in.
         * @return boolean True, if the user is logged in.
         */
        protected function IsUserLoggedIn()
        {
            $user = $this->GetUser();
            
            $isLoggedIn = $user->IsKnown();
            
            return $isLoggedIn;
        }
        
        /**
         * Gets an arguments passed to the POST or GET array.
         * @param string $argName The name of the argument.
         * @return Mixed FALSE, if no value was set or the value that was set.
         */
        protected function GetArgument($argName)
        {
            $arg = FALSE;
            
            if (isset($_POST[$argName]))
            {
                $arg = $_POST[$argName];
            }
            else if (isset($_GET[$argName]))
            {
                $arg = $_GET[$argName];
            }

            return $arg;
        }
        
        /**
         * Gets the action requested by the user.
         * @return string The action requested.
         */
        protected function GetRequestedAction()
        {
            $actions = $this->GetActions();
            $actionKeyWord = $actions->GetActionKeyWord();
            
            $action = $this->GetArgument($actionKeyWord);
            
            return $action;
        }

        /**
         * Displays a message on a single page.
         * @param string $message The message to display.
         */
        protected function DisplayMessage($message)
        {
            $paths = $this->GetPaths();
            
            include($paths->GetMessageFormFile());
        }
        
        /**
         * Gets html-safe text.
         * @param string $text The raw text
         * @return string The html-safe text.
         */
        protected function GetHtmlSafeText($text)
        {
            $safeText = htmlspecialchars($text);
            
            return $safeText;
        }

        /**
         * Authenticates user credentials.
         * @param string $userName The user name.
         * @param string $password The password.
         * @return Mixd False if the user is not authentic, or the user's I.D if authentic.
         */
        protected function Authenticate($userName, $password)
        {
            $model = $this->GetModel();
            
            $userId = $model->AuthenticateUser($userName, $password);
            
            return $userId;
        }

        /**
         * Indicates whether or not the given action can be carried out.
         * @param string $action The action.
         */
        protected function IsUserAuthorized($action)
        {
            $model = $this->GetModel();
            
            $isAuthorized = $model->IsGuestAuthorized($action);
            
            if (!$isAuthorized && $this->IsUserLoggedIn())
            {
                $user = $this->GetUser();
                $userId = $user->GetId();
                
                $isAuthorized = $model->IsUserAuthorized($userId, $action);
            }
            
            return $isAuthorized;
        }
        
        /**
         * Reports an error to the controller.
         * @param string $message The error to report.
         */
        public function ReportError($message)
        {
            $this->DisplayMessage($message);
        }
        
        /**
         * The user sign up action.
         */
        protected function SelfAdd()
        {
            $actions = $this->GetActions();
            
            if ($this->IsUserLoggedIn())
            {
                $helper = $this->GetHelper();
                $actions = $this->GetActions();
                
                $helper->Redirect($this->GetUrl($actions->GetHomeAction()));
            }
            
            $paths = $this->GetPaths();
            
            require_once($paths->GetUserClassFile());
            
            $user = new User();
            
            $idIdentifier = $user->GetIdIdentifier();
            $firstNameIdentifier = $user->GetFirstNameIdentifier();
            $lastNameIdentifier = $user->GetLastNameIdentifier();
            $emailIdentifier = $user->GetEmailIdentifier();
            $userNameIdentifier = $user->GetUserNameIdentifier();
            $passwordIdentifier = $user->GetPasswordIdentifier();
            $passwordRetypeIdentifier = $user->GetPasswordRetypeIdentifier();
            
            $id = $user->GetId();
            $firstName = $user->GetFirstName();
            $lastName = $user->GetLastName();
            $email =  $user->GetEmail();
            $userName = $user->GetUserName();
            $password = "";
            $passwordRetype = "";
            
            include($paths->GetSelfAddEditFormFile());
        }
        
        /**
         * The user sign up action.
         */
        protected function SelfEdit()
        {
            $actions = $this->GetActions();
            
            if (!$this->IsUserLoggedIn())
            {
                $helper = $this->GetHelper();
                $actions = $this->GetActions();
                
                $helper->Redirect($this->GetUrl($actions->GetHomeAction()));
            }
            
            $paths = $this->GetPaths();
            
            require_once($paths->GetUserClassFile());
            
            $user = $this->GetUser();
            
            $idIdentifier = $user->GetIdIdentifier();
            $firstNameIdentifier = $user->GetFirstNameIdentifier();
            $lastNameIdentifier = $user->GetLastNameIdentifier();
            $emailIdentifier = $user->GetEmailIdentifier();
            $userNameIdentifier = $user->GetUserNameIdentifier();
            $passwordIdentifier = $user->GetPasswordIdentifier();
            $passwordRetypeIdentifier = $user->GetPasswordRetypeIdentifier();
            
            $id = $user->GetId();
            $firstName = $user->GetFirstName();
            $lastName = $user->GetLastName();
            $email =  $user->GetEmail();
            $userName = $user->GetUserName();
            $password = "";
            $passwordRetype = "";
            
            include($paths->GetSelfAddEditFormFile());
        }
        
        /**
         * Processes user add edit.
         */
        protected function ProcessSelfAddEdit()
        {
            $paths = $this->GetPaths();
            $helper = $this->GetHelper();
            $actions = $this->GetActions();
            
            require_once($paths->GetUserClassFile());
            require_once($paths->GetValidationInfoClassFile());
            $user = new User();
            
            $user->Initialize($_POST);
            
            $model = $this->GetModel();

            $vInfo = new ValidationInfo();
            if ($this->IsUserLoggedIn())
            {   
                $curUser = $this->GetUser();
                
                if ($curUser->GetId() === $user->GetId())
                {
                    $user->SetUserName($curUser->GetUserName());
                    $userVi = $user->Validate();
                    
                    if ($userVi->IsValid())
                    {
                        $model->UpdateUser($user);
                        
                        $helper->Redirect($this->GetUrl($actions->GetSelfViewAction()));
                    }
                    else
                    {
                        $vInfo->Merge($userVi);
                    }
                }
            }
            else
            {
                if ($user->IsPasswordSet())
                {
                    $model->AddUser($user);

                    $this->SetUser($user);
                    
                    $helper->Redirect($this->GetUrl($actions->GetSelfViewAction()));
                }
                else
                {
                    $vInfo->Merge(new ValidationInfo(array("Please set up a password.")));
                }
            }

            $idIdentifier = $user->GetIdIdentifier();
            $firstNameIdentifier = $user->GetFirstNameIdentifier();
            $lastNameIdentifier = $user->GetLastNameIdentifier();
            $emailIdentifier = $user->GetEmailIdentifier();
            $userNameIdentifier = $user->GetUserNameIdentifier();
            $passwordIdentifier = $user->GetPasswordIdentifier();
            $passwordRetypeIdentifier = $user->GetPasswordRetypeIdentifier();
            
            $id = $user->GetId();
            $firstName = $user->GetFirstName();
            $lastName = $user->GetLastName();
            $email =  $user->GetEmail();
            $userName = $user->GetUserName();
            $password = "";
            $passwordRetype = "";
            
            $message = "Invalid user information";
            $list = $vInfo->GetErrors();
            
            include($paths->GetSelfAddEditFormFile());
        }
        
        /**
         * Allows the user to view their profile.
         */
        protected function SelfView()
        {
            $helper = $this->GetHelper();
            $actions = $this->GetActions();
            
            if (!$this->IsUserLoggedIn())
            {
                $helper->Redirect($this->GetUrl($actions->GetHomeAction()));
            }
            
            $paths = $this->GetPaths();
            
            require_once($paths->GetUserClassFile());
            
            $user = $this->GetUser();
            
            $idIdentifier = $user->GetIdIdentifier();
            $firstNameIdentifier = $user->GetFirstNameIdentifier();
            $lastNameIdentifier = $user->GetLastNameIdentifier();
            $emailIdentifier = $user->GetEmailIdentifier();
            $userNameIdentifier = $user->GetUserNameIdentifier();
            $passwordIdentifier = $user->GetPasswordIdentifier();
            $passwordRetypeIdentifier = $user->GetPasswordRetypeIdentifier();
            
            $id = $user->GetId();
            $firstName = $user->GetFirstName();
            $lastName = $user->GetLastName();
            $email =  $user->GetEmail();
            $userName = $user->GetUserName();
            $password = "";
            $passwordRetype = "";
            
            include($paths->GetSelfViewFormFile());
        }

        /**
         * Prompts the user to log in.
         */
        protected function Login()
        {
            $actions = $this->GetActions();
            
            if ($this->IsUserLoggedIn())
            {
                $helper = $this->GetHelper();
                $helper->Redirect($this->GetUrl($actions->GetHomeAction()));
            }
            
            $helper = $this->GetHelper();
            $paths = $this->GetPaths();
            $identifiers = $this->GetIdentifiers();
            
            require_once($paths->GetUserClassFile());
            
            $user = new User();
            
            $userNameIdentifier = $user->GetUserNameIdentifier();
            $passwordIdentifier = $user->GetPasswordIdentifier();
            $requestedPageIdentifier = $identifiers->GetRequestedPageIdentifier();
            
            $requestedPage = $this->GetArgument($requestedPageIdentifier);
            
            if ($requestedPage == FALSE)
            {
                $requestedPage = $this->GetUrl($actions->GetHomeAction());
            }
            
            $userName = $user->GetUserName();
            $password = "";
            
            include($paths->GetLoginFormFile());
        }
        
        /**
         * Processes the user login.
         */
        protected function ProcessLogin()
        {
            $actions = $this->GetActions();
            
            if ($this->IsUserLoggedIn())
            {
                $helper = $this->GetHelper();
                $helper->Redirect($this->GetUrl($actions->GetHomeAction()));
            }
            
            $paths = $this->GetPaths();
            $identifiers = $this->GetIdentifiers();
            
            require_once($paths->GetUserClassFile());
            
            $user = new User();
            $user->Initialize($_POST);
            
            $userId = $this->Authenticate($user->GetUserName(), $user->GetPassword());

            $requestedPageIdentifier = $identifiers->GetRequestedPageIdentifier();
            $requestedPage = $this->GetArgument($requestedPageIdentifier);
            
            if ($userId !== FALSE)
            {
                $model = $this->GetModel();
                $helper = $this->GetHelper();
                
                $user = $model->GetUser($userId);
                
                $this->SetUser($user);
                
                $helper->Redirect($requestedPage);
            }
            
            $userNameIdentifier = $user->GetUserNameIdentifier();
            $passwordIdentifier = $user->GetPasswordIdentifier();
            
            $userName = $user->GetUserName();
            $password = "";
            
            $message = "Invalid username and/or password.";
            
            include($paths->GetLoginFormFile());
        }
        
        /**
         * Ends the session and redirects the user to login.
         */
        protected function Logout()
        {
            $helper = $this->GetHelper();
            $actions = $this->GetActions();
            
            $this->EndSession();
            
            $helper->Redirect($this->GetUrl($actions->GetHomeAction()));
        }
        
        /**
         * The home function.
         */
        protected function Home()
        {
            $paths = $this->GetPaths();
            
            include($paths->GetHomeFormFile());
        }
        
        /**
         * Runs the controller.
         */
        public function Run()
        {
            $action = $this->GetRequestedAction();
            $actions = $this->GetActions();
            
            if (!$this->IsUserAuthorized($action))
            {
                if (!$this->IsUserLoggedIn())
                {
                    $helper = $this->GetHelper();
                    $identifiers = $this->GetIdentifiers();
                    $requestedPageIdentifier = $identifiers->GetRequestedPageIdentifier();
                    
                    $params = array();
                    $params[$requestedPageIdentifier] = $helper->GetRequestedUri();
                    
                    $helper->Redirect($this->GetUrl($actions->GetLoginAction(), $params));
                }
                else
                {
                    $this->DisplayMessage("Not Authorized");
                }

                exit();
            }

            switch ($action)
            {
                case $actions->GetSelfAddAction():
                    $this->SelfAdd();
                    break;
                case $actions->GetSelfEditAction():
                    $this->SelfEdit();
                    break;
                case $actions->GetProcessSelfAddEditAction():
                    $this->ProcessSelfAddEdit();
                    break;
                case $actions->GetSelfViewAction():
                    $this->SelfView();
                    break;
                case $actions->GetLoginAction():
                    $this->Login();
                    break;
                case $actions->GetProcessLoginAction():
                    $this->ProcessLogin();
                    break;
                case $actions->GetLogoutAction():
                    $this->Logout();
                    break;
                default:
                    $this->Home();
                    break;
            }
        }
    }
?>
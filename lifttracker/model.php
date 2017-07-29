<?php

/**
 * An object containing the basic model functions.
 */
class Model
{
    /**
     * The controller of the mode.
     * @var Controller
     */
    private $controller;

    /**
     * Gets the model's controller.
     * @return Controller The model's controller.
     */
    public function GetController()
    {
        return $this->controller;
    }

    /**
     * Sets the models controller.
     * @param Controller $controller The model's controller.
     */
    public function SetController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * Creates an instance of the model class.
     * @param Controller $controller The model's controller.
     */
    public function Model($controller)
    {
        $this->SetController($controller);
    }

    /**
     * Gets the controller paths object.
     * @return \Paths The paths.
     */
    protected function GetControllerPaths()
    {
        $controller = $this->GetController();
        $paths = $controller->GetPaths();

        return $paths;
    }

    /**
     * Gets a connection fo the database.
     * @return \PDO The connection to the database.
     */
    protected function GetDBConnection( )
    {
        $dsn = 'mysql:host=localhost;dbname=lifttracker';
        $username = 'lifttrackerwebuser';
        $password = 'lifttrackerwebuser1234';

        try
        {
            $db = new PDO( $dsn, $username, $password );
        }
        catch ( PDOException $e )
        {
            $this->LogError($e->getMessage());
            die();
        }

        return $db;            
    }

    /**
     * Gets the mailer used for sending emails.
     * @return Mailer The mailer to use to send emails.
     */
    protected function GetEmailMailer( )
    {
        require_once 'Mail.php';

        $options = array();
        $options['host'] = 'ssl://smtp.gmail.com';
        $options['port'] = 465;
        $options['auth'] = true;
        $options['username'] = 'flpexam@gmail.com';
        $options['password'] = 'flpexam411';
        $mailer = Mail::factory('smtp', $options);

        return $mailer;
    }

    /**
     * Logs the given error.
     * @param string $error The error.
     */
    public function LogError($error)
    {
        $controller = $this->GetController();

        $controller->ReportError($error);
    }

    /**
     * Indicates whether or not a guest is authorized to carry out an action.
     * @param string $action The action in question.
     * @return boolean True, if the guest can peform the action.
     */
    public function IsGuestAuthorized($action)
    {
        $isGuestAuthorized = FALSE;
        $db = $this->GetDBConnection();
        $paths = $this->GetControllerPaths();

        require_once($paths->GetFunctionClassFile());
        $function = new Func();
        $functionTable = $function->GetIdentifier();
        $functionIdCol = $function->GetIdIdentifier();
        $functionNameCol = $function->GetNameIdentifier();

        try
        {
            $query = "SELECT " . $functionIdCol
                    . " FROM " . $functionTable
                    . " WHERE " . $functionNameCol . " = :" . $functionNameCol
                    . ";";

            $statement = $db->prepare($query);
            $statement->bindValue(":" . $functionNameCol, $action);

            $statement->execute();

            $results = $statement->fetch();

            $statement->closeCursor();

            if ($results == FALSE)
            {
               $isGuestAuthorized = TRUE; 
            }
        }
        catch (Exception $ex)
        {
            $this->LogError($ex->getMessage());
        }

        return $isGuestAuthorized;
    }

    /**
     * Indicates whether or not a user is authorized to carry out an action.
     * @param long $userId The I.D. of the user.
     * @param string $action The action.
     * @return boolean True, if the user is authorized.
     */
    public function IsUserAuthorized($userId, $action)
    {
        $isAuthorized = FALSE;
        $db = $this->GetDBConnection();
        $paths = $this->GetControllerPaths();

        require_once($paths->GetUserClassFile());
        require_once($paths->GetRoleClassFile());
        require_once($paths->GetFunctionClassFile());
        require_once($paths->GetUserRoleClassFile());
        require_once($paths->GetRoleFunctionClassFile());

        $user = new User();
        $role = new Role();
        $function = new Func();
        $userRole = new UserRole();
        $roleFunc = new RoleFunction();

        $userTable = $user->GetIdentifier();
        $roleTable = $role->GetIdentifier();
        $functionTable = $function->GetIdentifier();
        $userRoleTable = $userRole->GetRoleIdIdentifier();
        $roleFunctionTable = $roleFunc->GetIdentifier();

        $userIdCol = $user->GetIdIdentifier();
        $roleIdCol = $role->GetIdIdentifier();
        $functionIdCol = $function->GetIdIdentifier();
        $functionNameCol = $function->GetNameIdentifier();

        try
        {
            $query = "SELECT " . $functionTable . "." . $functionIdCol
                    . " FROM " . $userTable
                    . " INNER JOIN " . $userRoleTable
                    . " ON " . $userRoleTable . "." . $userIdCol . " = " . $userTable . "." . $userIdCol
                    . " INNER JOIN " . $roleTable
                    . " ON " . $roleTable . "." . $roleIdCol . " = "  . $userRoleTable . "." . $roleIdCol
                    . " INNER JOIN " . $roleFunctionTable
                    . " ON " . $roleFunctionTable . "." . $roleIdCol . " = " . $roleTable . "." . $roleIdCol
                    . " INNER JOIN " . $functionTable
                    . " ON " . $functionTable . "." . $functionIdCol . " = " . $roleFunctionTable . "." . $functionIdCol
                    . " WHERE " . $userTable . "." . $userIdCol . " = :" . $userIdCol
                    . " AND ". $functionTable . "." . $functionNameCol . " = :" . $functionNameCol
                    . ";";

            $statement = $db->prepare($query);
            $statement->bindValue(":" . $userIdCol, $userId);
            $statement->bindValue(":" . $functionNameCol, $action);

            $statement->execute();

            $results = $statement->fetch();

            $statement->closeCursor();

            if (count($results) > 1)
            {
                $isAuthorized = TRUE;
            }
        }
        catch (Exception $ex)
        {
            $this->LogError($ex->getMessage());
        }

        return $isAuthorized;
    }

    /**
     * Authenticates a user.
     * @param string $userName The user name.
     * @param string $password The password.
     * @return Mixed FALSE if authentication fails or int the user's I.D.
     */
    public function AuthenticateUser($userName, $password)
    {
        $userId = FALSE;
        $db = $this->GetDBConnection();
        $paths = $this->GetControllerPaths();

        require_once($paths->GetUserClassFile());

        $user = new User();

        $userTable = $user->GetIdentifier();
        $userIdCol = $user->GetIdIdentifier();
        $userNameCol = $user->GetUserNameIdentifier();
        $passwordCol = $user->GetPasswordIdentifier();

        try
        {
            $query = "SELECT " . $userIdCol
                    . " FROM " . $userTable
                    . " WHERE " . $userNameCol . " = :" . $userNameCol
                    . " AND " . $passwordCol . " = Sha1(:" . $passwordCol . ");";

            $statement = $db->prepare($query);
            $statement->bindValue(":" . $userNameCol, $userName);
            $statement->bindValue(":" . $passwordCol, $password);

            $statement->execute();

            $results = $statement->fetch();

            if ($results != FALSE)
            {
                $userId = $results[$userIdCol];
            }
        } 
        catch (Exception $ex)
        {
            $this->LogError($ex->getMessage());
        }

        return $userId;
    }

    /**
     * Indicates whether or not the given user name exists.
     * @param string $userName The user name to check for.
     * @return boolean True, if the user name exists, or false otherwise.
     */
    public function UserNameExists($userName)
    {
        $userNameExists = FALSE;
        $db = $this->GetDBConnection();
        $paths = $this->GetControllerPaths();

        require_once($paths->GetUserClassFile());

        $user = new User();

        $userTable = $user->GetIdentifier();
        $userIdCol = $user->GetIdIdentifier();
        $userNameCol = $user->GetUserNameIdentifier();

        try
        {
            $query = "SELECT " . $userIdCol
                    . " FROM " . $userTable
                    . " WHERE " . $userNameCol . " = :" . $userNameCol
                    . ";";

            $statement = $db->prepare($query);
            $statement->bindValue(":" . $userNameCol, $userName);

            $statement->execute();

            $results = $statement->fetch();

            $statement->closeCursor();

            if ($results != FALSE)
            {
                $userNameExists = TRUE;
            }
        }
        catch (PDOException $ex)
        {
            $this->LogError($ex->getMessage());
        }

        return $userNameExists;
    }

    /**
     * Adds a user to the records.
     * @param \User $user The user to add.
     */
    public function AddUser($user)
    {
        $userId = 0;
        $db = $this->GetDBConnection();

        $userTable = $user->GetIdentifier();
        $firstNameCol = $user->GetFirstNameIdentifier();
        $lastNameCol = $user->GetLastNameIdentifier();
        $emailCol = $user->GetEmailIdentifier();
        $userNameCol = $user->GetUserNameIdentifier();
        $passwordCol = $user->GetPasswordIdentifier();

        try
        {
            $query = "INSERT INTO " . $userTable
                    . " (" . $firstNameCol
                    . ", " . $lastNameCol
                    . ", " . $emailCol
                    . ", " . $userNameCol
                    . ", " . $passwordCol
                    . ") VALUES (:" . $firstNameCol
                    . ", :" . $lastNameCol
                    . ", :" . $emailCol
                    . ", :" . $userNameCol
                    . ", Sha1(:" . $passwordCol . "));";

            $statement = $db->prepare($query);
            $statement->bindValue(":" . $firstNameCol, $user->GetFirstName());
            $statement->bindValue(":" . $lastNameCol, $user->GetLastName());
            $statement->bindValue(":" . $emailCol, $user->GetEmail());
            $statement->bindValue(":" . $userNameCol, $user->GetUserName());
            $statement->bindValue(":" . $passwordCol, $user->GetPassword());

            $statement->execute();

            $userId = $db->lastInsertId();

            $statement->closeCursor();
        }
        catch (PDOException $ex)
        {
            $this->LogError($ex->getMessage());
        }

        return $userId;
    }

    /**
     * Updates the information of the given user.
     * @param \User $user The user info to update.
     */
    public function UpdateUser($user)
    {
        $db = $this->GetDBConnection();
        $paths = $this->GetControllerPaths();

        require_once($paths->GetUserClassFile());

        $user = new User();

        $userTable = $user->GetIdentifier();
        $userIdCol = $user->GetIdIdentifier();
        $firstNameCol = $user->GetFirstNameIdentifier();
        $lastNameCol = $user->GetLastNameIdentifier();
        $emailCol = $user->GetEmailIdentifier();
        $userNameCol = $user->GetUserNameIdentifier();

        try
        {
            $query = "UPDATE " . $userTable
                    . " SET " . $firstNameCol . " = :" . $firstNameCol
                    . ", " . $lastNameCol . " = :" . $lastNameCol
                    . ", " . $emailCol . " = :" . $emailCol
                    . ", " . $userNameCol . " = :" . $userNameCol
                    . " WHERE " . $userIdCol . " = :" . $userIdCol
                    . ";";

            $statement = $db->prepare($query);
            $statement->bindValue(":" . $userIdCol, $user->GetId());
            $statement->bindValue(":" . $firstNameCol, $user->GetFirstName());
            $statement->bindValue(":" . $lastNameCol, $user->GetLastName());
            $statement->bindValue(":" . $emailCol, $user->GetEmail());
            $statement->bindValue(":" . $userNameCol, $user->GetUserName());

            $statement->execute();

            $statement->closeCursor();

            if ($user->IsPasswordSet())
            {
                $this->UpdateUserPassword($user->GetId(), $user->GetPassword());
            }
        }
        catch (PDOException $ex)
        {
            $this->LogError($ex->getMessage());
        }
    }

    /**
     * Updates a user's password.
     * @param int $userId The I.D. of the user.
     * @param string $password The new password.
     */
    public function UpdateUserPassword($userId, $password)
    {
        $paths = $this->GetControllerPaths();
        $db = $this->GetDBConnection();

        require_once($paths->GetUserClassFile());

        $user = new User();
        $userTable = $user->GetIdIdentifier();
        $userIdCol = $user->GetIdIdentifier();
        $userPasswordCol = $user->GetPasswordIdentifier();

        try
        {
            $query = "UPDATE " . $userTable
                    . " SET " . $userPasswordCol . " = Sha1(:" . $userPasswordCol . ")"
                    . " WHERE " . $userIdCol . " = :" . $userIdCol
                    . ";";

            $statement = $db->prepare($query);
            $statement->bindValue(":" . $userIdCol, $userId);
            $statement->bindValue(":" . $userPasswordCol, $password);

            $statement->execute();

            $statement->closeCursor();

        }
        catch (PDOException $ex)
        {
            $this->LogError($ex->getMessage());
        }
    }

    /**
     * Gets the user with the given I.D.
     * @param int $userId The I.D. of the user.
     * @return \User The user, or NULL, if no user was found.
     */
    public function GetUser($userId)
    {
        $db = $this->GetDBConnection();
        $paths = $this->GetControllerPaths();

        require_once($paths->GetUserClassFile());

        $user = new User();

        $userTable = $user->GetIdentifier();
        $userIdCol = $user->GetIdIdentifier();
        $firstNameCol = $user->GetFirstNameIdentifier();
        $lastNameCol = $user->GetLastNameIdentifier();
        $emailCol = $user->GetEmailIdentifier();
        $userNameCol = $user->GetUserNameIdentifier();

        try
        {
            $query = "SELECT " . $userIdCol
                    . ", " . $firstNameCol
                    . ", " . $lastNameCol
                    . ", " . $emailCol
                    . ", " . $userNameCol
                    . " FROM " . $userTable
                    . " WHERE " . $userIdCol . " = :" . $userIdCol
                    . ";";

            $statement = $db->prepare($query);
            $statement->bindValue(":" . $userIdCol, $userId);

            $statement->execute();

            $results = $statement->fetch();

            if ($results != FALSE)
            {
                $user->Initialize($results);
            }
        }
        catch (Exception $ex)
        {
            $this->LogError($ex->getMessage());
        }

        return $user;
    }
}
?>

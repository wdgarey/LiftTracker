<?php
require_once($paths->GetHelperClassFile());
require_once($paths->GetValidationInfoClassFile());

/**
 * A user.
 */
class User
{
    /**
     * The user's I.D.
     * @var long
     */
    private $id;

    /**
     * The user's user name.
     * @var string
     */
    private $userName;

    /**
     * The first name of the user.
     * @var string
     */
    private $firstName;

    /**
     * The last name of the user.
     * @var string.
     */
    private $lastName;

    /**
     * The email of the user.
     * @var type 
     */
    private $email;
    
    /**
     * The password.
     * @var string
     */
    private $password;
    
    /**
     * The password retype.
     * @var string
     */
    private $passwordRetype;

    /**
     * Gets the I.D. of the user.
     * @return long The I.D.
     */
    public function GetId()
    {
        return $this->id;
    }

    /**
     * Sets the I.D. of the user.
     * @param long $id The I.D.
     */
    public function SetId($id)
    {
        $this->id = $id;
    }

    /**
     * Gets the user name of the user.
     * @return string The user name.
     */
    public function GetUserName()
    {
        return $this->userName;
    }

    /**
     * Sets the user name of the user.
     * @param string $userName The user name.
     */
    public function SetUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * Gets the first name of the user.
     * @return string The first name.
     */
    public function GetFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets the first name of the user.
     * @param string $firstName The first name.
     */
    public function SetFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Gets the last name of the user.
     * @return string The last name.
     */
    public function GetLastName()
    {
        return $this->lastName;
    }

    /**
     * Sets the last name of the user.
     * @param string $lastName The last name.
     */
    public function SetLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Gets the email of the user.
     * @return string The email.
     */
    public function GetEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email of the user.
     * @param string $email The email.
     */
    public function SetEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Gets the user password.
     * @return string The password.
     */
    public function GetPassword()
    {
        return $this->password;
    }
    
    /**
     * Sets the password.
     * @param string $password The password.
     */
    public function SetPassword($password)
    {
        $this->password = $password;
    }
    
    /**
     * Gets the password retype.
     * @return string The password retype.
     */
    public function GetPasswordRetype()
    {
        return $this->passwordRetype;
    }
    
    /**
     * Sets the password retype.
     * @param string $passwordRetype The password retype.
     */
    public function SetPasswordRetype($passwordRetype)
    {
        $this->passwordRetype = $passwordRetype;
    }
    
    /**
     * Creates an instance of a user.
     */
    public function User()
    {
        $this->SetId(0);
        $this->SetUserName("");
        $this->SetFirstName("");
        $this->SetLastName("");
        $this->SetEmail("");
        $this->SetPassword(NULL);
        $this->SetPasswordRetype(NULL);
    }

    /**
     * Initializes the user.
     * @param array $row The user row.
     */
    public function Initialize($row)
    {
        $idIdentifier = $this->GetIdIdentifier();
        $userNameIdentifier = $this->GetUserNameIdentifier();
        $firstNameIdentifier = $this->GetFirstNameIdentifier();
        $lastNameIdentifier = $this->GetLastNameIdentifier();
        $emailIdentifier = $this->GetEmailIdentifier();
        $passwordIdentifier = $this->GetPasswordIdentifier();
        $passwordRetypeIdentifier = $this->GetPasswordRetypeIdentifier();
        
        if (isset($row[$idIdentifier]))
        {
            $id = $row[$idIdentifier];

            $this->SetId($id);
        }

        if (isset($row[$userNameIdentifier]))
        {
            $userName = $row[$userNameIdentifier];

            $this->SetUserName($userName);
        }

        if (isset($row[$firstNameIdentifier]))
        {
            $firstName = $row[$firstNameIdentifier];

            $this->SetFirstName($firstName);
        }

        if (isset($row[$lastNameIdentifier]))
        {
            $lastName = $row[$lastNameIdentifier];

            $this->SetLastName($lastName);
        }

        if (isset($row[$emailIdentifier]))
        {
            $email = $row[$emailIdentifier];

            $this->SetEmail($email);
        }
        
        if (isset($row[$passwordIdentifier]))
        {
            $password = $row[$passwordIdentifier];
            
            $this->SetPassword($password);
        }
        
        if (isset($row[$passwordRetypeIdentifier]))
        {
            $passwordRetype = $row[$passwordRetypeIdentifier];
            
            $this->SetPasswordRetype($passwordRetype);
        }
    }

    /**
     * Gets the key of the session array that stores user info.
     * @return string The user session identifier key.
     */
    public function GetIdentifier()
    {
        return "user";
    }

    /**
     * Gets the user I.D. identifier.
     * @return string The identifier.
     */
    public function GetIdIdentifier()
    {
        return "UserId";
    }

    /**
     * Gets the user name identifier.
     * @return string The identifier.
     */
    public function GetUserNameIdentifier()
    {
        return "UserName";
    }

    /**
     * Gets the password identifier.
     * @return string The identifier.
     */
    public function GetPasswordIdentifier()
    {
        return "Password";
    }

    /**
     * Gets the password retype identifier.
     * @return string The identifier.
     */
    public function GetPasswordRetypeIdentifier()
    {
        return "PasswordRetype";
    }

    /**
     * Gets the first name identifier.
     * @return string The identifier.
     */
    public function GetFirstNameIdentifier()
    {
        return "FirstName";
    }

    /**
     * Gets the last name identifier.
     * @return string The identifier.
     */
    public function GetLastNameIdentifier()
    {
        return "LastName";
    }

    /**
     * Gets the email identifier.
     * @return string The identifier.
     */
    public function GetEmailIdentifier()
    {
        return "Email";
    }
    
    /**
     * Indicates whether or not the password is set.
     * @return boolean True, if the password is set.
     */
    public function IsPasswordSet()
    {
        $password = $this->GetPassword();
        
        $isSet = ($password != NULL);
        
        return $isSet;
    }
    
    /**
     * Indicates whether or not the user is known.
     * @return boolean True, if the user is known.
     */
    public function IsKnown()
    {
        $id = $this->GetId();
        
        $isKnown = ($id != 0);
        
        return $isKnown;
    }

    /**
     * Validates the user name.
     * @return \ValidationInfo The validation info.
     */
    protected function ValidateUserName()
    {
        $errors = array();

        $userName = $this->GetUserName();

        if (empty($userName))
        {
            $errors[] = "The user name cannot be blank.";
        }
        else
        {
            if (strlen($userName) > 32)
            {
                $errors[] = "The user name is too long.";
            }
        }

        $vInfo = new ValidationInfo($errors);

        return $vInfo;
    }

    /**
     * Validates the first name field.
     * @return \ValidationInfo The validitaion info.
     */
    protected function ValidateFirstName()
    {
        $errors = array();

        $firstName = $this->GetFirstName();

        if (empty($firstName))
        {
            $errors[] = "First name can't be blank.";
        }
        else
        {
            if (strlen($firstName) > 40)
            {
                $errors[] = "The first name is too long.";
            }
        }

        $vInfo = new ValidationInfo($errors);

        return $vInfo;
    }

    /**
     * Validates the last name field.
     * @return \ValidationInfo The validation info.
     */
    protected function ValidateLastName()
    {
        $errors = array();

        $lastName = $this->GetLastName();

        if (empty($lastName))
        {
            $errors[] = "Last name can't be blank.";
        }
        else
        {
            if (strlen($lastName) > 40)
            {
                $errors[] = "The last name is too long.";
            }
        }

        $vInfo = new ValidationInfo($errors);

        return $vInfo;
    }

    /**
     * Validates the email field.
     * @return \ValidationInfo The validation info.
     */
    protected function ValidateEmail()
    {
        $errors = array();

        $email = $this->GetEmail();

        if (empty($email))
        {
            $errors[] = "Email can't be blank.";
        }
        else
        {
            $helper = new Helper();
            $validEmailPattern = $helper->GetValidEmailPattern();

            if (!preg_match($validEmailPattern, $email))
            {
                $errors[] = "The email address \"" . $email . "\" is not valid.";
            }

            if (strlen($email) > 100)
            {
                $errors[] = "The email is too long.";
            }
        }

        $vInfo = new ValidationInfo($errors);

        return $vInfo;
    }
    
    /**
     * Validates the user password.
     * @return \ValidationInfo The validation information.
     */
    protected function ValidatePassword()
    {
        $errors = array();
        
        if ($this->IsPasswordSet())
        {
            $password = $this->GetPassword();
            $passwordRetype = $this->GetPasswordReType();

            if (empty($password))
            {
                $errors[] = "The password cannot be blank.";
            }
            else
            {
                if (strlen($password) > 40)
                {
                    $errors[]= "The password is too long.";
                }
            }

            if ($password != $passwordRetype)
            {
                $errors[] = "The retyped password does not match the original password.";
            }
        }
        
        $vInfo = new ValidationInfo($errors);
        
        return $vInfo;
    }

    /**
     * Validates all fields of the contact.
     * @return \ValidationInfo The validation info.
     */
    public function Validate()
    {
        $vInfo = new ValidationInfo();

        $vInfo->Merge($this->ValidateUserName());
        $vInfo->Merge($this->ValidateFirstName());
        $vInfo->Merge($this->ValidateLastName());
        $vInfo->Merge($this->ValidateEmail());
        $vInfo->Merge($this->ValidatePassword());
        
        return $vInfo;
    }
}
?>
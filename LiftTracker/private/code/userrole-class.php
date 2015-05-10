<?php

/**
 * The user role class.
 */
class UserRole
{
    /**
     * The user I.D.
     * @var int
     */
    private $userId;
    
    /**
     * The role I.D.
     * @var int
     */
    private $roleId;
    
    /**
     * Gets the user I.D.
     * @return int The user I.D.
     */
    public function GetUserId()
    {
        return $this->userId;
    }
    
    /**
     * Sets the user I.D.
     * @param int $userId The user I.D.
     */
    public function SetUserId($userId)
    {
        $this->userId = $userId;
    }
    
    /**
     * Gets the role I.D.
     * @return int The role I.D.
     */
    public function GetRoleId()
    {
        return $this->roleId;
    }
    
    /**
     * Sets the role I.D.
     * @param int $roleId The role I.D.
     */
    public  function SetRoleId($roleId)
    {
        $this->roleId = $roleId;
    }
    
    /**
     * Creates an instance of a user role.
     */
    public function UserRole()
    {
        $this->SetUserId(0);
        $this->SetRoleId(0);
    }
    
    /**
     * Initializes the user role.
     * @param array $row The user role row.
     */
    public function Initialize($row)
    {
        $userIdIdentifier = $this->GetUserIdIdentifier();
        $roleIdIdentifier = $this->GetRoleIdIdentifier();
        
        if (isset($row[$userIdIdentifier]))
        {
            $userId = $row[$userIdIdentifier];
            
            $this->SetUserId($userId);
        }
        
        if (isset($row[$roleIdIdentifier]))
        {
            $roleId = $row[$roleIdIdentifier];
            
            $this->SetRoleId($roleId);
        }
    }

    /**
     * Gets the users roles identifier.
     * @return string The identifier.
     */
    public function GetIdentifier()
    {
        return "userrole";
    }
    
    /**
     * Gets the user I.D. identifier.
     * @return string The identifier.
     */
    public function GetUserIdIdentifier()
    {
        return "UserId";
    }
    
    /**
     * Gets the role I.D. identifier.
     * @return string
     */
    public function GetRoleIdIdentifier()
    {
        return "RoleId";
    }
}

?>
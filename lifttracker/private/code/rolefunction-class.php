<?php

/**
 * The role function class.
 */
class RoleFunction
{
    /**
     * The role I.D.
     * @var int
     */
    private $roleId;
    
    /**
     * The function I.D.
     * @var int
     */
    private $functionId;
    
    /**
     * Gets the role I.D.
     * @return int The I.D.
     */
    public function GetRoleId()
    {
        return $this->roleId;
    }
    
    /**
     * Sets the role I.D.
     * @param int $roleId The I.D.
     */
    public function SetRoleId($roleId)
    {
        $this->roleId = $roleId;
    }
    
    /**
     * Gets the function I.D.
     * @return int The I.D.
     */
    public function GetFunctionId()
    {
        return $this->functionId;
    }
    
    /**
     * Sets the function I.D.
     * @param int $functionId The I.D.
     */
    public function SetFunctionId($functionId)
    {
        $this->functionId = $functionId;
    }
    
    /**
     * Creates an instance of the role function class.
     */
    public function RoleFunction()
    {
        $this->SetRoleId(0);
        $this->SetFunctionId(0);
    }
    
    /**
     * Initializes the role function.
     * @param array $row The row of data.
     */
    public function Initialize($row)
    {
        $roleIdIdentifier = $this->GetRoleIdIdentifier();
        $functionIdIdentifier = $this->GetFunctionIdIdentifier();
        
        if (isset($row[$roleIdIdentifier]))
        {
            $roleId = $row[$roleIdIdentifier];
            
            $this->SetRoleId($roleId);
        }
        
        if (isset($row[$functionIdIdentifier]))
        {
            $functionId = $row[$functionIdIdentifier];
            
            $this->SetFunctionId($functionId);
        }
    }
    
    /**
     * Gets the role function identifier.
     * @return string The identifier.
     */
    public function GetIdentifier()
    {
        return "rolefunction";
    }

    /**
     * Gets the role I.D. identifier.
     * @return string The identifier.
     */
    public function GetRoleIdIdentifier()
    {
        return "RoleId";
    }
    
    /**
     * Gets the functon I.D. identifier.
     * @return string The identifier.
     */
    public function GetFunctionIdIdentifier()
    {
        return "FunctionId";
    }
}

?>
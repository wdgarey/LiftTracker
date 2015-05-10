<?php

/**
 * A user role
 */
class Role
{
    /**
     * The I.D.
     * @var int 
     */
    private $id;

    /**
     * The name.
     * @var string 
     */
    private $name;
    
    /**
     * Gets the I.D.
     * @return int The I.D.
     */
    public function GetId()
    {
        return $this->id;
    }
    
    /**
     * Sets the I.D.
     * @param int $id The I.D.
     */
    public function SetId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Gets the name.
     * @return string The name.
     */
    public function GetName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name.
     * @param string $name The name.
     */
    public function SetName($name)
    {
        $this->name = $name;
    }

    /**
     * Creates an instance of a role.
     */
    public function Role()
    {
        $this->SetId(0);
        $this->SetName("");
    }
    /**
     * Gets the roles identifier.
     * @return string The identifier.
     */
    public function GetIdentifier()
    {
        return "role";
    }

    /**
     * Gets the role I.D. identifier.
     * @return string The identifier.
     */
    public function GetIdIdentifier()
    {
        return "RoleId";
    }

    /**
     * Gets the identifier of the name attribute.
     * @return string The identifier.
     */
    public function GetNameIdentifier()
    {
        return "Name";
    }
}

?>
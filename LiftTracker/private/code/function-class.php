<?php

/**
 * The function class.
 */
class Func
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
     * Creates an instance of a function.
     */
    public function Func()
    {
        $this->SetId(0);
        $this->SetName("");
    }
    
    /**
     * Initializes the function.
     * @param array $row The row of data.
     */
    public function Initialize($row)
    {
        $idIdentifier = $this->GetIdIdentifier();
        $nameIdentifier = $this->GetNameIdentifier();
        
        if (isset($row[$idIdentifier]))
        {
            $id = $row[$idIdentifier];
            
            $this->SetId($id);
        }
        
        if (isset($row[$nameIdentifier]))
        {
            $name = $row[$nameIdentifier];
            
            $this->SetName($name);
        }
    }
    
    /**
     * Gets the function identifier.
     * @return string The identifier.
     */
    public function GetIdentifier()
    {
        return "function";
    }

    /**
     * Gets the function I.D. identifier.
     * @return string The identifier.
     */
    public function GetIdIdentifier()
    {
        return "FunctionId";
    }

    /**
     * Get the function name identifier.
     * @return string The identifier.
     */
    public function GetNameIdentifier()
    {
        return "FunctionName";
    }
}

?>
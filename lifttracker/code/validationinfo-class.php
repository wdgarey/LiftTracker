<?php

/**
 * Holds information about a validation.
 */
class ValidationInfo
{
    /**
     * The collection of errors that were recorded.
     * @var array 
     */
    private $errors;
    
    /**
     * Gets errors data member.
     * @return array The collection of recorded errors.
     */
    public function GetErrors()
    {
        return $this->errors;
    }
    
    /**
     * Sets the errors data member.
     * @param array $errors The collection of recorded errors.
     */
    public function SetErrors($errors)
    {
        $this->errors = $errors;
    }
    
    /**
     * Creates an instance of ValidationInfo.
     * @param array $errors A collection of string errors.
     */
    public function ValidationInfo($errors = array())
    {
        $this->SetErrors($errors);
    }
    
    /**
     * Indicates whether or not the there are errors.
     * @return boolean True if valid, or false otherwise.
     */
    public function IsValid()
    {
        $errors = $this->GetErrors();
        $valid = (count($errors) == 0);
        
        return $valid;
    }
    
    /**
     * Merges this validation info with another.
     * @param ValidationInfo $vi The other validation info.
     */
    public function Merge(ValidationInfo $vi)
    {
        $errors = array_merge($this->GetErrors(), $vi->GetErrors());
        
        $this->SetErrors($errors);
    }
}
?>
<?php
/**
 * An object containing the file paths.
 */
class Paths
{
    /**
     * Creates an instance of the paths class.
     */
    public function Paths()
    { }

    /**
    * Gets the file path of the public directory.
    * @return string The directory.
    */
    public function GetPublicDir()
    {
       return "../public/";
    }

    /**
     * Gets the main index file path.
     * @return string The file path.
     */
    public function GetIndexFile()
    {
        return $this->GetPublicDir() . "index.php";
    }

    /**
    * Gets the file path of the private directory.
    * @return string The directory.
    */
    public function GetPrivateDir()
    {
       return "../private/";
    }

    /**
     * Gets the file path of the code directory.
     * @return string The directory.
     */
    public function GetCodeDir()
    {
        return $this->GetPrivateDir() . "code/";
    }

    /**
     * Gets and returns the file path of the helper class file.
     * @return string The file path.
     */
    public function GetHelperClassFile()
    {
        return $this->GetCodeDir() . "helper-class.php";
    }
    
    /**
     * Gets and returns the file path of the role function class file.
     * @return string The file path.
     */
    public function GetRoleFunctionClassFile()
    {
        return $this->GetCodeDir() . "rolefunction-class.php";
    }
    
    /**
     * Gets and returns the user role class file.
     * @return string The file path.
     */
    public function GetUserRoleClassFile()
    {
        return $this->GetCodeDir() . "userrole-class.php";
    }
    
    /**
     * Gets the function class file.
     * @return string The file path.
     */
    public function GetFunctionClassFile()
    {
        return $this->GetCodeDir() . "function-class.php";
    }
    
    /**
     * Gets and returns the role class file path.
     * @return string The file path.
     */
    public function GetRoleClassFile()
    {
        return $this->GetCodeDir() . "role-class.php";
    }

    /**
     * Gets and returns the file path of the user file.
     * @return string The file path.
     */
    public function GetUserClassFile()
    {
        return $this->GetCodeDir() . "user-class.php";
    }

    /**
     * Gets and returns the file path of the validiation info class file.
     * @return string The file path.
     */
    public function GetValidationInfoClassFile()
    {
        return $this->GetCodeDir() . "validationinfo-class.php";
    }

    /**
     * Gets and returns the file path of the controller directory.
     * @return string The file path.
     */
    public function GetControllerDir()
    {
        return $this->GetPrivateDir() . "controller/";
    }

    /**
     * Gets and returns the file path of the base controller file.
     * @return string The file path.
     */
    public function GetControllerClassFile()
    {
        return $this->GetControllerDir() . "controller-class.php";
    }

    /**
    * Gets the file path of the css directory.
    * @return string The directory.
    */
    public function GetCssDir()
    {
       return $this->GetPrivateDir() . "css/";
    }

    /**
     * Gets the file path of the main CSS file.
     * @return string The file path.
     */
    public function GetCssFile()
    {
        return $this->GetCssDir() . "stylesheet.css";
    }

    /**
     * Gets the file path of the navbar CSS file.
     * @return string The file path.
     */
    public function GetNavbarCssFile()
    {
        return $this->GetCssDir() . "navbar.css";
    }

    /**
     * Gets the file path of the bootstrap CSS file.
     * @return string The file path.
     */
    public function GetBootstrapCssFile()
    {
        return $this->GetCssDir() . "bootstrap.min.css";
    }

    /**
    * Gets the file path of the includes directory.
    * @return string The directory.
    */
    public function GetIncludesDir()
    {
       return $this->GetPrivateDir() . "includes/";
    }

    /**
     * Gets the file path of the footer file.
     * @return string The file path.
     */
    public function GetFooterIncludeFile()
    {
        return $this->GetIncludesDir() . "footer-include.php";
    }

    /**
     * Gets the file path of the header file.
     * @return string The file path.
     */
    public function GetHeaderIncludeFile()
    {
        return $this->GetIncludesDir() . "header-include.php";
    }

    /**
     * Gets the file path of the message content file.
     * @return string The file path.
     */
    public function GetMessageIncludeFile()
    {
        return $this->GetIncludesDir() . "message-include.php";
    }

    /**
     * Gets the file path of the navbar content file.
     * @return string The file path.
     */
    public function GetNavbarIncludeFile()
    {
        return $this->GetIncludesDir() . "navbar-include.php";
    }

    /**
     * Gets the file path of the definitions directory.
     * @return string the Directory.
     */
    public function GetDefinitionsDir()
    {
        return $this->GetPrivateDir() . "definitions/";
    }

    /**
     * Gets the base actions file path.
     * @return string The file path.
     */
    public function GetActionsClassFile()
    {
        return $this->GetDefinitionsDir() . "actions-class.php";
    }

    /**
     * Gets the base identifiers file path.
     * @return string The file path.
     */
    public function GetIdentifiersClassFile()
    {
        return $this->GetDefinitionsDir() . "identifiers-class.php";
    }

    /**
     * Gets the base paths file path.
     * @return string The file path.
     */
    public function GetPathsClassFile()
    {
        return $this->GetDefinitionsDir() . "paths-class.php";
    }

    /**
     * The file path of the image directory.
     * @return string The directory.
     */
    public function GetImageDir()
    {
        return $this->GetPrivateDir() . "images/";
    }

    /**
     * Gets the file path of the icon file.
     * @return string The file path.
     */
    public function GetIconFile()
    {
        return $this->GetImageDir() . "Ah_icon.ico";
    }

    /**
     * Gets the file path of the logo file.
     * @return string The file path.
     */
    public function GetLogoFile()
    {
        return $this->GetImageDir() . "logo.png";
    }

    /**
    * Gets the file path of the javascript directory.
    * @return string The directory.
    */
    public function GetJavascriptDir()
    {
       return $this->GetPrivateDir() . "js/";
    }

    /**
     * Gets the file path of the bootstrap javascript file.
     * @return string The file path.
     */
    public function GetBootstrapJSFile()
    {
        return $this->GetJavascriptDir() . "bootstrap.min.js";
    }

    /**
     * Gets the file path of the JQuery file.
     * @return string The file path.
     */
    public function GetJQueryFile()
    {
        return $this->GetJavascriptDir() . "jquery-1.9.1.min.js";
    }

    /**
     * Gets the file path of the JQuery table sorter file.
     * @return string The file path.
     */
    public function GetJQueryTableSorterFile()
    {
        return $this->GetJavascriptDir() . "jquery.tablesorter.js";
    }

    /**
     * Gets the file path of the JQuery validate file.
     * @return string The file path.
     */
    public function GetJQueryValidateFile()
    {
        return $this->GetJavascriptDir() . "jquery.validate.js";
    }

    /**
     * Gets the main javascript file.
     * @return string The file path.
     */
    public function GetJSFile()
    {
        return $this->GetJavascriptDir() . "javascript.js";
    }

    /**
     * Gets the file path of the navbar javascript file.
     * @return string The file path.
     */
    public function GetNavbarJSFile()
    {
        return $this->GetJavascriptDir() . "navbar.js";
    }

    /**
     * Gets the file path of the model directory.
     * @return string The directory.
     */
    public function GetModelDir()
    {
        return $this->GetPrivateDir() . "model/";
    }

    /**
     * Gets the file path of the base model file.
     * @return string The file path.
     */
    public function GetModelClassFile()
    {
        return $this->GetModelDir() . "model-class.php";
    }

    /**
     * Gets the file path of the view directory.
     * @return string The directory.
     */
    public function GetViewDir()
    {
        return $this->GetPrivateDir() . "view/";
    }

    /**
     * Gets the file path of the home form file.
     * @return string The file path.
     */
    public function GetHomeFormFile()
    {
        return $this->GetViewDir() . "home-form.php";
    }

    /**
     * Gets the file path of the login form file.
     * @return string The file path.
     */
    public function GetLoginFormFile()
    {
        return $this->GetViewDir() . "login-form.php";
    }

    /**
     * Gets the file path of the message form file.
     * @return string The file path.
     */
    public function GetMessageFormFile()
    {
        return $this->GetViewDir() . "message-form.php";
    }

    /**
     * Gets the file path of the sign up form file.
     * @return string The file path.
     */
    public function GetSelfAddEditFormFile()
    {
        return $this->GetViewDir() . "selfaddedit-form.php";
    }
    
    /**
     * Gets the file path of the self view form.
     * @return string The file path.
     */
    public function GetSelfViewFormFile()
    {
        return $this->GetViewDir() . "selfview-form.php";
    }
}
?>
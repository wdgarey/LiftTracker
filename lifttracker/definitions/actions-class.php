<?php
    /**
     * The class containing controller actions.
     */
    class Actions
    {
        /**
         * Creats an instance of the base actions class.
         */
        public function Actions()
        { }
        
        /**
         * Gets the action key word.
         * @return string The key word.
         */
        public function GetActionKeyWord()
        {
            return "action";
        }

        /**
         * Gets the home action word.
         * @return string The action word.
         */
        public function GetHomeAction()
        {
            return "Home";
        }
        
        /**
         * Gets the login action word.
         * @return string The action word.
         */
        public function GetLoginAction()
        {
            return "Login";
        }

        /**
         * Gets the logout action word.
         * @return string The action word.
         */
        public function GetLogoutAction()
        {
            return "Logout";
        }
        
        /**
         * Gets the process login action word.
         * @return string The action word.
         */
        public function GetProcessLoginAction()
        {
            return "ProcessLogin";
        }
        
        /**
         * Gets the user search action word.
         * @return string The action word.
         */
        public function GetUserSearchAction()
        {
            return "UserSearch";
        }

        /**
         * Gets the control panel action word.
         * @return string The action word.
         */
        public function GetControlPanelAction()
        {
            return "ControlPanel";
        }
        
        /**
         * Gets and returns the self add action word.
         * @return string The action word.
         */
        public function GetSelfAddAction()
        {
            return "SelfAdd";
        }
        
        /**
         * Gets and returns the self edit action word.
         * @return string The action word.
         */
        public function GetSelfEditAction()
        {
            return "SelfEdit";
        }
        
        /**
         * Gets and returns the process self add edit action.
         * @return string The action word.
         */
        public function GetProcessSelfAddEditAction()
        {
            return "ProcessSelfAddEdit";
        }
        
        /**
         * Gets and returns the self view action word.
         * @return string The action word.
         */
        public function GetSelfViewAction()
        {
            return "SelfView";
        }

        /**
         * Gets the manage users action word.
         * @return string The action word.
         */
        public function GetManageUsersAction()
        {
            return "ManageUsers";
        }

        /**
         * Gets the add edit user action word.
         * @return string The action word.
         */
        public function GetUserAddEditAction()
        {
            return "UserAddEdit";
        }

        /**
         * Gets the user delete action word.
         * @return string The action word.
         */
        public function GetUserDeleteAction()
        {
            return "UserDelete";
        }

        /**
         * Gets the user view action word.
         * @return string Tha action word.
         */
        public function GetUserViewAction()
        {
            return "UserView";
        }

        /**
         * Gets the process user add action word.
         * @return string The action word.
         */
        public function GetProcessUserAddEditAction()
        {
            return "ProcessUserAddEdit";
        }

        /**
         * Gets the manage roles action word.
         * @return string The action word.
         */
        public function GetManageRolesAction()
        {
            return "ManageRoles";
        }

        /**
         * Gets the role add action word.
         * @return string The action word.
         */
        public function GetRoleAddAction()
        {
            return "RoleAdd";
        }

        /**
         * Gets the role edit action word.
         * @return string The action word.
         */
        public function GetRoleEditAction()
        {
            return "RoleEdit";
        }

        /**
         * Gets the role delete action word.
         * @return string The action word.
         */
        public function GetRoleDeleteAction()
        {
            return "RoleDelete";
        }

        /**
         * Gets the process role add/edit action word.
         * @return string The action word.
         */
        public function GetProcessRoleAddEditAction()
        {
            return "ProcessRoleAddEdit";
        }
    }
?>
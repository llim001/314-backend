<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class UserModel extends Database
{
    public function getUsers()
    {
        return $this->select("SELECT username,password,role,email,phone FROM userinfo ORDER BY ROLE,USERNAME ASC");
    }

    public function getUserByUsernamePassword($usernameInput, $passwordInput)
    {
        return $this->select("SELECT username,role,email,phone FROM userinfo WHERE username = ? AND password = ? LIMIT 1", ["ss", [$usernameInput, $passwordInput]]);
    }

    public function getUserByUsername($usernameInput)
    {
        //return $this->select("SELECT username,role,email,phone FROM userinfo WHERE username = ? ", ["s", $usernameInput]);
		return $this->select("SELECT username,role,email,phone FROM userinfo WHERE username = '$usernameInput'");
    }

	
	//get users by role Admin
	public function getListOfUsersByRole($role)
    {
		return $this->select("SELECT username,password,role,email,phone FROM userinfo WHERE role = '$role' ORDER BY USERNAME");
    }
	
	public function getAllPatients()
    {
		return $this->select("SELECT * FROM userinfo WHERE role = 'patient' ORDER BY USERNAME");
    }
	
}
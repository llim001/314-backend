<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class UserModelOld extends Database
{
    public function getUsers($limit)
    {
        return $this->select("SELECT * FROM userinfo");
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

    public function getPrescriptionByUsername($usernameInput)
    {
        //return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE username = ? ", ["s", $usernameInput]);
		return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE username = '$usernameInput'");
    }
}
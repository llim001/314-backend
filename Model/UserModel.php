<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class UserModel extends Database
{
    public function getUsers()
    {
        return $this->select("SELECT username,password,role,email,phone FROM userinfo");
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
	
	//view prescription User
    public function getPrescriptionByUsername($usernameInput)
    {
        //return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE username = ? ", ["s", $usernameInput]);
		return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE username = '$usernameInput'");
    }

	//view prescription Doctor
	public function getPrescriptionByDoctorUsername($usernameInput)
    {
        //return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE Doctor_Username = ? ", ["s", $usernameInput]);
		return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE Doctor_Username = '$usernameInput'");
    }
	
	//view prescription pharmacist/Token
	public function getPrescriptionByToken($token)
    {
		return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE Token = '$token'");
    }

    //Display prescription by Token (Patients)
	public function displayPrescriptionByToken($token, $usernameInput)
    {
		return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE Token = '$token' AND username = '$usernameInput'");
    }
	
	//view prescription Doctor and patient
	public function getPrescriptionByDoctorAndUsername($doctorUsername,$usernameInput)
    {
		return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE Doctor_Username = '$doctorUsername' AND username = '$usernameInput'");
    }
	
	//get users by role Admin
	public function getListOfUsersByRole($role)
    {
		return $this->select("SELECT username,password,role,email,phone FROM userinfo WHERE role = '$role'");
    }
	
	public function getAllPatients()
    {
		return $this->select("SELECT * FROM userinfo WHERE role = 'patient'");
    }
	
	//for token genration???
	public function getMAXPK()
	{
		return $this->select("SELECT MAX(PK) FROM PRESCRIPTION");
	}
	
	//add prescription Doctor
	public function addPrescription($token, $doctorUsername, $usernameInput, $medicine, $dosage)
	{
		$dtnow = date('Y-m-d H:i:s');
		return $this->select("INSERT INTO prescription(Token, Doctor_Username, Username, Medicine , Dosage, Date_Issued) VALUES ('$token', '$doctorUsername', '$usernameInput', '$medicine', '$dosage', '$dtnow'");
	}
	
	//update prescription Pharmacist
	public function updatePrescription($token)
	{
		$dtnow = date('Y-m-d H:i:s');
		return $this->select("UPDATE prescription SET Date_Dispense = '$dtnow', status = '1' where Token = '$token'");
	}
	
}
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
	
	//view prescription User
    public function getPrescriptionByUsername($usernameInput)
    {
        //return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE username = ? ", ["s", $usernameInput]);
		return $this->select("SELECT token,doctor_username,medicine,dosage,DATE_FORMAT(date_issued,'%d %b %Y')as date, date_dispense FROM prescription WHERE username = '$usernameInput' ORDER BY DATE,TOKEN,MEDICINE ASC");
    }

	//view prescription Doctor
	public function getPatientsPrescription($usernameInput)
    {
        //return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE Doctor_Username = ? ", ["s", $usernameInput]);
		return $this->select("SELECT username,medicine,dosage,DATE_FORMAT(date_issued,'%d %b %Y')as date,token FROM prescription WHERE Doctor_Username = '$usernameInput' ORDER BY USERNAME,MEDICINE,DATE ASC");
    }

    public function getPatientsPrescriptionByPatientId($docUserInput, $patientUserInput)
    {
        //return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE Doctor_Username = ? ", ["s", $usernameInput]);
		return $this->select("SELECT username,medicine,dosage,DATE_FORMAT(date_issued,'%d %b %Y')as date, token FROM prescription WHERE Doctor_Username = '$docUserInput' AND username = '$patientUserInput'ORDER BY DATE,MEDICINE ASC");
    }
	
	//view prescription pharmacist/Token
	public function getPrescriptionByToken($token)
    {
		//return $this->select("SELECT token,doctor_username,medicine,dosage,DATE_FORMAT(date_issued,'%d %b %Y')as date FROM prescription WHERE Token = '$token' ORDER BY DATE,TOKEN,MEDICINE ASC");
		return $this->select("SELECT token,doctor_username,medicine,dosage,DATE_FORMAT(date_issued,'%d %b %Y')as date FROM prescription WHERE Token = '$token' ORDER BY DATE,TOKEN,MEDICINE ASC");
    }

    //Display prescription by Token (Patients)
	public function displayPrescriptionByToken($token, $usernameInput)
    {
		return $this->select("SELECT token,doctor_username,medicine,dosage,DATE_FORMAT(date_issued,'%d %b %Y')as date FROM prescription WHERE Token = '$token' AND username = '$usernameInput' ORDER BY DATE,TOKEN,MEDICINE ASC");
    }
	
	//view prescription Doctor and patient
	public function getPrescriptionByDoctorAndUsername($doctorUsername,$usernameInput)
    {
		return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE Doctor_Username = '$doctorUsername' AND username = '$usernameInput' ORDER BY DATE,TOKEN,MEDICINE ASC");
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
	
	//for token genration???
	public function getMAXPK()
	{
		return $this->select("SELECT MAX(PK) FROM PRESCRIPTION");
	}
	
	//add prescription Doctor
	public function addPrescription($token, $doctorUsername, $usernameInput, $medicine, $dosage)
	{
		$dtnow = date('Y-m-d H:i:s');
		return $this->insert("INSERT INTO prescription(Token, Doctor_Username, Username, Medicine , Dosage, Date_Issued) VALUES ('$token', '$doctorUsername', '$usernameInput', '$medicine', '$dosage', '$dtnow')");
	}
	
	//update prescription Pharmacist
	public function updatePrescription($token)
	{
		$dtnow = date('Y-m-d H:i:s');
		return $this->select("UPDATE prescription SET Date_Dispense = '$dtnow', status = '1' where Token = '$token'");
	}
	

	//add user Admin
	public function addUser($username, $password, $role, $email, $phone)
	{
		return $this->insert("INSERT INTO userinfo(username, password, role, email , phone) VALUES ('$username', '$password', '$role', '$email', '$phone')");
	}
}
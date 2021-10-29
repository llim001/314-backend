<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class PrescriptionModel extends Database
{
    //view prescription User
    public function getPrescriptionByUsername($usernameInput)
    {
        //return $this->select("SELECT token,doctor_username,medicine,dosage,date_issued FROM prescription WHERE username = ? ", ["s", $usernameInput]);
        return $this->select("SELECT token,doctor_username,medicine,dosage,DATE_FORMAT(date_issued,'%d %b %Y')as date FROM prescription WHERE username = '$usernameInput' ORDER BY DATE,TOKEN,MEDICINE ASC");
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
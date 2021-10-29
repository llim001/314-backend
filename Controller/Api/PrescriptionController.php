<?php
class PrescriptionController extends BaseController
{

    /**
     * "/prescription/user" Endpoint - Get list of prescription data by name
     */
    public function userAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try
            {
                $prescriptionModel = new PrescriptionModel();

                $inputUsername = '';
                if (isset($arrQueryStringParams['username']) && $arrQueryStringParams['username']) {
                    $inputUsername = $arrQueryStringParams['username'];

                }

                $arrPrescriptions = $prescriptionModel->getPrescriptionByUsername($inputUsername);
                $responseData = json_encode($arrPrescriptions);
            }
            catch (Error $e)
            {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    /*
    "/prescription/token" Search prescription by Token function (Patients)
    */
    public function tokenAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try
            {
                $prescriptionModel = new PrescriptionModel();

                $inputUsername = '';
                $token = '';
                if (isset($arrQueryStringParams['username']) && $arrQueryStringParams['username']) {
                    if (isset($arrQueryStringParams['token']) && $arrQueryStringParams['token']) {
                        $inputUsername = $arrQueryStringParams['username'];
                        $token = $arrQueryStringParams['token'];
                    }
                }

                $arrPrescriptions = $prescriptionModel->displayPrescriptionByToken($token, $inputUsername);
                $responseData = json_encode($arrPrescriptions);
            }
            catch (Error $e)
            {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    /**
     * "/prescription/doctor" Get Patient Prescription given by specific doctor (Doctor) *
     */
    public function doctorAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try
            {
                $prescriptionModel = new PrescriptionModel();

                $doctorUsername = '';
                if (isset($arrQueryStringParams['doctorusername']) && $arrQueryStringParams['doctorusername']) {
                    $doctorUsername = $arrQueryStringParams['doctorusername'];

                }

                $arrPrescriptions = $prescriptionModel->getPatientsPrescription($doctorUsername);
                $responseData = json_encode($arrPrescriptions);
            }
            catch (Error $e)
            {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }


    /**
     * "/prescription/searchPatientPrescriptionByDoctor" - Search Patient Prescription given by specific doctor by Patient ID (Doctor) *
     */
    public function searchPatientPrescriptionByDoctorAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try
            {
                $prescriptionModel = new PrescriptionModel();

                $doctorUsername = '';
                if (isset($arrQueryStringParams['doctorusername']) && $arrQueryStringParams['doctorusername']) {
                    if (isset($arrQueryStringParams['patientusername']) && $arrQueryStringParams['patientusername']) {
                        $doctorUsername = $arrQueryStringParams['doctorusername'];
                        $patientUsername = $arrQueryStringParams['patientusername'];
                    }

                }

                $arrPrescriptions = $prescriptionModel->getPatientsPrescriptionByPatientId($doctorUsername, $patientUsername);
                $responseData = json_encode($arrPrescriptions);
            }
            catch (Error $e)
            {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}
<?php
class UserController extends BaseController
{
    /**
     * "/user/list" Endpoint - Get list of users
     */
    public function listAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
 
        if (strtoupper($requestMethod) == 'GET') {
            try 
            {
                $userModel = new UserModel();
 
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
 
                $arrUsers = $userModel->getUsers($intLimit);
                $responseData = json_encode($arrUsers);
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


    public function searchUsersByRoleAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try 
            {
                $userModel = new UserModel();
                
                $inputRole = '';
                if (isset($arrQueryStringParams['role']) && $arrQueryStringParams['role']) {
                    $inputRole = $arrQueryStringParams['role'];
                }
                $arrUsers = $userModel->getListOfUsersByRole($inputRole);
                $responseData = json_encode($arrUsers);
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


    public function loginAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        // $arrQueryStringParams = $this->getQueryStringParams();
 
        if (strtoupper($requestMethod) == 'POST') {
            try 
            {
                $userModel = new UserModel();

                if ((isset($_POST["username"]) && $_POST["username"]) && (isset($_POST["password"]) && $_POST["password"])) {
                    $username = $_POST["username"];
                    $password = $_POST["password"];
                    $userObj = $userModel->getUserByUsernamePassword($username, $password);

                    if ($userObj) {
                        $responseData = json_encode($userObj);
                    } else {
                        $strErrorDesc = 'Incorrect username or password';
                        $strErrorHeader = 'HTTP/1.1 401 Forbidden'; 
                    }
                    
                } else {
                    $strErrorDesc = 'Missing parameters';
                    $strErrorHeader = 'HTTP/1.1 400 Bad Request'; 
                }
 
               
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
     * "/user/name" Endpoint - Get list of user data by name
     */
    public function nameAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try 
            {
                $userModel = new UserModel();
                
                $inputUsername = '';
                if (isset($arrQueryStringParams['un']) && $arrQueryStringParams['un']) {
                    $inputUsername = $arrQueryStringParams['un'];
                    
                }

                //$inputUsername = $arrQueryStringParams['un'];
                //echo $inputUsername;
                $arrUsers = $userModel->getUserByUsername($inputUsername);
                $responseData = json_encode($arrUsers);
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
     * "/user/prescription" Endpoint - Get list of prescription data by name
     */
    public function prescriptionAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try 
            {
                $userModel = new UserModel();
                
                $inputUsername = '';
                if (isset($arrQueryStringParams['username']) && $arrQueryStringParams['username']) {
                    $inputUsername = $arrQueryStringParams['username'];
                    
                }

                $arrPrescriptions = $userModel->getPrescriptionByUsername($inputUsername);
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

    /* Search prescription by Token function (Patients) */
    public function searchPrescriptionByTokenAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try 
            {
                $userModel = new UserModel();
                
                $inputUsername = '';
                $token = '';
                if (isset($arrQueryStringParams['username']) && $arrQueryStringParams['username']) {
                    if (isset($arrQueryStringParams['token']) && $arrQueryStringParams['token']) {
                        $inputUsername = $arrQueryStringParams['username'];
                        $token = $arrQueryStringParams['token'];
                    } 
                }

                $arrPrescriptions = $userModel->displayPrescriptionByToken($token, $inputUsername);
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

    /** Get Patient Prescription given by specific doctor (Doctor) **/
    public function patientPrescriptionAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try 
            {
                $userModel = new UserModel();
                
                $doctorUsername = '';
                if (isset($arrQueryStringParams['doctorusername']) && $arrQueryStringParams['doctorusername']) {
                    $doctorUsername = $arrQueryStringParams['doctorusername'];
                    
                }

                $arrPrescriptions = $userModel->getPatientsPrescription($doctorUsername);
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


    /** Search Patient Prescription given by specific doctor by Patient ID (Doctor) **/
    public function searchPatientPrescriptionAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try 
            {
                $userModel = new UserModel();
                
                $doctorUsername = '';
                if (isset($arrQueryStringParams['doctorusername']) && $arrQueryStringParams['doctorusername']) {
                    if (isset($arrQueryStringParams['patientusername']) && $arrQueryStringParams['patientusername']) {
                        $doctorUsername = $arrQueryStringParams['doctorusername'];
                        $patientUsername = $arrQueryStringParams['patientusername'];
                    }
                    
                }

                $arrPrescriptions = $userModel->getPatientsPrescriptionByPatientId($doctorUsername, $patientUsername);
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
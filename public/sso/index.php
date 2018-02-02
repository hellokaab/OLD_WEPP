<?php
/**
 *  SAML Handler
 */
ini_set('display_errors', 0);
$include = count(get_required_files())-1;

session_start();
include '../php/config.php';
require_once dirname(__FILE__).'/_toolkit_loader.php';
require_once dirname(__FILE__).'/settings.php';

$auth = new OneLogin_Saml2_Auth($sso_settings);

if(isset($_REQUEST['sso'])){
    // Request login to SSO

    $redirect = isset($_REQUEST['redirect'])? $_REQUEST['redirect']:$_SERVER['HTTP_REFERER'];
    $auth->login($redirect);

	die;
	
}else if(isset($_REQUEST['slo'])){
    // Request logout to SSO

    $redirect = isset($_REQUEST['redirect'])? $_REQUEST['redirect']:$baseUrl;
    $_SESSION['ssoUserdata'] = Null;
    $paramters = array();
    $nameId = null;
    $sessionIndex = null;
    if(isset($_SESSION['ssoNameId'])){
        $nameId = $_SESSION['ssoNameId'];
    }
    if(isset($_SESSION['ssoSessionIndex'])){
        $sessionIndex = $_SESSION['ssoSessionIndex'];
    }
	  $redirect = "http://ict.ea.rmuti.ac.th/sjet/";
    $auth->logout($redirect, $paramters, $nameId, $sessionIndex);

	die;

}else if(isset($_REQUEST['acs'])){
    // Login result from SSO

    $auth->processResponse();
    $errors = $auth->getErrors();

    if(!empty($errors)){
        print_r('<p>'.implode(', ', $errors).'</p>');
        exit();
    }
    if(!$auth->isAuthenticated()){
        echo "<p>Not authenticated</p>";
        exit();
    }

    $_SESSION['ssoUserdata'] = $auth->getAttributes();
    $_SESSION['ssoNameId'] = $auth->getNameId();
    $_SESSION['ssoSessionIndex'] = $auth->getSessionIndex();        

    // Sucessfully logged in
    // Begin of user codes ------------------

    foreach($_SESSION['ssoUserdata'] as $k=>$v){
        $_SESSION['_login_info'][$k] = $v[0];
    }
    $_SESSION['_logged_in'] = $_SESSION['_login_info']['uid'];

    // End of user codes --------------------

    if(isset($_POST['RelayState'])&& OneLogin_Saml2_Utils::getSelfURL()!= $_POST['RelayState']){
        //$auth->redirectTo($_POST['RelayState']);
        if(isset($_SESSION['ssoUserdata'])){
            if(!empty($_SESSION['ssoUserdata'])){
                $attributes = $_SESSION['ssoUserdata'];
                foreach($attributes as $attributeName => $attributeValues){
                    foreach($attributeValues as $attributeValue){
                        if (htmlentities($attributeName) == 'personalId'){
                            $userID = htmlentities($attributeValue);
                        }else if(htmlentities($attributeName) == 'prename'){
                            $prename = htmlentities($attributeValue);
                        }else if(htmlentities($attributeName) == 'firstNameThai'){
                            $firstNameThai = htmlentities($attributeValue);
                        }else if(htmlentities($attributeName) == 'lastNameThai'){
                            $lastNameThai = htmlentities($attributeValue);
                        }else if(htmlentities($attributeName) == 'mail'){
                            $mail = htmlentities($attributeValue);
                        }else if(htmlentities($attributeName) == 'programId'){
                            $programId = htmlentities($attributeValue);
                        }
                    }
                }
            }else{
                
            }
        }
        
        $sql = "SELECT COUNT(userID) as count FROM user WHERE userID = '$userID'";
        $qry = mysqli_query($connect, $sql);
        $result = mysqli_fetch_array($qry);
        $count = $result["count"];

        if($count == 0){
            if($prename == "นาย"){
                $prefixID = 1;
            }else if($prename == "นาง"){
                $prefixID = 2;
            }else if($prename == "นางสาว"){
                $prefixID = 3;
            }

            $firstName = $firstNameThai;
            $lastName = $lastNameThai;
            $phoneNumber = "---";
            $email = $mail;
            $positionID = 53;
            $programID = split("[0]", (string)($programId));

            $sql ="SELECT majorID FROM major WHERE programID = '$programID[0]'";
            $qry = mysqli_query($connect, $sql);
            $result = mysqli_fetch_array($qry);

            $majorID = $result["majorID"];
            $password = $userID;

            $sql = "INSERT INTO user (userID, prefixID, firstName, lastName, phoneNumber, email, majorID, password, status)
                    VALUES('$userID', '$prefixID', '$firstName', '$lastName' , '$phoneNumber', '$email', $majorID, '$password', 'USER');";
            $qry = mysqli_query($connect, $sql);

            $sql = "INSERT INTO register_position (userID, positionID)
                    VALUES('$userID', '$positionID')";
            $qry = mysqli_query($connect, $sql);
            
            $_SESSION['userID'] = $userID;
            echo "<script>window.location.href = '../profile?chkProfile=1';</script>";
        }else if($count == 1){
            $_SESSION['userID'] = $userID;
            echo "<script>window.location.href = '../homepage';</script>";
        }
    }
    
    die;

}else if(isset($_REQUEST['sls'])){
    // Logout result from SSO

    $auth->processSLO();
    $errors = $auth->getErrors();
    if(empty($errors)){

        // Sucessfully logged out
        // Begin of user codes ------------------

        $_SESSION['_login_info'] = Null;
        $_SESSION['_logged_in'] = Null;

        // End of user codes --------------------

        $auth->redirectTo($_POST['RelayState']);
    }else{
        print_r('<p>'.implode(', ', $errors).'</p>');
    }
	
	die;
	
}
// If directory access to this file via browser, check entityId and replace with suggestion entityId.
if($include==0){
	if($_SERVER[REQUEST_URI]!=$_SERVER[SCRIPT_NAME]){
		$URI = $_SERVER[REQUEST_URI];
	}else{
		$URI = rtrim($_SERVER[REQUEST_URI], 'index.php');
	}

	$suggestEntityId = rtrim($_SERVER[HTTP_HOST].$URI, '/');
	$suggestEntityId = rtrim($suggestEntityId, 'sso');
	$suggestEntityId = rtrim($suggestEntityId, '/');
	
	if($suggestEntityId!=$sso_settings['sp']['entityId']){
		$f = file_get_contents(dirname(__FILE__).'/settings.php');
		$fs = explode("\n", $f);
		for($l=0; $l<count($fs); $l++){
			$f = trim($fs[$l]);
			if(substr($f, 0, 9)=="\$entityId"){
				$fs[$l] = preg_replace('/entityId.*/', "entityId = '$suggestEntityId';", $fs[$l]);
			}
		}
		file_put_contents(dirname(__FILE__).'/settings.php', implode("\n", $fs));
		$sso_settings['sp']['entityId'] = $suggestEntityId;
	}
}
?>
- <a href="?sso">Login</a> <i>(Url: <?php echo $REQUEST_SCHEME.'://'.$sso_settings['sp']['entityId']."/sso/?sso" ?>)</i><br/><br/>
- <a href="?slo">Logout</a> <i>(Url: <?php echo $REQUEST_SCHEME.'://'.$sso_settings['sp']['entityId']."/sso/?slo" ?>)</i><br/>

<?php
session_start();

require_once 'libraries/tfpdf/tfpdf.php';
require_once 'php/Functions.php';
require_once 'php/UserData.php';
require_once 'php/FormField.php';
require_once 'php/FormField_Text.php';
require_once 'php/FormField_Line.php';
require_once 'php/FormFiller.php';
require_once 'php/FormFiller_RejestracjaPojazdu.php';
require_once 'php/FormFiller_WydanieDokumentowSzkolnych.php';
require_once 'php/FormFiller_WycinkaDrzew.php';
require_once 'php/UserData.php';

require_once 'pages/LoginPage.php';
require_once 'pages/UserPage.php';
require_once 'pages/AdminPage.php';

UserData::Connect();

function testDatabaseConnection() {
    try {
        UserData::Connect();
        if (UserData::$PDO instanceof PDO) {
            return ['result' => 1, 'message' => "<p style='color: green;'>Database connection successful.</p>"];
        } else {
            return ['result' => 0, 'message' => "<p style='color: red;'>Database connection failed.</p>"];
        }
    } catch (Exception $e) {
        return ['result' => 0, 'message' => "<p style='color: red;'>Database connection error: " . $e->getMessage() . "</p>"];
    }
}

function testGetAllUsers() {
    try {
        $users = UserData::getAllUsers();
        if (is_array($users)) {
            return ['result' => 1, 'message' => "<p style='color: green;'>getAllUsers() returned an array.</p>"];
        } else {
            return ['result' => 0, 'message' => "<p style='color: red;'>getAllUsers() did not return an array.</p>"];
        }
    } catch (Exception $e) {
        return ['result' => 0, 'message' => "<p style='color: red;'>Error in getAllUsers(): " . $e->getMessage() . "</p>"];
    }
}

function testGrantAndCheckDocumentAccess() {
    try {
        // UserData::clearDocumentAccess();
        //UserData::grantDocumentAccess(2, 'rejestracja_pojazdu');
        $hasAccess = UserData::hasDocumentAccess(2, 'rejestracja_pojazdu');
        if ($hasAccess) {
            return ['result' => 1, 'message' => "<p style='color: green;'>Document access granted and verified.</p>"];
        } else {
            return ['result' => 0, 'message' => "<p style='color: red;'>Failed to grant or verify document access.</p>"];
        }
    } catch (Exception $e) {
        return ['result' => 0, 'message' => "<p style='color: red;'>Error in document access test: " . $e->getMessage() . "</p>"];
    }
}





function testAdminLogin() {
    try {
        $_POST['name'] = 'Kuba';
        $_POST['password'] = '1';
        UserData::Logout(false);
        $result = UserData::Login(false);
        if (!(isset($_SESSION['user_id']) && $_SESSION['user_role'] == 1)) {
            return ['result' => 0, 'message' => "<p style='color: red;'>Admin login failed.</p>"];
        }
        return ['result' => 1, 'message' => "<p style='color: green;'>Admin login successful.</p>"];
    } catch (Exception $e) {
        return ['result' => 0, 'message' => "<p style='color: red;'>Error in admin login test: " . $e->getMessage() . "</p>"];
    }
}

function testUserLogin() {
    try {
        $_POST['name'] = 'Adam';
        $_POST['password'] = '1';
        UserData::Logout(false);
        $result = UserData::Login(false);
        if (!(isset($_SESSION['user_id']) && $_SESSION['user_role'] == 2)) {
            return ['result' => 0, 'message' => "<p style='color: red;'>User login failed.</p>"];
        }
        return ['result' => 1, 'message' => "<p style='color: green;'>User login successful.</p>"];
    } catch (Exception $e) {
        return ['result' => 0, 'message' => "<p style='color: red;'>Error in user login test: " . $e->getMessage() . "</p>"];
    }
}

function testLogout() {
    try {
        $_SESSION['user_id'] = 1;
        $_SESSION['user_name'] = 'Kuba';
        $_SESSION['user_role'] = 1;
        $_GET['logout'] = true;
        UserData::Logout(false);
        if (isset($_SESSION['user_id'])==false) {
            return ['result' => 0, 'message' => "<p style='color: red;'>Logout failed.</p>"];
        }
        return ['result' => 1, 'message' => "<p style='color: green;'>Logout successful.</p>"];
    } catch (Exception $e) {
        return ['result' => 0, 'message' => "<p style='color: red;'>Error in logout test: " . $e->getMessage() . "</p>"];
    }
}





$testResults = [];
$testResults[] = testUserLogin();
$testResults[] = testLogout();
$testResults[] = testAdminLogin();

$testResults[] = testDatabaseConnection();
$testResults[] = testGetAllUsers();
$testResults[] = testGrantAndCheckDocumentAccess();

foreach ($testResults as $test) {
    echo $test['message'];
}

?>

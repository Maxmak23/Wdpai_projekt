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
$msg = UserData::Login();
UserData::Logout();

$documents = [
    'rejestracja_pojazdu' => new FormFiller_RejestracjaPojazdu(),
    'wydanie_dokumentow_szkolnych' => new FormFiller_WydanieDokumentowSzkolnych(),
    'wycinka_drzew' => new FormFiller_WycinkaDrzew(),
];

//$currentDoc = null;
//if (isset($_GET['doc']) && isset($documents[htmlspecialchars($_GET['doc'])])) {
//    $currentDoc = $documents[htmlspecialchars($_GET['doc'])];
//}
$currentDoc = null;
if(isset($_GET['doc']) && isset($documents[htmlspecialchars($_GET['doc'])])){ $currentDoc = $documents[htmlspecialchars($_GET['doc'])]; }

$page = null;

if (!isset($_SESSION['user_id'])) {
    // User is not logged in
    $page = new LoginPage('', $msg);
} else {
    // User is logged in
    if ($_SESSION['user_role'] == 2) {
        $page = new UserPage($documents, $currentDoc);
    } elseif ($_SESSION['user_role'] == 1) {
        $page = new AdminPage();
    }
}

if ($page) {
    $page->renderHeader();
    $page->renderContent();
    $page->renderFooter();
}
?>

<?php

class UserData
{
    public static $PDO;
    
    public function __construct(){}
    
    public static function Connect(){
        $host = 'localhost';
        $dbname = 'wypelniarka_dokumentow2';
        $username = 'root';
        $password = '';
        try {
            UserData::$PDO = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            UserData::$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function Login(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputName = $_POST['name'] ?? '';
            $inputPassword = $_POST['password'] ?? '';

            $stmt = UserData::$PDO->prepare("SELECT * FROM users WHERE name = ? AND password = ?");
            $stmt->execute([$inputName, $inputPassword]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid username or password.";
                return $error;
            }
        }
    }
    
    public static function Logout(){
        if (isset($_GET['logout'])) {
            session_destroy();
            header("Location: index.php");
            exit;
        }
    }


    public static function getAllUsers() {
        $stmt = UserData::$PDO->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function clearDocumentAccess() {
        UserData::$PDO->query("DELETE FROM user_documents_access");
    }

    public static function grantDocumentAccess($userId, $docKey) {
        $stmt = UserData::$PDO->prepare("INSERT INTO user_documents_access (user_id, document_key) VALUES (?, ?)");
        $stmt->execute([$userId, $docKey]);
    }

    public static function hasDocumentAccess($userId, $docKey) {
        $stmt = UserData::$PDO->prepare("SELECT * FROM user_documents_access WHERE user_id = ? AND document_key = ?");
        $stmt->execute([$userId, $docKey]);
        return $stmt->rowCount() > 0;
    }

    public static function getAccessibleDocuments($userId) {
        $stmt = UserData::$PDO->prepare("SELECT document_key FROM user_documents_access WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function SaveAllFormValues($formFiller, $Post = []) {
        if (!isset($_SESSION['user_id'])) { return; } //tylko dla zalogowanych

        $userID = $_SESSION['user_id'];
        foreach ($formFiller->fields as $Field) {
            $formKey = $Field->GetFieldKey();
            if (isset($Post[$formKey])) {
                $formName = $formFiller->name;
                $formValue = json_encode($Post[$formKey]);

                $stmt = UserData::$PDO->prepare("
                    SELECT 1 
                    FROM form_submissions 
                    WHERE userID = :userID AND formName = :formName AND formKey = :formKey
                ");
                $stmt->execute([
                    ':userID' => $userID,
                    ':formName' => $formName,
                    ':formKey' => $formKey
                ]);

                if ($stmt->rowCount() > 0) {
                    // Update
                    $updateStmt = UserData::$PDO->prepare("
                        UPDATE form_submissions
                        SET formValue = :formValue
                        WHERE userID = :userID AND formName = :formName AND formKey = :formKey
                    ");
                    $updateStmt->execute([
                        ':formValue' => $formValue,
                        ':userID' => $userID,
                        ':formName' => $formName,
                        ':formKey' => $formKey
                    ]);
                } else {
                    // Insert
                    $insertStmt = UserData::$PDO->prepare("
                        INSERT INTO form_submissions (userID, formName, formKey, formValue)
                        VALUES (:userID, :formName, :formKey, :formValue)
                    ");
                    $insertStmt->execute([
                        ':userID' => $userID,
                        ':formName' => $formName,
                        ':formKey' => $formKey,
                        ':formValue' => $formValue
                    ]);
                }
            }
        }
    }

    
    
    
}

?>

<?php
require_once 'Page.php';
require_once 'php/UserData.php';

class AdminPage extends Page {
    public function renderContent() {
        global $documents;
        global $currentDoc;

        if (isset($_POST['update_access'])) {
            $this->updateDocumentAccess($_POST);
        }

        $users = UserData::getAllUsers();
        $documentsKeys = ['rejestracja_pojazdu', 'wydanie_dokumentow_szkolnych', 'wycinka_drzew'];

        echo '<main>';
        echo '<h2>Panel administratora</h2>';
        echo '<form method="post">';

        echo '<table border="1">';
        echo '<tr><th>User</th>';
        foreach ($documentsKeys as $doc) {
            echo "<th>{$documents[$doc]->nicename}</th>";
        }
        echo '</tr>';

        foreach ($users as $user) {
            if($user['role']*1===2){
                echo '<tr>';
                echo '<td>' . htmlspecialchars($user['name']) . '</td>';
                foreach ($documentsKeys as $doc) {
                    $checked = UserData::hasDocumentAccess($user['id'], $doc) ? 'checked' : '';
                    echo "<td><input type='checkbox' name='access[{$user['id']}][{$doc}]' $checked></td>";
                }
                echo '</tr>';
            }
        }

        echo '</table>';
        echo '<br>';
        echo '<button type="submit" name="update_access">Zapisz</button>';
        echo '</form>';
        echo '</main>';
    }

    private function updateDocumentAccess($data) {
        UserData::clearDocumentAccess();
        if (isset($data['access'])) {
            foreach ($data['access'] as $userId => $docs) {
                foreach ($docs as $docKey => $value) {
                    UserData::grantDocumentAccess($userId, $docKey);
                }
            }
        }
    }
}
?>

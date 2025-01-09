<?php
require_once 'Page.php';
require_once 'php/UserData.php';

class UserPage extends Page {
    public function renderContent() {
        global $documents;
        global $currentDoc;

        echo '<main>';
        echo '<ul class="document-list">';

        $accessibleDocs = UserData::getAccessibleDocuments($_SESSION['user_id']);
//        echo json_encode($accessibleDocs);
//        echo '<br>';
        foreach ($accessibleDocs as $doc) {
            echo "<li><a href='?doc={$doc['document_key']}'>{$documents[$doc['document_key']]->nicename}</a></li>";
        }
        if($currentDoc){
            $PdfURL = null;
            echo "<div class='selected-doc'><strong>$currentDoc->nicename</strong></div>";
            echo $currentDoc->drawForm('?doc='.$currentDoc->name,$_POST);
            UserData::SaveAllFormValues($currentDoc,$_POST); //zapisuje wszystkie wartości
        }        

        echo '</ul>';
        echo '</main>';
    }
}
?>

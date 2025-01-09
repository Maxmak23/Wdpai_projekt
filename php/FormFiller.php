<?php

class FormFiller{
    protected static $REGISTERED_FORMS = null;
    
    public $name = '';
    public $nicename = '';
    public $is_generated = false;
    public $form_submitted = false;
    
    public $pdf_file = null;
    public $pdf_filename_prefix = '';
    public $pdf_filename_suffix = '';
    public $pdf_filename = '';
    public $pdf_file_path = '';
    public $pdf_file_url = '';
    
    public $images_paths = [];
    public $fields = [];
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function drawForm($Action='',$Post=null){
        $PdfURL = null;
        if(isset($Post['pdf_form_submit'])){ $PdfURL = $this->drawPDF($Post); }
        $Post = $this->LoadValues($Post);
        
        $str = '';
            
        $str .= '<form method="POST" action="'.$Action.'">';
            $str .= '<div class="container" style="margin-top:0px;">';
                foreach ($this->fields as $Field){ $str .= $Field->drawForm($Post); }
                $str .= '<br>';
                $str .= '<br>';
                $str .= '<div class="row">';
                    $str .= '<div class="col-lg-12">';
                        $str .= '<input type="submit" name="pdf_form_submit" class="btn" value="Stwórz PDF" />';
                        if($PdfURL){ $str .= '<br><a style="width:100%;display:block;font-size:2em;text-align:center;" href="'.$PdfURL.'" target="_blank">PDF</a>'; }
                    $str .= '</div>';
                $str .= '</div>';
            $str .= '</div>';
        $str .= '</form>';
        
        return $str;
    }
    
    public function drawPDF($Post){
        $this->pdf_filename = $this->pdf_filename_prefix.Functions::GetCurrentTimeFormatted().'_'.rand(111,999).$this->pdf_filename_suffix;
        $this->pdf_file_path = Functions::PluginPath().'generated/'.$this->pdf_filename;
        $this->pdf_file_url = Functions::PluginURL().'generated/'.$this->pdf_filename;
            
        $this->pdf_file = new tFPDF('P');
        $this->pdf_file->SetFont('Times','',16);
        
        $PageImgIndex = 0;
        foreach ($this->images_paths as $PageImgPath){
            $PageImgFile = imagecreatefromjpeg($PageImgPath);
            
            foreach ($this->fields as $Field){
                $Field->drawPDF($PageImgIndex,$PageImgFile,$Post);
            }
            
            $PageImgPathTemp = tempnam(sys_get_temp_dir(),'img').'.jpg';
            imagejpeg($PageImgFile,$PageImgPathTemp);
            imagedestroy($PageImgFile);
            
            $this->pdf_file->AddPage();
            $this->pdf_file->Image($PageImgPathTemp,0,0,210);
            
            $PageImgIndex += 1;
        }
        
        $this->pdf_file->Output('f',$this->pdf_file_path);
        $this->is_generated = true;
        
        return $this->pdf_file_url;
    }
    
    private function LoadValues($Post){
        if (!isset($_SESSION['user_id'])) { return $Post; } //tylko dla zalogowanych
        
        $stmt = UserData::$PDO->prepare("
            SELECT * 
            FROM form_submissions 
            WHERE userID = :userID AND formName = :formName
        ");
        $stmt->execute([
            ':userID' => $_SESSION['user_id']*1,
            ':formName' => $this->name,
        ]);
        
        //nadpisz post wartościami, które nie są jeszcze w tym poście
        //dzięki temu wartości już podane przez użytkownika nie będą nadpisane przez stare wartości z bazy
        foreach ($stmt->fetchAll() as $row){
            if(!isset($Post[$row['formKey']])){
                $Post[$row['formKey']] = json_decode($row['formValue']);
            }
        }
        
        
        return $Post;
    }
    
}

?>
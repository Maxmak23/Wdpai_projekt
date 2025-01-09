<?php

class FormFiller_RejestracjaPojazdu extends FormFiller{
    
    public function __construct(){
        $this->name = 'rejestracja_pojazdu';
        $this->nicename = 'Rejestracja Pojazdu';
        
        $this->pdf_filename_prefix = $this->name.'_';
        $this->pdf_filename_suffix = '.pdf';
        
        $this->images_paths = [];
        $this->images_paths[] = Functions::PluginPath().'data/img/rejestracja_pojazdu_0.jpg';
        $this->images_paths[] = Functions::PluginPath().'data/img/rejestracja_pojazdu_1.jpg';
        
        
        $this->fields = [];
        
        $this->fields[] = $Field = new FormField_Text($this,'data_miejscowosc','Data i miejscowsosc','Dzisiejsza data oraz miejscość tworzenia dokumentu',true,'Warszawa, '.date('Y-m-d'));
        $Field->addPosition(0,910,380,25,25,500,1);
        
        $this->fields[] = $Field = new FormField_Text($this,'miejscowosc','Miejscowośc','Miejscowość z której pochodzisz',true,'Warszawa');
        $Field->addPosition(0,910,640,25,25,500,1);
        
        $this->fields[] = $Field = new FormField_Text($this,'nazwa_wlasciciela','Imię i nazwisko lub nazwa właściciela','',true,'Jan Nowak Firma Stalbudpol');
        $Field->addPosition(0,215,380,25,60,500,2);
        
        $this->fields[] = $Field = new FormField_Line($this,'nabycie_zbycie','Nabycie czy zbycie pojazdu','',true,['Nabycie','Zbycie']);
        $Field->addPosition(0,[1],325,1322,420,1322,3);
        $Field->addPosition(0,[0],437,1322,514,1322,3);
        
        
        
        
        
        
        
    }
}

?>
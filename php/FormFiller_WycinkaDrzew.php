<?php

class FormFiller_WycinkaDrzew extends FormFiller{
    
    public function __construct(){
        $this->name = 'wycinka_drzew';
        $this->nicename = 'Wycinka Drzew';
        
        $this->pdf_filename_prefix = $this->name.'_';
        $this->pdf_filename_suffix = '.pdf';
        
        $this->images_paths = [];
        $this->images_paths[] = Functions::PluginPath().'data/img/wycinka_drzew_0.jpg';
        $this->images_paths[] = Functions::PluginPath().'data/img/wycinka_drzew_1.jpg';
        $this->images_paths[] = Functions::PluginPath().'data/img/wycinka_drzew_2.jpg';
        
        
        $this->fields = [];
        
        $this->fields[] = $Field = new FormField_Text($this,'data_miejscowosc','Data i miejscowsosc','Dzisiejsza data oraz miejscość tworzenia dokumentu',true,'Warszawa, '.date('Y-m-d'));
        $Field->addPosition(0,880,145,25,25,500,1);
        $Field->addPosition(1,225,1535,25,25,500,1);
        
//        $this->fields[] = $Field = new FormField_Text($this,'miejscowosc','Miejscowośc','Miejscowość z której pochodzisz',true,'Warszawa');
//        $Field->addPosition(0,910,640,25,25,500,1);
        
        
        
        
        
        
        
    }
}

?>
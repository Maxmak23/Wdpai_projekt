<?php

class FormFiller_WydanieDokumentowSzkolnych extends FormFiller{
    
    public function __construct(){
        $this->name = 'wydanie_dokumentow_szkolnych';
        $this->nicename = 'Wydanie Dokumentow Szkolnych';
        
        $this->pdf_filename_prefix = $this->name.'_';
        $this->pdf_filename_suffix = '.pdf';
        
        $this->images_paths = [];
        $this->images_paths[] = Functions::PluginPath().'data/img/wydanie_dokumentow_szkolnych_0.jpg';
        
        
        $this->fields = [];
        
        $this->fields[] = $Field = new FormField_Text($this,'data_miejscowosc','Data i miejscowsosc','Dzisiejsza data oraz miejscość tworzenia dokumentu',true,'Warszawa, '.date('Y-m-d'));
        $Field->addPosition(0,1080,290,25,25,500,1);
        
        
        
        
        
        
        
    }
}

?>
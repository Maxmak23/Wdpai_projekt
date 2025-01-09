<?php

class FormField
{
    protected $form;
    protected $key;
    protected $type;
    protected $title;
    protected $description;
    protected $showInForm;
    protected $defaultValue;
    protected $pos;
    private $fieldKey;

    /**
     * Constructor
     *
     * @param string $key
     * @param string $type
     * @param string $title
     * @param string $description
     * @param bool $show_in_form
     * @param mixed $defaultValue
     */
    protected function __construct($form, $key, $type, $title, $description, $show_in_form, $defaultValue)
    {
        $this->form = $form;
        $this->key = $key;
        $this->type = $type;
        $this->title = $title;
        $this->description = $description;
        $this->showInForm = $show_in_form;
        $this->defaultValue = $defaultValue;
        $this->pos = [];
        $this->fieldKey = $this->form->name.'_'.$this->key;
    }


    //public function addPosition(){}
    public function drawPDF(&$PageImgIndex,&$PageImgFile,&$Post){}
    public function drawForm($Post){}
    public function GetFieldKey(){ return $this->fieldKey; }
    public function GetValue($Post){ if(isset($Post[$this->GetFieldKey()])){ return $Post[$this->GetFieldKey()];} return $this->defaultValue; }
    public function IsValueDefault($Post){ return $this->defaultValue===$this->GetValue($Post); }






    // Getters
    public function getKey(){ return $this->key; }
    public function getType(){ return $this->type; }
    public function getTitle(){ return $this->title; }
    public function getDescription(){ return $this->description; }
    public function getShowInForm(){ return $this->showInForm; }
    public function getDefaultValue(){ return $this->defaultValue; }
    
    // Setters
    public function setKey($key){ $this->key = $key; }
    public function setType($type){ $this->type = $type; }
    public function setTitle($title){ $this->title = $title; }
    public function setDescription($description){ $this->description = $description; }
    public function setShowInForm($showInForm){ $this->showInForm = $showInForm; }
    public function setDefaultValue($defaultValue){ $this->defaultValue = $defaultValue; }
}

?>

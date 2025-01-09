<?php

class FormField_Line extends FormField
{
    protected $choices;
    
    public function __construct($form,$key,$title,$description,$show_in_form,$choices=[])
    {
        parent::__construct($form,$key,'text',$title,$description,$show_in_form,0);
        $this->choices = $choices;
    }
    
    public function addPosition($page,$choicesIndexes,$x1,$y1,$x2,$y2,$lineSize){
        $this->pos[] = ['page'=>$page,'choicesIndexes'=>$choicesIndexes,'x1'=>$x1,'y1'=>$y1,'x2'=>$x2,'y2'=>$y2,'lineSize'=>$lineSize];
    }
    public function GetValue($Post){ return parent::GetValue($Post)*1; }
    
    public function drawPDF(&$PageImgIndex,&$PageImgFile,&$Post){
        $color = imagecolorallocate($PageImgFile, 0, 0, 0);
        
        foreach ($this->pos as $Value_Pos){
            if($Value_Pos['page']!==$PageImgIndex){ continue; }
            if(!in_array($this->GetValue($Post),$Value_Pos['choicesIndexes'])){ continue; }
            imagesetthickness($PageImgFile,$Value_Pos['lineSize']);
            imageline($PageImgFile,$Value_Pos['x1'],$Value_Pos['y1'],$Value_Pos['x2'],$Value_Pos['y2'],$color);
        }
    }
    
    public function drawForm($Post=[]){
        if(!$this->showInForm){ return ''; }
        $Input_Style = '';
        $ChoiceIndex = 0;
        
        $str = '';
            $str .= '<div class="row">';
                $str .= '<div class="col-lg-3">';
                    $str .= '<h3>'.$this->title.'</h3>';
                    if(strlen($this->description)){ $str .= '<h5>'.$this->description.'</h5>'; }
                $str .= '</div>';
                $str .= '<div class="col-lg-9">';
                    foreach ($this->choices as $Choice){
                        $str .= '<input type="radio" id="" class="" name="'.$this->GetFieldKey().'" style="'.$Input_Style.'" value="'.$ChoiceIndex.'" '.( $this->GetValue($Post)*1==$ChoiceIndex ? ' checked="checked" ' : '').' />';
                        $str .= $Choice;
                        $str .= '<br>';
                        $ChoiceIndex += 1;
                    }      
                $str .= '</div>';
            $str .= '</div>';
        
        return $str;
    }
    
    
    
}

?>

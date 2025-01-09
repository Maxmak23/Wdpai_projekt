<?php

class FormField_Text extends FormField
{
    
    public function __construct($form, $key, $title, $description, $show_in_form, $defaultValue)
    {
        parent::__construct($form,$key,'text',$title,$description,$show_in_form,$defaultValue);
    }
    
    public function addPosition($page,$x,$y,$fontSize,$yNext,$maxWidth,$maxLines){
        $this->pos[] = ['page'=>$page,'x'=>$x,'y'=>$y,'size'=>$fontSize,'yNext'=>$yNext,'maxWidth'=>$maxWidth,'maxLines'=>$maxLines];
    }
    
    public function drawPDF(&$PageImgIndex,&$PageImgFile,&$Post){
        $color = imagecolorallocate($PageImgFile, 0, 0, 0);
        $fontPath = Functions::PluginPath().'libraries/dejavu-fonts-ttf-2.37/ttf/DejaVuSansMono.ttf';
        
        foreach ($this->pos as $Value_Pos){
            if($Value_Pos['page']!==$PageImgIndex){ continue; }
            
            $TextLinesOrig = explode(' ',$Post[$this->form->name.'_'.$this->key]);
            $TextLinesOrigCount = count($TextLinesOrig);
            $TextLinesOut = [];
            $TextLinesOutIndex = 0;
            for($i=0;$i<$Value_Pos['maxLines'];$i+=1){ $TextLinesOut[$i] = ''; }

            for($i=0;$i<$TextLinesOrigCount;$i+=1){
                $Word = $TextLinesOrig[$i];
                $PotentialText = trim($TextLinesOut[$TextLinesOutIndex].' '.trim($Word));
                $bbox = imagettfbbox($Value_Pos['size'],0,$fontPath,$PotentialText);
                $PotentialTextWidth = $bbox[2]-$bbox[0];
                if($PotentialTextWidth>$Value_Pos['maxWidth']){
                    $i -= 1;
                    $TextLinesOutIndex += 1;
                }else{
                    $TextLinesOut[$TextLinesOutIndex] = $PotentialText;
                }
                if($TextLinesOutIndex>=$Value_Pos['maxLines']){
                    $TextLinesOut[$TextLinesOutIndex-1] .= '...';
                    break;
                }                                
            }
            $TextLinesOutIndex = 0;
            foreach ($TextLinesOut as $Line){
                if(strlen($Line)){
                    imagettftext($PageImgFile,$Value_Pos['size'], 0, $Value_Pos['x'], $Value_Pos['y']+$TextLinesOutIndex*$Value_Pos['yNext'], $color, $fontPath,$Line);
                    $TextLinesOutIndex+=1;
                }
            }
        }
    }
    
    public function drawForm($Post=[]){
        if(!$this->showInForm){ return ''; }
        //$Input_Val = isset($Post[$this->GetFieldKey()]) ? $Post[$this->GetFieldKey()] : $this->defaultValue;
        $Input_Style = 'width:100%;';
        
        
        $str = '';
            
            $str .= '<div class="row">';
                    
                $str .= '<div class="col-lg-3">';
                    $str .= '<h3>'.$this->title.'</h3>';
                    if(strlen($this->description)){ $str .= '<h5>'.$this->description.'</h5>'; }
                $str .= '</div>';
                $str .= '<div class="col-lg-9">';
                    $str .= '<input type="text" id="" class="form_input form_input_text" name="'.$this->GetFieldKey().'" style="'.$Input_Style.'" value="'.$this->GetValue($Post).'"/>';
                $str .= '</div>';

            $str .= '</div>';
        
        return $str;
    }
    
    
    
}

?>

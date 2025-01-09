<?php

class Functions{
    
    
    
    public static function PluginURL($AddPath = '') {
        $Protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $Host = $_SERVER['HTTP_HOST'];
        $Path = str_replace(DIRECTORY_SEPARATOR, '/', __DIR__.'/..');
        $Path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $Path); // Make it relative to the web root
        return $Protocol . $Host . $Path . '/' . ltrim($AddPath, '/');
    }
    
    
    public static function PluginPath($AddPath=''){
        $Path = __DIR__.'/..'.DIRECTORY_SEPARATOR;
        $Path = str_replace('/','\\',$Path);
        return $Path.$AddPath;
    }
    
    public static function NumberToPolish($number){
        $polishNumbers = [
            0 => 'zero', 1 => 'jeden', 2 => 'dwa', 3 => 'trzy', 4 => 'cztery', 5 => 'pięć',
            6 => 'sześć', 7 => 'siedem', 8 => 'osiem', 9 => 'dziewięć', 10 => 'dziesięć',
            11 => 'jedenaście', 12 => 'dwanaście', 13 => 'trzynaście', 14 => 'czternaście', 15 => 'piętnaście',
            16 => 'szesnaście', 17 => 'siedemnaście', 18 => 'osiemnaście', 19 => 'dziewiętnaście', 20 => 'dwadzieścia',
            21 => 'dwadzieścia jeden', 22 => 'dwadzieścia dwa', 23 => 'dwadzieścia trzy', 24 => 'dwadzieścia cztery', 25 => 'dwadzieścia pięć',
            26 => 'dwadzieścia sześć', 27 => 'dwadzieścia siedem', 28 => 'dwadzieścia osiem', 29 => 'dwadzieścia dziewięć', 30 => 'trzydzieści',
            31 => 'trzydzieści jeden', 32 => 'trzydzieści dwa', 33 => 'trzydzieści trzy', 34 => 'trzydzieści cztery', 35 => 'trzydzieści pięć',
            36 => 'trzydzieści sześć', 37 => 'trzydzieści siedem', 38 => 'trzydzieści osiem', 39 => 'trzydzieści dziewięć', 40 => 'czterdzieści',
            41 => 'czterdzieści jeden', 42 => 'czterdzieści dwa', 43 => 'czterdzieści trzy', 44 => 'czterdzieści cztery', 45 => 'czterdzieści pięć',
            46 => 'czterdzieści sześć', 47 => 'czterdzieści siedem', 48 => 'czterdzieści osiem', 49 => 'czterdzieści dziewięć', 50 => 'pięćdziesiąt'
        ];
        if (!isset($polishNumbers[$number])){ return "Number out of range"; }
        return $polishNumbers[$number];
    }
    
    
    public static function GetCurrentTimeFormatted(){
        // Get the current time with microseconds
        $microtime = microtime(true);

        // Extract the full seconds and the microseconds
        $seconds = floor($microtime);
        $milliseconds = round(($microtime - $seconds) * 1000);

        // Format the date and time components
        $formattedTime = date('y_m_d_H_i_s', $seconds);

        // Format the milliseconds with leading zeros if necessary
        $milliseconds = str_pad($milliseconds, 3, '0', STR_PAD_LEFT);

        // Combine the formatted components
        return $formattedTime . '_' . $milliseconds;
    }
    
    public static function DebugLog_WriteLn($Text){
        $Text = ''.$Text;
        $DebugFileSrc = PFA_Functions::PluginPath().'DebugLog.txt';
        file_put_contents($DebugFileSrc,$Text.PHP_EOL,FILE_APPEND);
    }
    
    
    public static function DeleteGeneratedFilesOlderThan($MaxAgeInSeconds=86400) {
        $folderPath = PFA_Functions::PluginPath().'generated';
        if(!is_dir($folderPath)){
            throw new Exception("The provided path is not a directory.");
        }

        $files = glob($folderPath . '/*'); // Get all files in the folder
        $now = time();

        foreach ($files as $file) {
            if (is_file($file)) {
                $fileAge = $now - filemtime($file);
                if ($fileAge > $MaxAgeInSeconds){
                    unlink($file); // Delete the file
                    //PFA_Functions::DebugLog_WriteLn('delete '.$file);
                }else{
                    //PFA_Functions::DebugLog_WriteLn('stay '.$file);
                }
            }
        }
    }
    
    
    
    public static function Draw_Input($Type,$ID,$Class,$Name,$Value,$Label,$Description,$Style){
        $str = '';
            
        $str .= '<div class="container">';
            $str .= '<div class="row">';
                    
                $str .= '<div class="col-lg-3">';
                    $str .= '<h3>'.$Label.'</h3>';
                    if(strlen($Description)){ $str .= '<h5>'.$Description.'</h5>'; }
                $str .= '</div>';
                $str .= '<div class="col-lg-9">';
                    if($Type==='text'){
                        $str .= '<input type="text" id="'.$ID.'" class="'.$Class.'" name="'.$Name.'" style="'.$Style.'" value="'.$Value.'"/>';
                    }
                    if($Type==='number'){
                        $str .= '<input type="number" id="'.$ID.'" class="'.$Class.'" name="'.$Name.'" style="'.$Style.'" value="'.$Value.'"/>';
                    }
                    if($Type==='textarea'){
                        $str .= '<textarea rows=6 id="'.$ID.'" class="'.$Class.'" name="'.$Name.'" style="'.$Style.'">'.$Value.'</textarea>';
                    }
                    if($Type==='checkbox'){
                        $str .= '<input type="hidden" id="'.$ID.'" class="'.$Class.'" name="'.$Name.'" style="'.$Style.'" value="0"/>';
                        $str .= '<input type="checkbox" id="'.$ID.'" class="'.$Class.'" name="'.$Name.'" style="'.$Style.'" value="1" '.(boolval(intval($Value)) ? ' checked="checked" ' : '').'/>';
                    }
                $str .= '</div>';

            $str .= '</div>';
        $str .= '</div>';
        
        return $str;
    }
    
}

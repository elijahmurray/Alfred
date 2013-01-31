<?php 

    $WOLFRAM_APP_ID = ""; # Insert App Id in between quotes
    $EVI_DEV_USERNAME = ""; # Insert Evi / True Knowledge developer username (usually api_Username) in between quotes
    $EVI_DEV_PASSWORD = ""; # Insert Evi generated api password in between quotes;
    $mytitle = "Master Elijah"; #Type whatever you want to be addressed 
    			 #by in the audio response. Leave blank if you 
    			 #prefer to not be addressed


    $stturl = "https://www.google.com/speech-api/v1/recognize?xjerr=1&client=chromium&lang=en-US";
    $wolframurl = "http://api.wolframalpha.com/v2/query?appid=".$WOLFRAM_APP_ID."&format=plaintext&podtitle=Result&input=";
    $trueknowledgeurl = "https://api.trueknowledge.com/direct_answer/?api_account_id=".$EVI_DEV_USERNAME."&api_password=".$EVI_DEV_PASSWORD."&question=";
    $ttsurl = "http://translate.google.com/translate_tts?tl=en&q=";

    if(isset($_GET['speechinput'])){
        $text = $_GET['speechinput'];
        $mytitle = $mytitle.", ";


        if(stripos($text,"john")!==FALSE){
            //Custom commands, based on a specific word identifier          
    	$answer = "My name isn't John you fool";
        }
        
// commented out because TK API call wasn't working
// Sent support ticket, waiting for update        
// All add a { at the end of the else statements if you reenable this

//        else{
            // True Knowledge API
//
//            $trueknowledgeurl .= urlencode($text);
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, $trueknowledgeurl);
//            ob_start();
//            curl_exec($ch);
//            curl_close($ch);
//            $contents = ob_get_contents();
//            ob_end_clean();
//            echo $contents;
//            $contents = str_replace("tk:","tk_",$contents); // simplexml doesn't seem to like colons
//            $obj = new SimpleXMLElement($contents);
//            if($answer = $obj->tk_text_result){


                //$answer = $mytitle.$answer;

//            }
            else{
                //$answer = $obj->tk_error_message;


                // Wolfram Alpha API

                $wolframurl .= urlencode($text);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $wolframurl);
                ob_start();
                curl_exec($ch);
                curl_close($ch);
                $contents = ob_get_contents();
                ob_end_clean();
//                echo $contents;
                $obj = new SimpleXMLElement($contents);
                $answer = $obj->pod->subpod->plaintext;
                if(strlen($answer)){
                    $answer = $mytitle.$answer;
                }
                else{
                    $answer = $mytitle."sorry, no idea what you're talking about!";
                }
            }



        // Google Text to Speech

        $ttsurl .= urlencode($answer);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ttsurl);
        ob_start();
        curl_exec($ch);
        curl_close($ch);
        $contents = ob_get_contents();
        ob_end_clean();
        header('Content-Type: audio/mpeg');
        header('Cache-Control: no-cache');
        print $contents;
    }
    else{
        ?>
        <html>
            <head>
                <title>Jarvis 2.0</title>
                <script>
                    function submitandclear(){
                        if(document.getElementById('speechinput').value != ""){
                            document.jarvisform.submit();
                            document.getElementById('speechinput').value = "";
                        }
                    }


                </script>
            </head>
            <body>
                <form method="get" name="jarvisform" id="jarvisform" action="<?=$_SERVER['PHP_SELF']?>" target="voiceframe">
                    <input name="speechinput" id="speechinput" type="text" onFocus="submitandclear(this);" style="width:20px; background: red;" x-webkit-speech /><!--input type="submit" value="ASK" /-->
                </form>
                <iframe width="0px" height="0px" style="border:0px;" src="about:none" name="voiceframe"></iframe>
                
            </body>
        </html>
        <?
    }
?>
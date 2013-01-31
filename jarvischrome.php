<?php 
    $stturl = "https://www.google.com/speech-api/v1/recognize?xjerr=1&client=chromium&lang=en-US";
    $wolframurl = "http://api.wolframalpha.com/v2/query?appid=GEJA3Q-V6X8PAH9VU&format=plaintext&podtitle=Result&input=";
    $trueknowledgeurl = "https://api.trueknowledge.com/direct_answer/?api_account_id=api_elijahmurray&api_password=Hyperi0n1!&question=";
    $ttsurl = "http://translate.google.com/translate_tts?tl=en&q=";

    if(isset($_GET['speechinput'])){
        $text = $_GET['speechinput'];


        if(stripos($text,"special")!==FALSE){
			//Custom commands, based on a specific word identifier        	
	echo("amas speckksial");
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


                //$answer = "master cranky, ".$answer;

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
                    $answer = "master Elijah, ".$answer;
                }
                else{
                    $answer = "sorry, I don't understand";
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
                <title>.: Jarvis :.</title>
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
                    <input name="speechinput" id="speechinput" type="text" onFocus="submitandclear(this);" style="width:20px;" x-webkit-speech /><!--input type="submit" value="ASK" /-->
                </form>
                <iframe width="0px" height="0px" style="border:0px;" src="about:none" name="voiceframe"></iframe>
                
            </body>
        </html>
        <?
    }
?>
<style>
iframe {
	width: 100%;
	height: 90%;
}
</style>
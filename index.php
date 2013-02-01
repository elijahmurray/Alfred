<?php 

    $WOLFRAM_APP_ID = ""; # GEJA3Q-V6X8PAH9VU Insert App Id in between quotes
    $EVI_DEV_USERNAME = ""; # Insert Evi / True Knowledge developer username (usually api_Username) in between quotes
    $EVI_DEV_PASSWORD = ""; # Insert Evi generated api password in between quotes;
    $mytitle = ""; #Type whatever you want to be addressed 
                 #by in the audio response. Leave blank if you 
                 #prefer to not be addressed


    $stturl = "https://www.google.com/speech-api/v1/recognize?xjerr=1&client=chromium&lang=en-US";
    $wolframurl = "http://api.wolframalpha.com/v2/query?appid=".$WOLFRAM_APP_ID."&format=plaintext&podtitle=Result&input=";
    $trueknowledgeurl = "https://api.trueknowledge.com/direct_answer/?api_account_id=".$EVI_DEV_USERNAME."&api_password=".$EVI_DEV_PASSWORD."&question=";
    $ttsurl = "http://translate.google.com/translate_tts?tl=en&q=";

    if(isset($_GET['speechinput'])){
        $text = $_GET['speechinput'];

        if ($mytitle !="") {
            $mytitle = $mytitle.", "; //Add pause after title if there is a title.
        }

        if(stripos($text,"controlling")!==FALSE){  # || "start" || "launch" || "open" || "go to" 
            $answer = "Of course not.";
        }

        elseif(stripos($text,"name")!==FALSE){  # || "start" || "launch" || "open" || "go to" 
            $answer = "My name is Alfred. Unfortunately I don't have a man's voice yet.";
        }

        elseif(stripos($text,"apple")!==FALSE){
            $answer = "Apple can go fuck itself";
        }

        elseif(stripos($text,"music")!==FALSE){ # || music
                //Custom commands, based on a specific word identifier
            echo "<iframe src=\"widget.php\">"; //if you say song, it will load my favorite music playlist
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
            else {
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
            <link rel="icon" 
                  type="image/png" 
                  href="favicon.png">
                <title>Alfred</title>
                <script>
                    function submitandclear(){
                        if(document.getElementById('speechinput').value != ""){
                            document.alfredform.submit();
                            document.getElementById('speechinput').value = "";
                        }
                        
                    }


                </script>
                <link rel="stylesheet" href="style.css" />   
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> 
            </head>
            <body>
                <div id="container">
                    <h1>Hello, I'm Alfred.</h1>
                    <h4>...and no, I'm not Siri's boyfriend.</h4>
                    <script>
                    $(document).ready(function(){
                        $("h1").hide().fadeIn(1000);
                        $("h4").delay(1400).animate({opacity:1.0},1200).delay(3000).slideUp(900);
                    });
                    </script>
                    <form method="get" name="alfredform" id="alfredform" action="<?=$_SERVER['PHP_SELF']?>" target="voiceframe"> <!-- submit form to self -->
                        <input name="speechinput" id="speechinput" class="speechinput" type="text"  onFocus="submitandclear(this);" x-webkit-speech /><!--input type="submit" value="ASK" /-->
                    </form>
                     <div id="switch-to-type" onclick="typing()">Switch to typing</div>
                    
                    <script>
                    $toggle = 0; //used in the below function

                        // this function changes back and forth from typing input to speaking input
                        function typing() {
                            if ($toggle == 0) {
                                $('.speechinput').toggleClass('typing').focus();
                                $('#switch-to-type').html('Switch to voice');
                                $('.speechinput').css({"width": "100px"});
                                $toggle = ($toggle-1);
                            }
                            else {
                                $('.speechinput').toggleClass('typing');
                                $('#switch-to-type').html('Switch to typing');
                                $('.speechinput').css({"width": "40px"});
                                $toggle++;
                            }
                        }

                        // Dynamically resize the typing box (when activated) to match the length of the user typed comment
                        $(document).ready(function(){
                            $("input").keyup(function(){
                                contents = $(this).val();
                                charlength = contents.length;
                                newwidth = 100 + (charlength*6); //charlength * 6 is the amount of space that is added for each new character
                                $(this).css({width:newwidth});
                            });     
                        });
                    </script>

                    <iframe width="0%" height="20%" style="border:0px; background:red" src="about:none" name="voiceframe"></iframe>
                    <div style="position:absolute; left:0; top: 0;"><?php print $text; ?></div>



                </div>
            </body>
        </html>
        <?
    }
?>
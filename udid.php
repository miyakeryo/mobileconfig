<?php
 
if (isset($_GET["udid"])) {
    echo("<html><body><h1>");
    echo($_GET["udid"]);
    echo("</h1></body></html>");
    exit();
}
 
$data = file_get_contents('php://input');
 
$plistBegin   = '<?xml version="1.0"';
$plistEnd   = '</plist>';
 
$pos1 = strpos($data, $plistBegin);
$pos2 = strpos($data, $plistEnd);
 
$data2 = substr ($data,$pos1,$pos2-$pos1);
 
$xml = xml_parser_create();
 
xml_parse_into_struct($xml, $data2, $vs);
xml_parser_free($xml);
 
$udid = "";
$iterator = 0;
 
$arrayCleaned = array();
 
foreach($vs as $v){
 
    if($v['level'] == 3 && $v['type'] == 'complete'){
    $arrayCleaned[]= $v;
    }
$iterator++;
}
 
$data = "";
 
$iterator = 0;
 
foreach($arrayCleaned as $elem){
                $data .= "\n==".$elem['tag']." -> ".$elem['value']."<br/>";
                switch ($elem['value']) {
                    case "UDID":
                        $udid = $arrayCleaned[$iterator+1]['value'];
                        break;
                    }
                    $iterator++;
}
 
header("Location: ". $_SERVER["REQUEST_URI"] . "?udid=" . $udid, true, 301);
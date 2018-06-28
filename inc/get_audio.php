<?php
if(isset($_GET['data'])){ 
$id = $_GET['data'];
function file_get_contents_curl($url) {
    $ch = curl_init();

$headers = [
    'token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbF9mb3JfYXBpX2FjY2VzcyI6ImpvaG5AbmFkZXIubXgifQ.YPt3Eb3xKekv2L3KObNqMF25vc2uVCC-aDPIN2vktmA',
];


    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}


$url = "https://formats.yout.com/formats?url=https://www.youtube.com/watch?v=".$id;
$json = file_get_contents_curl($url);
$decode = json_decode($json);
echo $decode->cache[0]->url;

}
?>
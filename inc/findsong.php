<?php 

if($_GET['lang']){

$lang = $_GET['lang'];
$keys = array("","classic","folk","film","old+film","new","best","pop","country","classical");

$rand_keys = array_rand($keys, 2);
$songskey = $keys[$rand_keys[0]];

$q = urlencode($lang."+".$songskey."+song");

  $starttime = microtime(true);
 $url = "playserver.php?q=".$q;
 $data = file_get_contents($url);
 $endtime = microtime(true);
 $duration = $endtime - $starttime;
 $trs = json_decode($data,true);
 $limitedResults=array_slice($trs, $start, 10);
 foreach($limitedResults as $r){
    $dur = explode(':',$r['duration']);
    if($dur[0] < 10){
    $res[]  = array(
        'title' => $r['title'], 
        'video' => str_replace('https://www.youtube.com/watch?v=','',$r['video']),
        'l' => $r['duration'],
        
        );
    }
   } 


echo $data = json_encode($res);

}

?>
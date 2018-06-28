<?php
require('dom.php'); 
$input = str_replace(' ','+',$_GET['q']);
$page = rand(1,3);
$myUrl = "https://www.youtube.com/results?search_query=" . $input."&page=".$page;
$html = file_get_html($myUrl);
$videos = array();
$mostViewed =  array();
function parseDuration($string){
$explode = explode('Duration:',$string);

return str_replace('.','',$explode[1]);
}


foreach ($html->find('div.yt-lockup-content') as $video) {
		$title = $video->find('h3.yt-lockup-title a', 0)->plaintext;
		$title = str_replace('^',' ',$title);
		$title = str_replace('|',' ',$title);
		$url = "https://www.youtube.com" . $video->find('h3.yt-lockup-title a', 0)->href;
		$duration = $video->find('h3.yt-lockup-title span', 0)->plaintext;
                $views = $video->find('ul.yt-lockup-meta-info li', 1);
		
		if($duration != null && $views != null){
			$views = preg_replace("/[^0-9]/","",$views);
			$videos[] = array("title"=>$title, "duration"=>$duration, "url"=>$url, "views"=>$views);
			array_push($mostViewed,$views);	
		}
						
}
$finalVideos = array();
rsort($mostViewed);
$i = 0;
$f = array("Full Video Song","Full Audio Song","Video","Audio","Full Song","Full","(",")","1080","HD");
$r = array("","","","","","","","","","");
foreach( $mostViewed as $el) {
	$key = array_search($el, array_column($videos, 'views'));
	$finalVideos[] = array(
             'title' => str_replace($f,$r,$videos[$i]['title']),
             'video' => $videos[$i]['url'],
             'duration' => parseDuration($videos[$i]['duration']),
             

         );
    $i++;
}
   //echo implode('|',$finalVideos);

echo json_encode($finalVideos);
	
 
?>
<html>
  <head>
    <title>Random Music from Youtube</title>
    <link href='http://lonthon.com//assets/css/settings.css?v=1' async='async' rel='stylesheet' />
    <link href='http://lonthon.com//assets/css/font-awesome.min.css?v=1' async='async' rel='stylesheet' />
    <link href='https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600' async='async' rel='stylesheet' />
    <link href='http://lonthon.com//assets/css/plyr.css?v=1' async='async' rel='stylesheet' />
    <link href='http://lonthon.com//assets/css/style.css?v=1' async='async' rel='stylesheet' />
    <link href='http://lonthon.com//assets/css/search.css?v=1' async='async' rel='stylesheet' />
    <script src='http://lonthon.com//assets/js/jquery-3.2.1.min.js'></script>
    <script src='http://lonthon.com//cdn/js/suggest.js'></script>
    <meta name='description' content="Search the movies, books and music"/>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-106188852-1', 'auto');
  ga('send', 'pageview');

</script>  
</head>





<?php 
require_once('config.php');
    
if(isset($_GET['lang'])){
    $lang = $_GET['lang'];
}
else{
     $lang = "bangla";
}

$keys = array("","classic","folk","film","old+film","new","best","pop","country","classical");


$rand_keys = array_rand($keys, 2);
$songskey = $keys[$rand_keys[0]];

 $q = urlencode($lang."+".$songskey."+song");
 $starttime = microtime(true);
 $url = url."inc/playserver.php?q=".$q;
 $data = file_get_contents($url);;
 $endtime = microtime(true);
 $duration = $endtime - $starttime;
 $trs = json_decode($data,true);
 $start = 0;
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

$data = json_encode($res);

?>

<section class="main_player">
<div class="heading"><h4>Playing: <span class="song_title"></span></h4></div>
 <audio id="b-player" controls>
  <source id="b_src" type="audio/mpeg">
</audio>
<div class="navigation">
  <a href="#" class="previous">&laquo; Previous</a>
<a href="#" class="next">Next &raquo;</a>  
</div>
</section>

<script>


var json = '<?php echo $data; ?>';
var obj = JSON.parse(json); 


var play = 0;
$(window).on('load', function(){

PlayMusic(play);

$('#b-player').on('ended', function() {
    play++;
  PlayMusic(play);  
});

});



function SearchNewSong(){
 var songs = "inc/findsong.php?lang=".$lang;
 $.get(songs, function(data, status){
   json = '<?php echo $data; ?>';
   obj = JSON.parse(json); 
   play = 0;
   
   PlayMusic(play);  

    });    
    
}



function PlayMusic(pos){
    
if(pos < obj.length ){
var rand = obj[pos];   
var url = "inc/get_audio.php?data="+rand.video;
var thisitem = $(this);
$.get(url, function(data, status){
var audio = $("#b-player");   
$("#b_src").attr("src",data);
audio[0].pause();
audio[0].load();
audio[0].oncanplaythrough = audio[0].play();
$(".song_title").html(rand.title);

    });   
}
else {
    
   SearchNewSong(); 
}

}
    
    
    
$(".previous").on('click', function(){
   play--;
   if(play < 0){
     play = 0;  
   }
   
   PlayMusic(play);
    
    
});


$(".next").on('click', function(){
   play++;
   PlayMusic(play);
    
    
});
    
</script>
<style>a {
    text-decoration: none;
    display: inline-block;
    padding: 8px 16px;
}

a:hover {
    background-color: #ddd;
    color: black;
}

.previous {
    background-color: #00b6cb;
    color: white;
}

.next {
    background-color: #00b6cb;
    color: white;
}

.navigation {
    text-align: center;
    margin-top: 20px;
}


.heading {
    text-align: center;
    margin-bottom: 20px;
}


section.main_player {
    top: 35%;
    position: relative;
}
</style>

<script src='http://lonthon.com/assets/js/main.js'></script>
<script src='http://lonthon.com/assets/js/link.js'></script>
<script src='http://lonthon.com/assets/js/plyr.js'></script>
<script>plyr.setup();</script> 
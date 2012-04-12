<?php

b:

$linksindexed = 0;
set_time_limit (10000000000);

$con = mysql_connect("localhost","username","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("crawler", $con);

include_once('crawlerscript.php');
$target_url = "http://www.example.com/";
a:
$html = new simple_html_dom();
$html->load_file($target_url);
foreach($html->find('a') as $link){
if (strpos($link->href,'http') === 0 ) {
$result = mysql_query("SELECT * FROM urls WHERE url = '$link->href'");
$num_rows = mysql_num_rows($result);
if($num_rows > 0) {
flush();
goto a;
} else {
mysql_query("INSERT INTO urls (url) VALUES ('$link->href')");
print $link->href."<br />";
flush();
$target_url = $link->href;
$linksindexed = $linksindexed + 1;
}
if($linksindexed == '50') {
print 'FINISHED CRAWLING';
flush();
die();
}
flush();
goto a;
} else {
}
}
flush();
goto a;
?>

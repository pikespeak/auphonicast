<!-----------------------------------------------------------------------------
# index.php (stub index page) 
# https://github.com/wyae/auphonicast/
# 2015 by Volker Tanger <volker.tanger_git@wyae.de> published under GPLv3
------------------------------------------------------------------------------>

<?php
include("renderauphonic.php");

$episodetemplate = "<h3>*title*</h3>*date* by: *publisher*<br>duration: *minutes* min<p>*summary*<p>*MEDIA*<p><hr><p>";
$mediatemplate = "<p><audio  preload=\"none\" controls><source src=\"*URL*?src=player\"><!--type=\"audio/mpeg\"--></audio> &nbsp; <a href=\"*URL*?src=download\"><b>*EXT*</b></a> (*SIZE*)</p>";

RenderAuphonic("../podcasts/", "http://radio.sf-fantasy.de/podcasts/", ".", ".", $episodetemplate, $mediatemplate);
?>


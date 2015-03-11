<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; ?>
<rss version="2.0">
<channel>
<title>ENTER title here - podcast - MP3 feed</title>
<link>ENTER url of the feed here /rss.php?media=mp3</link>
<description><![CDATA[
        ENTER description here
]]></description>
<lastBuildDate><?php date(DATE_RFC822); ?></lastBuildDate>
<language>de</language>

<?php
include("renderauphonic.php");

$episodetemplate = "<item> <title><![CDATA[*title*]]></title><link>ENTER url of page here?podcast=*title*</link><guid>ENTER url of page here?podcast=*title*</guid><pubDate>*date_rfc822*</pubDate><description><![CDATA[ *date* <br />*summary* ]]></description> *MEDIA*</item>";
$mediatemplate = "<enclosure type=\"audio/*EXT*\" url=\"*URL*?src=rss\" length=\"*SIZE*\" />";

RenderAuphonic("../podcasts/", "http://url.to.auphonic/directory/", ".", ".mp3", $episodetemplate, $mediatemplate);
?>


</channel>

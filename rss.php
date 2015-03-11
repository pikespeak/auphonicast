<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; $mediatype = preg_replace("/[^A-Za-z0-9_.]/", "", $_GET["typ"]); if (""==$mediatyp){$mediatyp="mp3";} ?>
<!-----------------------------------------------------------------------------
# rss.php (simple RSS feed) 
# https://github.com/wyae/auphonicast/
# 2015 by Volker Tanger <volker.tanger_git@wyae.de> published under GPLv3
------------------------------------------------------------------------------>

<rss version="2.0">
<channel>
<title>ENTER title here - podcast - <?php echo $mediatype; ?> feed</title>
<link>ENTER url of the feed here /rss.php?typ=$mediatyp</link>
<description><![CDATA[
        ENTER description here
]]></description>
<lastBuildDate><?php date(DATE_RFC822); ?></lastBuildDate>
<language>de</language>

<?php
include("auphonicast/renderauphonic.php");

$episodetemplate = "<item> <title><![CDATA[*title*]]></title><link>ENTER url of page here/?podcast=*title*</link><guid>ENTER url of page here/?podcast=*title*</guid><pubDate>*date_rfc822*</pubDate><description><![CDATA[ *date* <br />*summary* ]]></description> *MEDIA*</item>";
$mediatemplate = "<enclosure type=\"audio/*EXT*\" url=\"*URL*?src=rss\" length=\"*BYTES*\" />";

RenderAuphonic("../podcasts/", "http://url.to.auphonic/directory/", ".", ".mp3", $episodetemplate, $mediatemplate);
?>

</channel>

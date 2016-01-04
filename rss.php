<?php
$mediatype = preg_replace("/[^A-Za-z0-9_.]/", "", $_GET["typ"]);
if (""==$mediatyp){$mediatyp="mp3";}
#-----------------------------------------------------------------------------
# rss.php (simple RSS feed)
# https://github.com/wyae/auphonicast/
# 2015 by Volker Tanger <volker.tanger_git@wyae.de> published under GPLv3
#-----------------------------------------------------------------------------

$BASEURL        = "http://radio.example.com/";
$FEEDURL        = $BASEURL . "rss.php?typ=" . $mediatyp;
$AUDIOURL       = $BASEURL . "podcasts/";
$PODCASTTITLE   = "phantastic podcast stuff - " . $mediatype . " feed";
$SUBTITLE       = "podcast radio claim here";
$AUPHONICDIR    = "/var/www/podcasts";

#-----------------------------------------------------------------------------
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

<channel>
<atom:link href="<?php echo $FEEDURL; ?>" rel="self" type="application/rss+xml" />
<title><?php echo $PODCASTTITLE; ?></title>
<link><?php echo $FEEDURL; ?></link>
<description><![CDATA[<?php echo $SUBTITLE; ?>]]></description>
<lastBuildDate><?php echo date("r", filemtime($AUPHONICDIR)); ?></lastBuildDate>
<language>de</language>

<?php
header('Content-type: application/rss+xml; charset=utf-8');
include("renderauphonic.php");

$episodetemplate = "<item>\n  <title><![CDATA[*title*]]></title>\n  <link>" . $BASEURL . "</link>\n  <guid>" . $BASEURL . "?guid=*GUID*</guid>\n  <pubDate>*date_rfc822*</pubDate>\n  <description><![CDATA[ *date* <br />*summary* ]]></description>\n  *MEDIA*\n</item>\n\n";
$mediatemplate = "<enclosure type=\"audio/*EXT*\" url=\"" . $AUDIOURL . "*URL*?src=rss\" length=\"*BYTES*\" />\n";

RenderAuphonic($AUPHONICDIR . "/", $AUDIOURL, ".", $mediatype, $episodetemplate, $mediatemplate);
?>


</channel>
</rss>

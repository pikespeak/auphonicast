<?php
#------------------------------------------------------------------------------
# renderauphonic.php (library) 
# https://github.com/wyae/auphonicast/
# 2015 by Volker Tanger <volker.tanger_git@wyae.de> published under GPLv3
#------------------------------------------------------------------------------

function ReadFilenames($auphonicdir) {
        $jsfn = array();

        foreach (glob($auphonicdir . "*.json") as $filename) {
                $jsfn[] = $filename;
        }

        natsort($jsfn);
        return array_reverse($jsfn, TRUE);
}


#------------------------------------------------------------------------------

function RenderEpisode($jsondata, $template, $renderedmedia) {
        ###   "metadata": {
        ###        "album": "rsff21 - en",
        ###        "publisher": "Volker Tanger",
        ###        "subtitle": "RADIO.SF-Fantasy.de - Kreative Kpfe und phantastische Welten",
        ###        "license": "Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Germany",
        ###        "artist": "Radio SF-Fantasy.de",
        ###        "track": "Ronald D. Moore - between Writer and Producer",
        ###        "title": "sff21 en - Ronald D. Moore - between Writer and Producer",
        ###        "summary": "Ron Moore \"kennt man\" als Fan von Science-Fiction Serien. \r\nNicht? \r\nWen er da gespielt haben soll? ....1",
        ###        "url": "http://radio.sf-fantasy.de/",
        ###        "license_url": "http://creativecommons.org/licenses/by-nc-nd/3.0/de/",
        ###    },
        ###    "change_time": "2014-04-29T22:36:58.097Z",
        ###    "length": 857.0633786848073,


        $keys = array( "album", "publisher", "subtitle", "license", "artist", "track", "title", "summary", "append_chapters", "url", "license_url", "year" );

        $meta = $jsondata{"metadata"};
        foreach ( $keys as $k ) {
                $v = str_replace( "\r\n", "<p>\r\n", $meta{$k});
                $template = str_replace( "*" . $k . "*" , $v, $template);
        }

        $minuten = round( $jsondata{"length"} / 60);
        $template = str_replace( "*minutes*" , $minuten, $template);
        $datum = substr($jsondata{"change_time"},0,10);
        $template = str_replace( "*date*" , $datum, $template);
        $template = str_replace( "*GUID*" , sha1($datum . $meta{"title"}), $template);
        $template = str_replace( "*date_rfc822*" , date("r",strtotime($datum)), $template);
        $template = str_replace( "*MEDIA*" , $renderedmedia, $template);

        return $template;
}

#------------------------------------------------------------------------------

function RenderAuphonic( $AUPHONICDIR, $AUPHONICURL, $NAMEFILTER, $EXTENSION, $TEMPLATE, $MEDIATEMPLATE) {

        $jsonfilenames = ReadFilenames($AUPHONICDIR);

        foreach ($jsonfilenames as $filename) {
                $jtxnput = file_get_contents ($filename);
                if ( false !== strrpos($filename, $NAMEFILTER) ) { 
                        $jnput = json_decode($jtxnput,TRUE);
                        $mediaout = "";
                        foreach ( $jnput{"output_files"} as $o ) {
                                if ( ("descr" != $o{"format"}) and ("stats" != $o{"format"}) and (false !== strrpos($o{"filename"}, $EXTENSION)) ) {
                                        $mediaout = $mediaout . str_replace( "*BYTES*", $o{"size"},str_replace( "*EXT*", $o{"format"}, str_replace( "*URL*", $AUPHONICURL . $o{"filename"}, str_replace( "*SIZE*", $o{"size_string"}, $MEDIATEMPLATE))));
                                }
                        }
                        if ( "" != $mediaout ) {
                                echo RenderEpisode($jnput, $TEMPLATE, $mediaout);
                        }
                }
        }
}

#------------------------------------------------------------------------------

?>

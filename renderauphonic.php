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
        ###        "subtitle": "RADIO.SF-Fantasy.de - Kreative Köpfe und phantastische Welten",
        ###        "license": "Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Germany",
        ###        "artist": "Radio SF-Fantasy.de",
        ###        "track": "Ronald D. Moore - between Writer and Producer",
        ###        "title": "sff21 en - Ronald D. Moore - between Writer and Producer",
        ###        "summary": "Ron Moore \"kennt man\" als Fan von Science-Fiction Serien. \r\nNicht? \r\nWen er da gespielt haben soll? \r\n\r\nNiemanden - aber ohne ihn hätte es viele Serien gar nicht erst gegeben - oder zumindest nicht in diese Form. Und die Liste der Serien hat es in sich: Star Trek The Next Generation, Star Trek Deep Space Nine, Star Trek Voyager, Battlestar Galactica (die neue Serie), und viele mehr. Hatte er bei TNG zuerst \"nur\" als einfacher Drehbuchschreiber angefangen, so war er später hauptverantwortlicher Autor und Produzent.\r\n\r\nNur: wie kommt man zu so einem Job? Wie hält man Business und Ideen auseinander? Wie arbeitet man eigentlich als Drehbuchautor und wie unterscheidet sich das von den Kollegen, die Romane schreiben? \r\n\r\nFragen über Fragen - und wir haben die Antworten.\r\n;-)\r\n\r\n(Podcast und Interview sind komplett in englischer Sprache)\r\n\r\nIMDB-Eintrag von Ronald D. Moore\r\nhttp://www.imdb.com/name/nm0601822/?ref_=fn_al_nm_1",
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
        $template = str_replace( "*date_rfc822*" , date(DATE_RFC822,strtotime($datum)), $template);
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

# auphonicast
Automatically creates podcast web page and feed from Auphonic provided files.

Auphonic is a cloud service that enhances and (acoustically) levels/compresses input files and creates output files (mp3, ogg, opus) according to your specification.
You can configure the service to push the created audio files to your server (e.g. via SFTP). If so, it can create a statistics and description JSON file for each batch that is published there too.

Auphonicast is a PHP script that runs through these files and creates a web page and rss feed from these.
Once set up you only need to provide the title, description and podcast audio to auphonic, and publishing is automatic.

	https://github.com/wyae/auphonicast/                http://www.wyae.de/
	2015 by Volker Tanger <volker.tanger_git@wyae.de> published under GPLv3



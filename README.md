PHP-movie-database
=======================
PHP-movie-database is a movie database script written in PHP.

Tested on
-------------------------
The script is tested on both a local (virtual) Ubuntu 12.10 server with:
* PHP 5.4.6
* MySQL 5.5.29
* Apache 2.2.22

and on 000webhost.com with:
* PHP 5.2.*
* MySQL 5.1
* Apache 2.2.19

You have to do the following for the script to work:
-------------------------
* Download [Twitter Bootstrap](http://twitter.github.com/bootstrap/), created with 2.3.1
 * Just copy it straight to the script folder
* Download [PHP IMDb Scraper](http://web3o.blogspot.se/2010/10/php-imdb-scraper-for-new-imdb-template.html), tested with update Feb 20 - 2013
 * Copy it to the class/ directory

When uploaded to your webpage will you need to make the director img/posters/ writable as it is the folder where the posters will be saved by the script.

TODO:
-------------------------
[] Install script (for database)
[] Admin zon?
[] Possibility to mark seen movies, comment and rate them 
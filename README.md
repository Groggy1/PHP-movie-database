PHP-movie-database
=======================
PHP-movie-database is a movie database script written in PHP.

Major overhaul of the script. If installed before, database structure is changed.

Tested on
-------------------------
The script is tested on both a local Rasbian server with:
* PHP 5.4.36
* MySQL 5.5.41
* Apache 2.2.22

and on mebo.se with:
* PHP 5.4.37
* MySQL 5.5.40
* Apache 2.4.12

You have to do the following for the script to work:
-------------------------
* Download [Twitter Bootstrap](http://twitter.github.com/bootstrap/), created with 3.1
 * Just copy it straight to the script folder
* Download [PHP IMDb Scraper](http://web3o.blogspot.se/2010/10/php-imdb-scraper-for-new-imdb-template.html), tested with update May 6, 2014 
 * Copy it to the class/ directory
* Change MySQL account information and script path in file config/config.php
* When uploaded to your webpage will you need to make the director public/img/posters/ writable as it is the folder where the posters will be saved by the script

Licence
-------------------------
[![Creative Commons License](http://i.creativecommons.org/l/by-sa/3.0/88x31.png)](http://creativecommons.org/licenses/by-sa/3.0/deed.en_US)


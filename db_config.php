<?php

// Path on the filesystem where the blacknova files
// will reside:
$gameroot = "/home/bob/public_html/bnt";

// The ADOdb db module is now required to run BNT. You
// can find it at http://php.weblogs.com/ADODB. Enter the
// path where it is installed here. I suggest simply putting
// every ADOdb file in a subdir of BNT.
$ADOdbpath = "backends/adodb";

// Domain & path of the game on your webserver (used to validate login cookie)
// This is the domain name part of the URL people enter to access your game.
// So if your game is at www.blah.com you would have:
// $gamedomain = "www.blah.com";
// Do not enter slashes for $gamedomain or anything that would come after a slash
// if you get weird errors with cookies then make sure the game domain has TWO dots
// i.e. if you reside your game on http://www.blacknova.net put .blacknova.net as $gamedomain. If your game is on http://www.some.site.net put .some.site.net as your game domain. Do not put port numbers in $gamedomain.
$gamedomain = ".127.0.0.1";

// This is the trailing part of the URL, that is not part of the domain.
// If you enter www.blah.com/blacknova to access the game, you would leave the line as it is.
// If you do not need to specify blacknova, just enter a single slash eg:
// $gamepath = "/";
$gamepath = "/";

// Hostname and port of the database server:
// These are defaults, you normally won't have to change them
$dbhost = getenv('BNT_DATABASE_HOST') ?: 'db';

// Note : if you do not know the port, set this to "" for default. Ex, MySQL default is 3306
$dbport = getenv('BNT_DATABASE_PORT') ?: '3306';

// Username and password to connect to the database:
$dbuname = getenv('BNT_DATABASE_USERNAME') ?: 'root';
$dbpass = getenv('BNT_DATABASE_PASSWORD') ?: 'root';

// Name of the SQL database:
$dbname = getenv('BNT_DATABASE_NAME') ?: 'bnt';

// Type of the SQL database. Supported drivers include:
// "mysqli" for MySQL / MariaDB via MySQLi
// "pdo_mysql" for MySQL / MariaDB via PDO
// "postgres" for PostgreSQL
// "sqlite" for SQLite
$db_type = getenv('BNT_DATABASE_TYPE') ?: 'mysqli';

// Set this to 1 to use db persistent connections, 0 otherwise - persistent connections can cause load problems!
$db_persistent = 0;

/* Table prefix for the database. If you want to run more than
one game of BNT on the same database, or if the current table
names conflict with tables you already have in your db, you will
need to change this */
$db_prefix = getenv('BNT_DATABASE_PREFIX') ?: 'bnt_';

// Character set for the database connection:
$db_charset = getenv('BNT_DATABASE_CHARSET') ?: 'utf8mb4';

// Administrator's password and email:
// Be sure to change these. Don't leave them as is.
$adminpass = getenv('BNT_ADMIN_PASSWORD') ?: 'secret';
$admin_mail = getenv('BNT_ADMIN_EMAIL') ?: 'admin@example.com';
$adminname = getenv('BNT_ADMIN_NAME') ?: 'Admin Name';

// Address the forum link, link's to:
$link_forums = "http://forums.blacknova.net";
?>

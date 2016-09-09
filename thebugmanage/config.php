<?php
// HTTP

//define('HTTP_CATALOG', 'http://www.isportmart.com/');

if (strpos($_SERVER['HTTP_HOST'], '203.149.') !== false ) {
	define('HTTP_SERVER', 'http://' . $_SERVER['HTTP_HOST']. '/ishop/thebugmanage/');
	define('HTTP_CATALOG', 'http://' . $_SERVER['HTTP_HOST']. '/ishop/');

	define('HTTPS_SERVER', 'https://' . $_SERVER['HTTP_HOST']. '/ishop/thebugmanage/');
	define('HTTPS_CATALOG', 'https://' . $_SERVER['HTTP_HOST']. '/ishop/');
	
} else {
	define('HTTP_SERVER', 'https://' . $_SERVER['HTTP_HOST']. '/thebugmanage/');
	define('HTTP_CATALOG', 'https://' . $_SERVER['HTTP_HOST']. '/');

	define('HTTPS_SERVER', 'https://' . $_SERVER['HTTP_HOST']. '/thebugmanage/');
	define('HTTPS_CATALOG', 'https://' . $_SERVER['HTTP_HOST']. '/');	
}

// DIR
define('DIR_APPLICATION', '/var/www/html/ishop/thebugmanage/');
define('DIR_SYSTEM', '/var/www/html/ishop/system/');
define('DIR_LANGUAGE', '/var/www/html/ishop/thebugmanage/language/');
define('DIR_TEMPLATE', '/var/www/html/ishop/thebugmanage/view/template/');
define('DIR_CONFIG', '/var/www/html/ishop/system/config/');
define('DIR_IMAGE', '/var/www/html/ishop/image/');
define('DIR_CACHE', '/var/www/html/ishop/system/cache/');
define('DIR_DOWNLOAD', '/var/www/html/ishop/system/download/');
define('DIR_UPLOAD', '/var/www/html/ishop/system/upload/');
define('DIR_LOGS', '/var/www/html/ishop/system/logs/');
define('DIR_MODIFICATION', '/var/www/html/ishop/system/modification/');
define('DIR_CATALOG', '/var/www/html/ishop/catalog/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'ishop');
define('DB_PASSWORD', 'Ishop#123');
define('DB_DATABASE', 'ishop');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');

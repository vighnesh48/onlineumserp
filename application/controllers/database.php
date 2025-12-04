<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	//'hostname' => '35.200.154.231:3306',
	//'hostname' => '34.93.76.173:3306',
	'hostname' => '34.93.155.183:3306',
	//'port' => '3306',
	'username' => 'root',
	'password' => 'Uni@123',
	'database' => 'sandipun_erp',
	'dbdriver' => 'mysql',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
//$db['otherdb']['hostname'] = "35.200.154.231";
//$db['otherdb']['hostname'] = "34.93.76.173";
$db['otherdb']['hostname'] = "34.93.155.183";
$db['otherdb']['username'] = "root";
$db['otherdb']['password'] = "Uni@123";
$db['otherdb']['database'] = "sandipun_attendance";
$db['otherdb']['dbdriver'] = "mysql";
$db['otherdb']['dbprefix'] = "";
$db['otherdb']['pconnect'] = TRUE;
$db['otherdb']['db_debug'] = FALSE;
$db['otherdb']['cache_on'] = FALSE;
$db['otherdb']['cachedir'] = "";
$db['otherdb']['char_set'] = "utf8";
$db['otherdb']['dbcollat'] = "utf8_general_ci";
$db['otherdb']['swap_pre'] = "";
$db['otherdb']['autoinit'] = TRUE;
$db['otherdb']['stricton'] = FALSE;


//$db['umsdb']['hostname'] = "35.200.154.231";
//$db['umsdb']['hostname'] = "34.93.76.173";
$db['umsdb']['hostname'] = "34.93.155.183";
$db['umsdb']['username'] = "root";
$db['umsdb']['password'] = "Uni@123";
$db['umsdb']['database'] = "sandipun_ums";
$db['umsdb']['dbdriver'] = "mysql";
$db['umsdb']['dbprefix'] = "";
$db['umsdb']['pconnect'] = TRUE;
$db['umsdb']['db_debug'] = FALSE;
$db['umsdb']['cache_on'] = FALSE;
$db['umsdb']['cachedir'] = "";
$db['umsdb']['char_set'] = "utf8";
$db['umsdb']['dbcollat'] = "utf8_general_ci";
$db['umsdb']['swap_pre'] = "";
$db['umsdb']['autoinit'] = TRUE;
$db['umsdb']['stricton'] = FALSE;


//$db['univerdb']['hostname'] = "35.200.154.231";
//$db['univerdb']['hostname'] = "34.93.76.173";
$db['univerdb']['hostname'] = "34.93.155.183";
$db['univerdb']['username'] = "root";
$db['univerdb']['password'] = "Uni@123";
$db['univerdb']['database'] = "sandipun_univerdb";
$db['univerdb']['dbdriver'] = "mysql";
$db['univerdb']['dbprefix'] = "";
$db['univerdb']['pconnect'] = TRUE;
$db['univerdb']['db_debug'] = FALSE;
$db['univerdb']['cache_on'] = FALSE;
$db['univerdb']['cachedir'] = "";
$db['univerdb']['char_set'] = "utf8";
$db['univerdb']['dbcollat'] = "utf8_general_ci";
$db['univerdb']['swap_pre'] = "";
$db['univerdb']['autoinit'] = TRUE;
$db['univerdb']['stricton'] = FALSE;


//$db['icdb']['hostname'] = "35.200.154.231";
//$db['icdb']['hostname'] = "34.93.76.173";
$db['icdb']['hostname'] = "34.93.155.183";
$db['icdb']['username'] = "root";
$db['icdb']['password'] = "Uni@123";
$db['icdb']['database'] = "sandipun_ic_erp";
$db['icdb']['dbdriver'] = "mysql";
$db['icdb']['dbprefix'] = "";
$db['icdb']['pconnect'] = TRUE;
$db['icdb']['db_debug'] = FALSE;
$db['icdb']['cache_on'] = FALSE;
$db['icdb']['cachedir'] = "";
$db['icdb']['char_set'] = "utf8";
$db['icdb']['dbcollat'] = "utf8_general_ci";
$db['icdb']['swap_pre'] = "";
$db['icdb']['autoinit'] = TRUE;
$db['icdb']['stricton'] = FALSE;

//$db['suadmin']['hostname'] = "35.200.154.231";
//$db['suadmin']['hostname'] = "34.93.76.173";
$db['suadmin']['hostname'] = "34.93.155.183";
$db['suadmin']['username'] = "root";
$db['suadmin']['password'] = "Uni@123";
$db['suadmin']['database'] = "sandipun_admin";
$db['suadmin']['dbdriver'] = "mysql";
$db['suadmin']['dbprefix'] = "";
$db['suadmin']['pconnect'] = TRUE;
$db['suadmin']['db_debug'] = FALSE;
$db['suadmin']['cache_on'] = FALSE;
$db['suadmin']['cachedir'] = "";
$db['suadmin']['char_set'] = "utf8";
$db['suadmin']['dbcollat'] = "utf8_general_ci";
$db['suadmin']['swap_pre'] = "";
$db['suadmin']['autoinit'] = TRUE;
$db['suadmin']['stricton'] = FALSE;



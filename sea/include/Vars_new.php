<?php
/**
 * Vars.php system configuration file
 *
 * You will need to review the variables in this file and
 * make changes as necessary for your environment.
 *
 * $I/home/chandru/public_html vars.php
 */

/**
 *  Database Connection info for the system
 *
 *  You need to create a database, add a user, and grant permissions.
 *  @example:  from a mysql prompt
 *  create database [DATABASE_NAME];
 *  grant all privileges on [DATABASE_NAME].* to [USER_NAME]@localhost identified by 'yourpasswordhere';
 *
 *  After you've created the database and database user,
 *  follow the instructions in the install/INSTALL file
 *  and on the screen in the install scripts.
 */

// Report all errors except E_NOTICE
// This is the default value set in php.ini
//error_reporting(E_ERROR);

//uncomment the next line to turn notices on
error_reporting(E_ALL);

$system_db_dbtype = 'mysql';
$system_db_server = 'myst-my-p.cns.iit.edu';
$system_db_username = 'csep';
$system_db_password = 'ec1976!';
$system_db_dbname = 'csep2';

// where is this application, web-wise? (no trailing slash)
//$http_site_root = "http://[SERVER]/[APP_NAME]";

$http_site_root = "http://ethics.iit.edu/sea/";
//where is the appliation in the filesystem (no trailing slash)
$system_file_root = "/export/arachne/widow/usr1/csep/csep/Web/";

$system_css_directory="http://ethics.iit.edu/sea/";
$FCKEditorBasePath = "http://ethics.iit.edu/include/fckeditor/";

// WHEN MOVING TO PRODUCTION --------------------->
// Make sure that $system_file_root and $system_css_directory variables are updated
// in /include/FCKeditor/editor/filemanager/browser/default/connectors/php/config.php-
// AND /include/FCKeditor/editor/filemanager/php/config.php

$max_file_size = 51200000;

// directory where uploaded files should go
// make sure these directories are writable

$tmp_upload_directory = "C:/Chandru/Project/Application/tmp/";
$library_storage_directory = "C:/Chandru/Project/Application/files/storage/";
$file_storage_directory = "C:/Chandru/Project/Application/files/storage/";



$system_storage_directory="http://ethics.iit.edu/storage/";

//Smarty configuration files
$template_directory = "C:/Chandru/Project/Application/Templates";
$template_config = "C:/Chandru/Project/Application/include/smarty/smarty_config";
$template_cache_directory = "C:/Chandru/Project/Application/include/smarty/smarty_cache";
$template_compile_directory = "C:/Chandru/Project/Application/include/smarty/smarty_templates_c";

//uncomment this if you are having trouble with file uploads
//ini_set ('upload_tmp_dir', $tmp_upload_directory);

// directory for exports
// directory must be writable ,
// and should not be world readable
// this needs to be relative to the system web root
// (browser needs to be able to see it)
// (no trailing slash)
$tmp_export_directory = "/export/";

// accounting software integration is in the works, but for now
$accounting_system = ''; // no integration

// if you have more than one Application installation,
// these need to be unique so that users logged in to one
// application can't just start using the other one.
// This variable sets "scope" to the user's login.
$system_id = "Application";

// what should this application be called?
$app_title = '';

// set the default country
// 100 is usually India, for example
$default_country_id = 100;

// so that order numbers can be continuous with whatever you're using now
$order_number_seed = 1000;

// a few user-definable settings (there should be lots more)
$system_rows_per_page = 15;
$how_many_rows_to_import_per_page = 10;
$recent_items_limit = 5;


// Default Password to be set while new user creation
$defaultPassword = "welcome";

//Number of records/rows to be displayed per page

$rows_per_page = 12;
/* STYLE OPTIONS */

/*Used to specifiy the image in header */

//$headerImage = $http_site_root."images//csep_new.bmp";

/*Used to specify the horizontal menubar */
$populateTopLinks = " ";
?>

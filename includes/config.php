<?php

@session_start();
error_reporting(E_ALL); // reporta todos los errores
//error_reporting(0); // no reporta ningún error
//error_reporting(E_ALL ^ E_NOTICE); // reporta todo menos los notices

ini_set("display_errors", 1);
setlocale(LC_ALL, 'es_CO');
date_default_timezone_set("America/Bogota");

define ('ABUS_DB_NAME', 'abus');
define ('ABUS_HOST', 'localhost');
define ('ABUS_USER', 'root');
define ('ABUS_PASS', '');

require ("class/application.class.php");
require ("globals.php");

mysql_connect(ABUS_HOST, ABUS_USER, ABUS_PASS);
if (!mysql_select_db(ABUS_DB_NAME)) {
    Application :: showApplicationError($messages["general_site_error"]);
}

mysql_query("SET NAMES 'utf8'");

$dataAppPublic = Application :: getInformationApp($_SESSION["lang"]);

$appMenuPublic = Application :: getAppMenu(1, $_SESSION["lang"]);
$countMenuPublic = count($appMenuPublic);

$app_background_public = '';
if ($dataAppPublic->app_background_type == 2) {//image
    $path_bg = 'file_upload/background/' . $dataAppPublic->app_background;
    if (file_exists($path_bg)) {
        $app_background_public = 'background-image: url(/' . $path_bg . '); ';
        $app_background_public .= 'background-position: center top; ';
        $app_background_public .= 'background-attachment: fixed; ';

        $app_background_public .= 'background-repeat: no-repeat; ';
        $app_background_public .= '-webkit-background-size: cover; ';
        $app_background_public .= '-moz-background-size: cover; ';
        $app_background_public .= '-o-background-size: cover; ';
        $app_background_public .= 'background-size: cover; ';
    }
} elseif ($dataAppPublic->app_background_type == 1 || $dataAppPublic->app_background_type == 3) {//color
    $app_background_public = 'background-color: ' . $dataAppPublic->app_background_color . ';';
}

$meta_autor_value = "Sebastián Lara";
$meta_description_value = "";
$meta_keywords_value = $dataAppPublic->app_keywords;
$meta_bussiness_name = "";
?>
<?php

/**
 * Парсер российской базы данных ЕГРЮЛ
 * @author Mikhail Orekhov
 */
declare(ticks = 1);
error_reporting(E_ALL | E_STRICT);

require_once __DIR__ . "/classes/Db.php";
require_once __DIR__ . "/classes/RobotLog.php";
require_once __DIR__ . "/classes/Registry.php";
require_once __DIR__ . "/classes/Log.php";
require_once __DIR__ . "/classes/DbLink.php";
require_once __DIR__ . "/classes/HttpRequest.php";
require_once __DIR__ . "/classes/ParserTradeName.php";
require_once __DIR__ . "/classes/ParseOrg.php";
require_once __DIR__ . "/classes/ForkInit.php";
require_once __DIR__ . "/classes/RouterMode.php";
require_once __DIR__ . "/classes/RobotLog.php";
require_once __DIR__ . "/classes/Helpers.php";


$Cfg = include __DIR__ . "/cfg/cfg.php";
Registry::set($Cfg, "Cfg");
Registry::set(new Log());
try
{

    $options = getopt("t:d:k:r:u:");

    //загрузить конфиг в реестр
    
    Registry::set(new Db($Cfg['DB']['BASE']));
    //Registry::set(new Log());
    Registry::set(new RobotLog());


    Registry::get("Log")->log("Начало работы");
    //Registry::get("RobotLog")->get_range_document();
    //exit;
    
    RouterMode::execute($options);

    print Registry::get("RobotLog")->get_time_report();
}
catch (Exception $error)
{
    $errmsg = date("d.m.y H:i:s") . "\t" . $error->getMessage() . "\n";
    Registry::get("Log")->log($error->getMessage());
    file_put_contents($Cfg['ERROR_LOG'], $errmsg, FILE_APPEND);
}
?>

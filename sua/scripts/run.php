<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/applicationCli.ini'
);
$application->bootstrap();




$pbAdapter = new Zend_ProgressBar_Adapter_Console(array('elements'=>
array(Zend_ProgressBar_Adapter_Console::ELEMENT_PERCENT,
                                Zend_ProgressBar_Adapter_Console::ELEMENT_BAR,
                                Zend_ProgressBar_Adapter_Console::ELEMENT_ETA,

Zend_ProgressBar_Adapter_Console::ELEMENT_TEXT)));
$progressBar = new Zend_ProgressBar($pbAdapter, 0, 100);

for ($i = 0; $i < 100; $i++) {
   sleep(1);
   $progressBar->update($i, "Iteration: {$i}");
}
$progressBar->finish();


echo "Yes, everything is completed";
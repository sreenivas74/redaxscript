<?php
namespace Redaxscript;

use Redaxscript\Console;

error_reporting(E_ERROR || E_PARSE);

/* bootstrap */

include_once('includes/bootstrap.php');

/* command */

$command = new Console\Command(Request::getInstance());
$command->init();
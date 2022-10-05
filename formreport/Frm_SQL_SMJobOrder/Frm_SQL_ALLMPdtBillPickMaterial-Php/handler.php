<?php
require_once "stimulsoft/helper.php";

// Please configure the security level as you required.
// By default is to allow any requests from any domains.
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Engaged-Auth-Token");

$handler = new StiHandler();
$handler->registerErrorHandlers();

$handler->onPrepareVariables = function ($args) {
	return StiResult::success();
};

$handler->onBeginProcessData = function ($args) {
	if ($args->connection == "Pos")
		$args->connectionString = "Data Source=147.50.143.126,33433;Initial Catalog=FitAuto;Integrated Security=False;User ID=sa;Password=GvFhk@61";

	return StiResult::success();
};

$handler->process();
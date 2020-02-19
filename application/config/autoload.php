<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
$autoload ['packages'] = array ();
$autoload ['libraries'] = array (
	"database" 
);
$autoload ['drivers'] = array (
	'session' 
);
$autoload ['helper'] = array (
	"url",
	"datebr_helper" ,
	"nome_helper",
	"login_helper"
);
$autoload ['config'] = array ();
$autoload ['language'] = array ();
$autoload ['model'] = array ("login_model");

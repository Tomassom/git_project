<?php

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

header('Content-Type: text/html;charset=UTF-8');

session_start();


ob_start('postfix');

$contentMenu = isContent();

Template::header();
Template::body($contentMenu);

$urlCheck = SitePreferences::$lang != SitePreferences::$langMain ? uriparts(2) : uriparts(1);

echo "Hello";


if (count(uriparts()) === 2 && uriparts(1) === '') {
	$tartalom = new fooldal();
} else {
    
	switch ($urlCheck) {
	
		case "kereses" : new kereses(); break;
		case "page_404" : new page_404(); break;

		case 'logout':
			session_destroy();
			header('Location: /');
			exit;

		default:
		 
			if( $contentMenu )
            {
                new $contentMenu['osztaly']();    
            }
            else{
                header("HTTP/1.0 404 Not Found"); 
                $osztaly = 'page_404';
                new $osztaly; 
			}
	}
}

Template::footer();

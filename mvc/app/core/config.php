<?php
/* 
/ This is configretion file.
/
/ 1. database related configretions.
/ 2. Controller related configretions.
/ 3. Core related configretions.
/ 4. Model related configretions.
/ 5. URL related configretions.
*/

/* 
/ 
/ Database related configretions
/
*/
define("DB_NAME","test2");
define("DB_TYPE","mysql");
define("DB_USER","root");
define("DB_PASS","");
define("DB_HOST","localhost");

/* 
/ 
/ Title related configretions
/
*/
define("APP_NAME","YOUR_APP_NAME");
define("WEB_DOMAIN","www.yourwebsitedomain.com");

/* 
/ 
/ Them related configretions
/ if you like to change the theme of your website
*/
define("THEME_NAME","idiscuss/");

/* 
/ 
/ Error related configretions
/ DEBUG MODE
/ if DEBUG is true that mean your able to see the errors
/ or if DEBUG is false that mean errors will not display in ui
*/
define("DEBUG", true);

if(DEBUG){
    ini_set("display_errors",1);
}else{
    ini_set('display_errors',0);
}


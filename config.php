<?php
header('Access-Control-Allow-Origin: *');  
define('ENVIRONMENT', 'development');
define('APPNAME', 'codeigniter');
define('BASE_URL', 'http://localhost/ci_management');
define('LOG_PATH', '');
define('LOG_THRESHOLD',4);

# COOKIE_DOMAIN = '' in prod, or NULL in localhost.
define('COOKIE_DOMAIN', '');


# PROCTL = 'sendmail' in prod, 'smtp' in dev
define('PROCTL','smtp');


# We may not need this flag in the future.
define('IS_LIVE', FALSE);

# Email Config:
define('EMAIL_LOGO'    , '');
define('SUPERADMINEMAIL', '');
define('EMAIL_FROM'    , '');
$email_config= Array(
'protocol'  => '',
'smtp_host' => '',
'smtp_port' => '',
'smtp_user' => '',
'smtp_pass' => '',
'mailtype'  => 'html',
'newline'   => "\r\n",
'charset'   => "utf-8",
'validation'   => FALSE
); 
define('EMAIL_CONFIG',serialize($email_config));


# Master DB:
define('DB_HOST'    , 'localhost');
define('DB_PORT'    ,  3306      );
define('DB_USER'    , 'root' );
define('DB_PASSWORD', '' );
define('DB_NAME'    , 'ci_management' );

define('WSS_URL', 'ws://127.0.0.1:8889');
define('WSS_IP' , 'tcp://127.0.0.1:8889');
define('WSS_LOG' ,LOG_PATH);
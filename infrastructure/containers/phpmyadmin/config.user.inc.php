<?php
$i = 0;

$i++; // server 1 :
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['host']      = 'mariadb';
$cfg['Servers'][$i]['extension'] = 'mysqli';
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i]['password'] = 'admin';

$i++;
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['host']      = 'mariadb_test';
$cfg['Servers'][$i]['extension'] = 'mysqli';
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i]['password'] = 'admin';

// end of server sections
$cfg['ServerDefault'] = 1; // to choose the server on startup

$cfg['LoginCookieValidity'] = 99999999;
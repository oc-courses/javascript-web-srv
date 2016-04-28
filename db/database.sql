create database if not exists jswebsrv character set utf8 collate utf8_unicode_ci;
use jswebsrv;

grant all privileges on jswebsrv.* to 'jswebsrv_user'@'localhost' identified by 'secret';

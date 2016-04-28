drop table if exists article;
drop table if exists comment;
drop table if exists link;

create table article (
    art_id integer not null primary key auto_increment,
    art_title varchar(100) not null,
    art_content varchar(2000) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table link (
    link_id integer not null primary key auto_increment,
    link_title varchar(200) not null,
    link_url varchar(256) not null,
    link_author varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table comment (
    com_id integer not null primary key auto_increment,
    com_content varchar(500) not null,
    com_author varchar(100) not null,
    link_id integer not null,
    constraint fk_com_art foreign key(link_id) references link(link_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;

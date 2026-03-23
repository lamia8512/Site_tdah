#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `tdahdbd`;
USE `tdahdbd`;

CREATE TABLE IF NOT EXISTS `role`(
    `id_role` Int Auto_increment NOT NULL,
    `name` Varchar (50) NOT NULL,
    CONSTRAINT `role_pk` PRIMARY KEY (`id_role`)
);

CREATE TABLE IF NOT EXISTS `user`(
    `id_user` Int Auto_increment NOT NULL,
    `pseudo` Varchar (50) NOT NULL,
    `email` Varchar (255) NOT NULL,
    `password` Varchar (255) NOT NULL,
    `creation_date` Date NOT NULL,
    `id_role` INT NOT NULL,
    CONSTRAINT `user_pk` PRIMARY KEY (`id_user`),
    CONSTRAINT `user_role_FK` FOREIGN KEY (`id_role`) REFERENCES role(id_role)
);

CREATE TABLE IF NOT EXISTS `article`(
    `id_article` Int Auto_increment NOT NULL,
    `title` Varchar (255) NOT NULL,
    `text` Text NOT NULL,
    `id_user` INT NOT NULL,
    CONSTRAINT `article_pk` PRIMARY KEY (`id_article`),
    CONSTRAINT `article_user_FK` FOREIGN KEY (`id_user`) REFERENCES user(id_user)
);

CREATE TABLE IF NOT EXISTS `comment`(
    `id_comment` Int Auto_increment NOT NULL,
    `text` Text NOT NULL,
    `creation_date` Date NOT NULL,
    `modification_date` Date,
    `id_article` INT NOT NULL,
    `id_user` INT NOT NULL,
    CONSTRAINT `comment_pk` PRIMARY KEY (`id_comment`),
    CONSTRAINT `comment_article_FK` FOREIGN KEY (`id_article`) REFERENCES article(id_article),
    CONSTRAINT `user_comment_FK` FOREIGN KEY (`id_user`) REFERENCES user(id_user)
);
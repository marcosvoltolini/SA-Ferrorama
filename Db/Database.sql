CREATE DATABASE IF NOT EXISTS SA_Ferrorama;

USE SA_Ferrorama;

CREATE TABLE IF NOT EXISTS usuarios(
    id_usuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR (100) NOT NULL,
    email_usuario VARCHAR (100) NOT NULL
);
USE SA_ferrorama;
ALTER TABLE usuarios
    ADD COLUMN senha_usuario VARCHAR(255) NOT NULL AFTER email_usuario;

ALTER TABLE usuarios
    ADD UNIQUE KEY uk_email_usuario (email_usuario);
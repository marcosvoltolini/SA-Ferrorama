CREATE DATABASE IF NOT EXISTS SA_Ferrorama;
 
USE SA_Ferrorama;
 
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario     INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_usuario   VARCHAR(100) NOT NULL,
    email_usuario  VARCHAR(100) NOT NULL,
    senha_usuario  VARCHAR(255) NOT NULL,
    tipo_usuario   ENUM('comum', 'administrador') NOT NULL DEFAULT 'comum',
    UNIQUE KEY uk_email_usuario (email_usuario)
);
INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario, tipo_usuario)
VALUES ('Marcos Voltolini', 'Marcos_Voltolini@gmail.com', 'Volto09876', 'administrador');
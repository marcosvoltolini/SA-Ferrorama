CREATE DATABASE SA_Ferrorama;
 
USE SA_Ferrorama;
 
CREATE TABLE usuarios (
    id_usuario     INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_usuario   VARCHAR(100) NOT NULL,
    email_usuario  VARCHAR(100) NOT NULL,
    senha_usuario  VARCHAR(255) NOT NULL,
    tipo_usuario   ENUM('comum', 'administrador') NOT NULL DEFAULT 'comum',
    UNIQUE KEY uk_email_usuario (email_usuario)
);


INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario, tipo_usuario)
VALUES ('Marcos Voltolini', 'Marcos_Voltolini@gmail.com', '$2y$10$9hyJKMzZRZ29RMvOmi9N7uiv61wI9Mqd6ubEK1EcIamyZ5yBZYNTO', 'administrador');
 
 USE SA_Ferrorama;

CREATE TABLE trens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tipo ENUM('Carga', 'Passageiro') NOT NULL
);

CREATE TABLE sensores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tipo ENUM('localização', 'Velocidade', 'Energia') NOT NULL,
    trem_id INT NOT NULL,
    FOREIGN KEY (trem_id) REFERENCES trens(id)
);
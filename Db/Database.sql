DROP DATABASE IF EXISTS SA_Ferrorama;
CREATE DATABASE SA_Ferrorama CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE SA_Ferrorama;

CREATE TABLE usuarios (
    id_usuario    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_usuario  VARCHAR(100) NOT NULL,
    email_usuario VARCHAR(100) NOT NULL,
    senha_usuario VARCHAR(255) NOT NULL,
    tipo_usuario  ENUM('comum', 'administrador', 'funcionario') NOT NULL DEFAULT 'comum',
    UNIQUE KEY uk_email_usuario (email_usuario)
) ENGINE=InnoDB;

CREATE TABLE trens (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    nome          VARCHAR(100) NOT NULL,
    tipo          ENUM('Carga', 'Passageiro') NOT NULL,
    imagem        VARCHAR(150) NULL,
    maquinista_id INT NULL,
    UNIQUE KEY uk_trem_nome (nome),
    UNIQUE KEY uk_trem_maquinista (maquinista_id),
    FOREIGN KEY (maquinista_id) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE rotas (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    trem_id         INT NOT NULL,
    nome            VARCHAR(100) NOT NULL,
    origem          VARCHAR(100) NOT NULL,
    destino         VARCHAR(100) NOT NULL,
    horario_partida TIME NOT NULL,
    duracao_min     INT NOT NULL,
    distancia_km    DECIMAL(8,2) NULL,
    imagem_mapa     VARCHAR(150) NULL,
    FOREIGN KEY (trem_id) REFERENCES trens(id)
) ENGINE=InnoDB;

CREATE TABLE sensores (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    nome    VARCHAR(100) NOT NULL,
    tipo    ENUM('localização', 'Velocidade', 'Energia') NOT NULL,
    trem_id INT NOT NULL,
    FOREIGN KEY (trem_id) REFERENCES trens(id)
) ENGINE=InnoDB;

INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario, tipo_usuario)
VALUES ('Marcos Voltolini', 'Marcos_Voltolini@gmail.com', '$2y$10$9hyJKMzZRZ29RMvOmi9N7uiv61wI9Mqd6ubEK1EcIamyZ5yBZYNTO', 'administrador');

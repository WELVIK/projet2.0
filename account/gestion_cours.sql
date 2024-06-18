CREATE DATABASE fitnessdb;
USE fitnessdb;

CREATE TABLE administrateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_naissance DATE,
    genre VARCHAR(10),
    adresse VARCHAR(255),
    telephone VARCHAR(20),
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    description TEXT,
    duree INT NOT NULL, -- Durée en minutes
    niveau VARCHAR(50),
    date_heure TIMESTAMP,
    coach_id INT,
    FOREIGN KEY (coach_id) REFERENCES utilisateurs(id)
);

CREATE TABLE abonnements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_abonnement VARCHAR(50) NOT NULL, -- Par exemple : Mensuel, Annuel
    prix DECIMAL(10, 2) NOT NULL,
    description TEXT
);

CREATE TABLE utilisateur_abonnement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    abonnement_id INT,
    date_debut DATE,
    date_fin DATE,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (abonnement_id) REFERENCES abonnements(id)
);

CREATE TABLE inscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    cours_id INT,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (cours_id) REFERENCES cours(id)
);

CREATE TABLE coachs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    specialite VARCHAR(100),
    experience INT, -- Années d'expérience
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);

INSERT INTO administrateurs (nom, prenom, login, password) VALUES ('Admin', 'User', 'admin', 'adminpass');

INSERT INTO abonnements (type_abonnement, prix, description) VALUES ('Mensuel', 30.00, 'Accès illimité aux cours pendant un mois');
INSERT INTO abonnements (type_abonnement, prix, description) VALUES ('Annuel', 300.00, 'Accès illimité aux cours pendant un an');

INSERT INTO cours (titre, description, duree, niveau, date_heure, coach_id) VALUES ('Yoga pour débutants', 'Séance de yoga pour débutants', 60, 'Débutant', '2024-07-01 10:00:00', 1);
INSERT INTO cours (titre, description, duree, niveau, date_heure, coach_id) VALUES ('Pilates intermédiaire', 'Séance de Pilates de niveau intermédiaire', 45, 'Intermédiaire', '2024-07-02 14:00:00', 2);

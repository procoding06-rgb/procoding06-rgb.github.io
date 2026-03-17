-- ============================================================
--  BASE DE DONNÉES — Quasi-Paroisse Sainte Élisabeth du Municipal
--  Bouaké, Côte d'Ivoire
-- ============================================================
CREATE DATABASE IF NOT EXISTS eglise_ste_elisabeth CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE eglise_ste_elisabeth;

-- Administrateurs
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    role ENUM('super_admin','admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- NOTE: Le mot de passe est géré dans admin_password.php (fichier séparé)
-- Email : saintelisabeth@gmail.com | Mot de passe : CURE@2026
INSERT INTO admins (nom, email, role) VALUES
('Super Administrateur', 'saintelisabeth@gmail.com', 'super_admin');

-- Actualités
CREATE TABLE IF NOT EXISTS actualites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    image VARCHAR(255),
    categorie ENUM('annonce','activite','temoignage','message_cure') DEFAULT 'annonce',
    publie TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Événements
CREATE TABLE IF NOT EXISTS evenements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    date_debut DATE NOT NULL,
    date_fin DATE,
    heure VARCHAR(20),
    lieu VARCHAR(255),
    type ENUM('messe','pelerinage','retraite','marche','autre') DEFAULT 'autre',
    publie TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Horaires des messes
CREATE TABLE IF NOT EXISTS horaires_messes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jour VARCHAR(50) NOT NULL,
    heure VARCHAR(20) NOT NULL,
    type_messe VARCHAR(100),
    remarque VARCHAR(255),
    ordre INT DEFAULT 0
);

-- Galerie
CREATE TABLE IF NOT EXISTS galerie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255),
    image VARCHAR(255),
    album VARCHAR(100),
    type ENUM('photo','video') DEFAULT 'photo',
    lien_video VARCHAR(500),
    publie TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Documents
CREATE TABLE IF NOT EXISTS documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    fichier VARCHAR(255) NOT NULL,
    type ENUM('feuille_messe','bulletin','formulaire','autre') DEFAULT 'autre',
    publie TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Mouvements
CREATE TABLE IF NOT EXISTS mouvements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200) NOT NULL,
    description TEXT,
    responsable VARCHAR(150),
    contact VARCHAR(100),
    image VARCHAR(255),
    categorie ENUM('catechese','jeunes','chorale','priere','association') DEFAULT 'association',
    publie TINYINT(1) DEFAULT 1
);

-- Formulaires (demandes sacrements, inscriptions, etc.)
CREATE TABLE IF NOT EXISTS formulaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_formulaire ENUM('bapteme','communion','confirmation','mariage','catechese','autre') DEFAULT 'autre',
    nom_complet VARCHAR(150) NOT NULL,
    email VARCHAR(150),
    telephone VARCHAR(30),
    date_naissance DATE,
    nom_parrain VARCHAR(150),
    nom_marraine VARCHAR(150),
    message TEXT,
    statut ENUM('en_attente','traite','rejete') DEFAULT 'en_attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Paiements
CREATE TABLE IF NOT EXISTS paiements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reference VARCHAR(50) UNIQUE NOT NULL,
    nom_payeur VARCHAR(150),
    telephone VARCHAR(30),
    email VARCHAR(150),
    montant DECIMAL(10,2) NOT NULL,
    methode ENUM('orange_money','mtn_money','moov_money','wave','carte_bancaire') NOT NULL,
    motif ENUM('don','denier','offrande','projet','formulaire','autre') DEFAULT 'don',
    statut ENUM('en_attente','confirme','echoue') DEFAULT 'en_attente',
    transaction_id VARCHAR(100),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dons (liés aux paiements)
CREATE TABLE IF NOT EXISTS dons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paiement_id INT,
    nom_donateur VARCHAR(150),
    montant DECIMAL(10,2),
    type_don ENUM('denier','offrande','projet') DEFAULT 'offrande',
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (paiement_id) REFERENCES paiements(id) ON DELETE SET NULL
);

-- Paramètres
CREATE TABLE IF NOT EXISTS parametres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cle VARCHAR(100) UNIQUE NOT NULL,
    valeur TEXT
);

-- ============================================================
--  DONNÉES INITIALES
-- ============================================================

INSERT INTO parametres (cle, valeur) VALUES
('nom_eglise',     'Quasi-Paroisse Sainte Élisabeth du Municipal'),
('ville',          'Bouaké, Côte d\'Ivoire'),
('adresse',        'Quartier Municipal, Bouaké'),
('telephone',      '+225 07 98 87 64 17'),
('email',          'saintelisabeth@gmail.com'),
('facebook',       'https://web.facebook.com/quasi.paroisse.sainte.elisabeth.2025'),
('mot_bienvenue',  'Bienvenue dans notre communauté de foi, d\'espérance et de charité. La Quasi-Paroisse Sainte Élisabeth du Municipal vous accueille avec joie.'),
('diocese',        'Diocèse de Bouaké'),
('cure',           'R.P. Administrateur Paroissial'),
('orange_money',   '+225 07 98 87 64 17'),
('mtn_money',      '+225 05 74 21 85 83'),
('moov_money',     '+225 XX XX XX XX'),
('wave',           '+225 07 98 87 64 17');

INSERT INTO horaires_messes (jour, heure, type_messe, ordre) VALUES
('Dimanche',      '7h30',           'Messe dominicale',           1),
('Dimanche',      '10h00',          'Messe dominicale solennelle', 2),
('Samedi',        '18h30',          'Messe de la vigile',          3),
('Vendredi',      '06h30',          'Messe de semaine',            4),
('Jours de fête', 'Selon programme','Messe de fête',               5);

INSERT INTO mouvements (nom, description, categorie) VALUES
('Catéchèse des enfants', 'Formation chrétienne des enfants en vue des sacrements', 'catechese'),
('Pastorale des Jeunes',  'Accompagnement spirituel et humain de la jeunesse',       'jeunes'),
('Chorale Sainte Cécile', 'Animation liturgique des célébrations',                   'chorale'),
('Chapelet vivant',       'Groupe de prière du rosaire',                             'priere'),
('Légion de Marie',       'Association mariale au service de l\'Église',             'association');

INSERT INTO evenements (titre, description, date_debut, heure, lieu, type) VALUES
('Messe du dimanche',  'Célébration eucharistique dominicale',   CURDATE(), '10h00', 'Église Sainte Élisabeth', 'messe'),
('Adoration nocturne', 'Nuit d\'adoration eucharistique mensuelle', DATE_ADD(CURDATE(), INTERVAL 7 DAY), '21h00', 'Chapelle paroissiale', 'autre');

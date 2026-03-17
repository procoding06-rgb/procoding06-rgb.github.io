# 🏛️ Quasi-Paroisse Sainte Élisabeth du Municipal — Bouaké
## Guide complet d'installation (WampServer + Visual Studio Code)

---

## 🔐 IDENTIFIANTS ADMINISTRATEUR

| Champ | Valeur |
|-------|--------|
| **Email** | `saintelisabeth@gmail.com` |
| **Mot de passe** | `CURE@2026` |
| **URL Admin** | `http://localhost/eglise/admin/login.php` |

> Le mot de passe est stocké dans le fichier **`admin_password.php`** (fichier séparé et sécurisé).

---

## 🖥️ INSTALLATION PAS À PAS (WampServer + VS Code)

### ÉTAPE 1 — Installer WampServer
1. Téléchargez WampServer sur : https://www.wampserver.com
2. Installez-le (dossier par défaut : `C:\wamp64\`)
3. Lancez WampServer → l'icône dans la barre des tâches doit devenir **VERTE**
4. Si l'icône reste orange, vérifiez que les ports 80 et 3306 sont libres

### ÉTAPE 2 — Copier les fichiers du site
1. Ouvrez l'Explorateur Windows
2. Naviguez vers : `C:\wamp64\www\`
3. **Créez un dossier** nommé `eglise`
4. **Copiez tout le contenu** du ZIP dans `C:\wamp64\www\eglise\`

La structure doit ressembler à :
```
C:\wamp64\www\eglise\
    ├── index.php
    ├── admin_password.php   ← FICHIER MOT DE PASSE SÉPARÉ
    ├── database.sql
    ├── admin\
    ├── pages\
    ├── includes\
    └── assets\
```

### ÉTAPE 3 — Créer la base de données
1. Ouvrez votre navigateur et allez sur : **http://localhost/phpmyadmin**
2. Cliquez sur **"Nouvelle base de données"** (colonne de gauche)
3. Tapez le nom : `eglise_ste_elisabeth`
4. Choisissez l'interclassement : `utf8mb4_unicode_ci`
5. Cliquez **Créer**
6. Dans la base créée, cliquez sur l'onglet **Importer**
7. Cliquez **Choisir un fichier** → sélectionnez `C:\wamp64\www\eglise\database.sql`
8. Cliquez **Importer** en bas de page
9. ✅ Vous devriez voir "Importation réussie"

### ÉTAPE 4 — Configurer le fichier config.php
1. Dans Visual Studio Code, ouvrez le dossier `C:\wamp64\www\eglise\`
2. Ouvrez le fichier `includes\config.php`
3. Vérifiez/modifiez ces lignes selon votre configuration :

```php
define('DB_HOST', 'localhost');          // Ne pas changer
define('DB_USER', 'root');              // Utilisateur WampServer par défaut
define('DB_PASS', '');                  // Mot de passe vide par défaut sur WampServer
define('DB_NAME', 'eglise_ste_elisabeth');  // Nom de votre BDD
define('SITE_URL', 'http://localhost/eglise');  // URL de votre site
```

### ÉTAPE 5 — Ouvrir le projet dans VS Code
1. Lancez **Visual Studio Code**
2. Menu **Fichier** → **Ouvrir un dossier**
3. Naviguez vers `C:\wamp64\www\eglise\`
4. Cliquez **Sélectionner un dossier**
5. Le projet s'ouvre dans l'explorateur de VS Code

### ÉTAPE 6 — Accéder au site
Ouvrez votre navigateur et entrez :
- **Site public** : http://localhost/eglise/
- **Administration** : http://localhost/eglise/admin/login.php
  - Email : `saintelisabeth@gmail.com`
  - Mot de passe : `CURE@2026`

---

## 🔧 EXTENSIONS VS CODE RECOMMANDÉES

Installez ces extensions pour un meilleur confort de travail :

1. **PHP Intelephense** — Autocomplétion PHP intelligente
2. **PHP Debug** — Débogage PHP
3. **HTML CSS Support** — Support HTML/CSS avancé
4. **Prettier** — Formatage automatique du code
5. **Live Server** — (pour les fichiers HTML statiques)
6. **MySQL** (par cweijan) — Gérer la BDD depuis VS Code

Pour installer : `Ctrl+Shift+X` → recherchez le nom → cliquez Installer

---

## 📁 STRUCTURE DES FICHIERS

```
eglise/
├── index.php                    ← Page d'accueil
├── database.sql                 ← Script de la base de données
├── admin_password.php           ← ⚠️ FICHIER MOT DE PASSE SÉPARÉ
├── README.md                    ← Ce guide
│
├── includes/
│   ├── config.php               ← Configuration + connexion BDD
│   ├── header.php               ← En-tête + navigation
│   └── footer.php               ← Pied de page
│
├── pages/
│   ├── paroisse.php             ← La Paroisse
│   ├── celebrations.php         ← Messes & Prières
│   ├── sacrements.php           ← Les 5 Sacrements
│   ├── pastorales.php           ← Mouvements
│   ├── actualites.php           ← Actualités
│   ├── actualite_detail.php     ← Détail actualité
│   ├── agenda.php               ← Agenda
│   ├── galerie.php              ← Galerie photos
│   ├── documents.php            ← Documents
│   ├── formulaires.php          ← ✨ NOUVEAU — Inscriptions & demandes
│   ├── paiement.php             ← ✨ NOUVEAU — Paiement mobile money
│   ├── don.php                  ← Faire un don
│   └── contact.php              ← Contact
│
├── admin/
│   ├── login.php                ← Connexion admin
│   ├── logout.php               ← Déconnexion
│   ├── dashboard.php            ← Tableau de bord
│   ├── actualites.php           ← Gestion actualités
│   ├── evenements.php           ← Gestion événements
│   ├── galerie.php              ← Gestion galerie
│   ├── documents.php            ← Gestion documents
│   ├── mouvements.php           ← Gestion mouvements
│   ├── formulaires.php          ← ✨ NOUVEAU — Gestion formulaires
│   ├── paiements.php            ← ✨ NOUVEAU — Gestion paiements
│   ├── horaires.php             ← Horaires messes
│   ├── dons.php                 ← Suivi dons
│   ├── parametres.php           ← Paramètres
│   ├── admin_header.php         ← En-tête admin
│   └── admin_footer.php         ← Pied de page admin
│
└── assets/
    ├── css/style.css            ← CSS principal
    ├── js/main.js               ← JavaScript
    └── images/uploads/          ← Images uploadées
```

---

## 💳 SYSTÈME DE PAIEMENT

Le site intègre 5 moyens de paiement :

| Méthode | Comment ça marche |
|---------|-------------------|
| 🟠 **Orange Money** | `#144#` → Transfert → Numéro paroisse |
| 🟡 **MTN Money** | `*133#` → Transfert → Numéro paroisse |
| 🔵 **Moov Money** | `*555#` → Flooz Transfert → Numéro paroisse |
| 🩵 **Wave** | App Wave → Envoyer → Numéro paroisse |
| 💳 **Carte bancaire** | Virement ou paiement au secrétariat |

**Pour configurer les numéros** : Admin → Paramètres → numéros opérateurs

**Processus** :
1. L'utilisateur remplit le formulaire
2. Il est redirigé vers la page de paiement
3. Il choisit son opérateur et reçoit les instructions
4. Il effectue le paiement chez l'opérateur
5. Il entre son numéro de transaction
6. L'admin confirme le paiement dans le tableau de bord

---

## 🔑 CHANGER LE MOT DE PASSE ADMIN

1. Ouvrez `admin_password.php`
2. Changez `ADMIN_PASSWORD_RAW` avec votre nouveau mot de passe
3. Ouvrez cette URL dans votre navigateur pour générer le hash :
   - http://localhost/eglise/generer_hash.php?mdp=VOTRE_NOUVEAU_MDP
4. Copiez le hash généré dans `ADMIN_PASSWORD_HASH`
5. Supprimez `generer_hash.php` après usage

---

## ❓ PROBLÈMES FRÉQUENTS

| Problème | Solution |
|----------|----------|
| Page blanche | Vérifiez que WampServer est démarré (icône verte) |
| Erreur BDD | Vérifiez les paramètres dans `includes/config.php` |
| Impossible de se connecter | Allez sur `http://localhost/eglise/admin/login.php` — les identifiants sont pré-remplis |
| Images ne s'affichent pas | Vérifiez que le dossier `assets/images/uploads/` existe |
| Erreur 404 | Vérifiez que le dossier est bien dans `C:\wamp64\www\eglise\` |

---

## 📞 CONTACTS
**Quasi-Paroisse Sainte Élisabeth du Municipal**
Quartier Municipal, Bouaké, Côte d'Ivoire
Page Facebook : https://web.facebook.com/quasi.paroisse.sainte.elisabeth.2025

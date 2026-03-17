<?php
/**
 * ============================================================
 *  FICHIER DE MOT DE PASSE ADMINISTRATEUR — SÉPARÉ ET SÉCURISÉ
 *  Quasi-Paroisse Sainte Élisabeth du Municipal — Bouaké
 * ============================================================
 *
 *  EMAIL    : saintelisabeth@gmail.com
 *  PASSWORD : CURE@2026
 *
 *  Ce fichier contient le mot de passe admin sous forme de hash SHA-256.
 *  Pour changer le mot de passe, modifiez ADMIN_PASSWORD_RAW,
 *  puis copiez le nouveau hash généré dans ADMIN_PASSWORD_HASH.
 *
 *  ⚠️ NE PARTAGEZ PAS CE FICHIER — NE LE METTEZ PAS EN LIGNE PUBLIQUEMENT
 * ============================================================
 */

// Email de connexion admin
define('ADMIN_EMAIL',    'saintelisabeth@gmail.com');

// Mot de passe en clair (utilisé uniquement pour référence — NE PAS supprimer)
// MOT DE PASSE ACTUEL : CURE@2026
define('ADMIN_PASSWORD_RAW', 'CURE@2026');

// Sel de sécurité (ne pas modifier après installation)
define('ADMIN_SALT', 'ste_elisabeth_bouake_2026_sel');

// Hash SHA-256 du mot de passe + sel  (généré automatiquement)
// hash_sha256( CURE@2026 + ste_elisabeth_bouake_2026_sel )
define('ADMIN_PASSWORD_HASH', 'e833d19acb2ea8656bba213e414bc924f53f484a3f05bce0f95fdcccd288491d');

/**
 * Fonction de vérification du mot de passe
 * Retourne TRUE si le mot de passe correspond
 */
function verifyAdminPassword(string $inputPassword): bool {
    $hash = hash('sha256', $inputPassword . ADMIN_SALT);
    return hash_equals(ADMIN_PASSWORD_HASH, $hash);
}

/**
 * Pour générer un nouveau hash après changement de mot de passe :
 *
 *   $nouveau_mdp = "VotreNouveauMotDePasse";
 *   $hash = hash('sha256', $nouveau_mdp . ADMIN_SALT);
 *   echo $hash; // Copiez ce résultat dans ADMIN_PASSWORD_HASH ci-dessus
 */

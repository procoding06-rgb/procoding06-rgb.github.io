<?php
/**
 * UTILITAIRE — Générer un hash pour le mot de passe admin
 * Utilisez ce fichier pour changer le mot de passe admin.
 * ⚠️ SUPPRIMEZ CE FICHIER APRÈS UTILISATION !
 */
if (!isset($_GET['mdp']) || empty($_GET['mdp'])) {
    echo "<h2 style='font-family:sans-serif;'>Usage : ?mdp=VotreNouveauMotDePasse</h2>";
    echo "<p style='font-family:sans-serif;color:red;'>Exemple : http://localhost/eglise/generer_hash.php?mdp=NouveauMotDePasse</p>";
    exit;
}
$salt = 'ste_elisabeth_bouake_2026_sel';
$mdp  = $_GET['mdp'];
$hash = hash('sha256', $mdp . $salt);
?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Génération hash</title></head>
<body style="font-family:sans-serif;max-width:700px;margin:40px auto;padding:20px;background:#f5f5f5;">
<div style="background:white;padding:30px;border-radius:8px;border-top:4px solid #C9A84C;box-shadow:0 4px 16px rgba(0,0,0,.1);">
    <h2 style="color:#1A2A4A;">🔑 Hash généré pour votre mot de passe</h2>
    <p><strong>Mot de passe saisi :</strong> <code style="background:#f0f0f0;padding:3px 8px;border-radius:3px;"><?php echo htmlspecialchars($mdp); ?></code></p>
    <p><strong>Hash SHA-256 :</strong></p>
    <textarea style="width:100%;padding:12px;border:2px solid #C9A84C;border-radius:4px;font-family:monospace;font-size:.9rem;height:60px;" onclick="this.select();"><?php echo $hash; ?></textarea>
    <hr style="margin:20px 0;">
    <h3 style="color:#1A2A4A;">Étapes suivantes :</h3>
    <ol style="line-height:2.2;">
        <li>Ouvrez le fichier <strong>admin_password.php</strong></li>
        <li>Remplacez la valeur de <code>ADMIN_PASSWORD_RAW</code> par : <strong><?php echo htmlspecialchars($mdp); ?></strong></li>
        <li>Remplacez la valeur de <code>ADMIN_PASSWORD_HASH</code> par le hash affiché ci-dessus</li>
        <li>Enregistrez le fichier</li>
        <li style="color:red;"><strong>Supprimez ce fichier (generer_hash.php) immédiatement !</strong></li>
    </ol>
    <p style="background:#fff3cd;border:1px solid #ffc107;border-radius:4px;padding:12px;font-size:.88rem;color:#856404;">
        ⚠️ Ce fichier représente un risque de sécurité. Supprimez-le dès que vous avez copié le hash.
    </p>
</div>
</body></html>

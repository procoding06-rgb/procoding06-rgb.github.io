<?php
require_once __DIR__ . '/includes/config.php';
$pageTitle = 'Accueil';
$db = getDB();

// Actualités récentes
$stmt = $db->prepare("SELECT * FROM actualites WHERE publie=1 ORDER BY created_at DESC LIMIT 3");
$stmt->execute();
$actualites = $stmt->fetchAll();

// Prochains événements
$stmt2 = $db->prepare("SELECT * FROM evenements WHERE publie=1 AND date_debut >= CURDATE() ORDER BY date_debut ASC LIMIT 5");
$stmt2->execute();
$evenements = $stmt2->fetchAll();

// Horaires
$stmt3 = $db->query("SELECT * FROM horaires_messes ORDER BY ordre");
$horaires = $stmt3->fetchAll();

// Galerie récente
$stmt4 = $db->prepare("SELECT * FROM galerie WHERE publie=1 AND type='photo' ORDER BY created_at DESC LIMIT 6");
$stmt4->execute();
$photos = $stmt4->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<?php if (isAdmin()): ?>
<div class="admin-topbar">
    <i class="fas fa-lock"></i> Vous êtes connecté en tant qu'administrateur.
    <a href="<?php echo SITE_URL; ?>/admin/dashboard.php">Tableau de bord</a>
    <a href="<?php echo SITE_URL; ?>/admin/logout.php">Déconnexion</a>
</div>
<?php endif; ?>

<!-- HERO -->
<section class="hero">
    <div class="container hero-content animate-up">
        <div class="hero-tag"><i class="fas fa-cross"></i> Diocèse de Bouaké — Côte d'Ivoire</div>
        <h1>Bienvenue à la<br><span>Quasi-Paroisse<br>Sainte Élisabeth</span></h1>
        <p><?php echo sanitize(getParam('mot_bienvenue')); ?></p>
        <div class="hero-btns">
            <a href="pages/paroisse.php" class="btn btn-gold"><i class="fas fa-church"></i> Découvrir la paroisse</a>
            <a href="pages/celebrations.php" class="btn btn-outline"><i class="fas fa-pray"></i> Horaires des messes</a>
        </div>
    </div>
    <div class="hero-ornament">✝</div>
</section>

<!-- VERSETS DU JOUR -->
<section style="background: var(--gold); padding: 18px 0; text-align:center;">
    <div class="container">
        <p style="font-family: var(--font-title); color: var(--navy-dark); font-size: 0.95rem; letter-spacing: 0.5px;">
            <i class="fas fa-book-open" style="margin-right:8px;"></i>
            « Je suis le chemin, la vérité et la vie. » — <em>Jean 14, 6</em>
        </p>
    </div>
</section>

<!-- SACREMENTS RAPIDE -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Notre foi</span>
            <h2 class="section-title">Les Sacrements de l'Église</h2>
            <div class="section-divider"><i class="fas fa-cross"></i></div>
            <p class="section-desc">Les sacrements sont des signes efficaces de la grâce, institués par le Christ, confiés à l'Église.</p>
        </div>
        <div class="sacrement-grid">
            <div class="sacrement-card" onclick="location.href='pages/sacrements.php#bapteme'">
                <div class="icon"><i class="fas fa-water"></i></div>
                <h3>Baptême</h3>
                <p>Porte d'entrée dans la vie chrétienne</p>
            </div>
            <div class="sacrement-card" onclick="location.href='pages/sacrements.php#communion'">
                <div class="icon"><i class="fas fa-bread-slice"></i></div>
                <h3>1ère Communion</h3>
                <p>Première participation à l'Eucharistie</p>
            </div>
            <div class="sacrement-card" onclick="location.href='pages/sacrements.php#confirmation'">
                <div class="icon"><i class="fas fa-fire"></i></div>
                <h3>Confirmation</h3>
                <p>Affermissement dans la foi</p>
            </div>
            <div class="sacrement-card" onclick="location.href='pages/sacrements.php#mariage'">
                <div class="icon"><i class="fas fa-ring"></i></div>
                <h3>Mariage</h3>
                <p>Alliance sacrée entre deux époux</p>
            </div>
            <div class="sacrement-card" onclick="location.href='pages/sacrements.php#onction'">
                <div class="icon"><i class="fas fa-hand-holding-medical"></i></div>
                <h3>Onction des malades</h3>
                <p>Réconfort pour les personnes souffrantes</p>
            </div>
        </div>
    </div>
</section>

<!-- HORAIRES DES MESSES -->
<section class="section section-dark">
    <div class="container">
        <div class="section-header">
            <span class="section-tag" style="color:var(--gold-light);">Célébrations</span>
            <h2 class="section-title">Horaires des Messes</h2>
            <div class="section-divider"><i class="fas fa-cross"></i></div>
            <p class="section-desc">Rejoignez notre communauté pour la célébration eucharistique.</p>
        </div>
        <div class="horaire-grid">
            <?php foreach ($horaires as $h): ?>
            <div class="horaire-card">
                <div class="jour"><?php echo sanitize($h['jour']); ?></div>
                <div class="heure"><?php echo sanitize($h['heure']); ?></div>
                <div class="type"><?php echo sanitize($h['type_messe']); ?></div>
                <?php if ($h['remarque']): ?><div class="type" style="margin-top:4px; font-style:italic;"><?php echo sanitize($h['remarque']); ?></div><?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center; margin-top:28px;">
            <a href="pages/celebrations.php" class="btn btn-gold"><i class="fas fa-calendar-alt"></i> Voir le programme complet</a>
        </div>
    </div>
</section>

<!-- ACTUALITÉS -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Vie paroissiale</span>
            <h2 class="section-title">Actualités de la Paroisse</h2>
            <div class="section-divider"><i class="fas fa-cross"></i></div>
        </div>
        <?php if (empty($actualites)): ?>
        <div style="text-align:center; color:var(--text-light); padding:40px 0;">
            <i class="fas fa-newspaper" style="font-size:3rem; color:var(--cream-dark); margin-bottom:14px;"></i>
            <p>Aucune actualité pour le moment. Revenez bientôt !</p>
        </div>
        <?php else: ?>
        <div class="grid-3">
            <?php foreach ($actualites as $actu): ?>
            <div class="card">
                <?php if ($actu['image'] && file_exists(UPLOAD_DIR . $actu['image'])): ?>
                <img src="<?php echo UPLOAD_URL . sanitize($actu['image']); ?>" alt="<?php echo sanitize($actu['titre']); ?>" class="card-img">
                <?php else: ?>
                <div class="card-img-placeholder"><i class="fas fa-church"></i></div>
                <?php endif; ?>
                <div class="card-body">
                    <span class="card-tag"><?php echo ucfirst(str_replace('_', ' ', $actu['categorie'])); ?></span>
                    <h3 class="card-title"><?php echo sanitize($actu['titre']); ?></h3>
                    <p class="card-text"><?php echo sanitize(substr($actu['contenu'], 0, 120)) . '...'; ?></p>
                </div>
                <div class="card-footer">
                    <span style="font-size:0.78rem; color:var(--text-light);"><i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($actu['created_at'])); ?></span>
                    <a href="pages/actualite_detail.php?id=<?php echo $actu['id']; ?>" class="btn btn-navy" style="padding:6px 14px; font-size:0.78rem;">Lire <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div style="text-align:center; margin-top:32px;">
            <a href="pages/actualites.php" class="btn btn-gold"><i class="fas fa-newspaper"></i> Toutes les actualités</a>
        </div>
    </div>
</section>

<!-- PROCHAINS ÉVÉNEMENTS -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Agenda</span>
            <h2 class="section-title">Prochains Événements</h2>
            <div class="section-divider"><i class="fas fa-cross"></i></div>
        </div>
        <?php if (empty($evenements)): ?>
        <div style="text-align:center; color:var(--text-light); padding:40px 0;">
            <i class="fas fa-calendar-alt" style="font-size:3rem; color:var(--cream-dark); margin-bottom:14px;"></i>
            <p>Aucun événement prévu pour le moment.</p>
        </div>
        <?php else: ?>
        <div class="event-list">
            <?php foreach ($evenements as $ev): ?>
            <div class="event-item">
                <div class="event-date-box">
                    <div class="day"><?php echo date('d', strtotime($ev['date_debut'])); ?></div>
                    <div class="month"><?php echo strftime('%b', strtotime($ev['date_debut'])); ?></div>
                </div>
                <div class="event-info">
                    <h4><?php echo sanitize($ev['titre']); ?></h4>
                    <?php if ($ev['description']): ?><p><?php echo sanitize(substr($ev['description'], 0, 100)) . '...'; ?></p><?php endif; ?>
                    <div class="event-meta">
                        <?php if ($ev['heure']): ?><span><i class="fas fa-clock"></i> <?php echo sanitize($ev['heure']); ?></span><?php endif; ?>
                        <?php if ($ev['lieu']): ?><span><i class="fas fa-map-marker-alt"></i> <?php echo sanitize($ev['lieu']); ?></span><?php endif; ?>
                        <span class="badge badge-gold"><?php echo ucfirst($ev['type']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div style="text-align:center; margin-top:32px;">
            <a href="pages/agenda.php" class="btn btn-gold"><i class="fas fa-calendar-alt"></i> Voir l'agenda complet</a>
        </div>
    </div>
</section>

<!-- GALERIE APERÇU -->
<?php if (!empty($photos)): ?>
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Moments de grâce</span>
            <h2 class="section-title">Galerie de la Paroisse</h2>
            <div class="section-divider"><i class="fas fa-cross"></i></div>
        </div>
        <div class="galerie-grid">
            <?php foreach ($photos as $photo): ?>
            <div class="galerie-item" data-src="<?php echo UPLOAD_URL . sanitize($photo['image']); ?>">
                <img src="<?php echo UPLOAD_URL . sanitize($photo['image']); ?>" alt="<?php echo sanitize($photo['titre']); ?>">
                <div class="galerie-overlay">
                    <span><?php echo sanitize($photo['titre']); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center; margin-top:28px;">
            <a href="pages/galerie.php" class="btn btn-gold"><i class="fas fa-images"></i> Voir toute la galerie</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAIRE UN DON -->
<section class="section section-dark">
    <div class="container">
        <div class="section-header">
            <span class="section-tag" style="color:var(--gold-light);">Soutenir la paroisse</span>
            <h2 class="section-title">Faire un Don</h2>
            <div class="section-divider"><i class="fas fa-cross"></i></div>
            <p class="section-desc">Votre soutien permet à notre communauté de grandir et d'accomplir sa mission.</p>
        </div>
        <div class="don-grid">
            <div class="don-card">
                <div class="icon"><i class="fas fa-church"></i></div>
                <h3>Denier de l'Église</h3>
                <p>Participation aux charges de l'Église locale et au fonctionnement de la paroisse.</p>
            </div>
            <div class="don-card">
                <div class="icon"><i class="fas fa-hands-helping"></i></div>
                <h3>Offrandes</h3>
                <p>Contribution aux messes, intentions de prière et célébrations sacramentelles.</p>
            </div>
            <div class="don-card">
                <div class="icon"><i class="fas fa-building"></i></div>
                <h3>Projets paroissiaux</h3>
                <p>Soutien aux projets de construction, rénovation et développement pastoral.</p>
            </div>
        </div>
        <div style="text-align:center; margin-top:32px;">
            <a href="pages/don.php" class="btn btn-gold"><i class="fas fa-heart"></i> Faire une offrande</a>
        </div>
    </div>
</section>

<!-- CITATION -->
<section style="background: var(--cream-dark); padding: 60px 0;">
    <div class="container" style="max-width: 760px;">
        <div class="citation-block">
            <p>Là où deux ou trois sont réunis en mon nom, je suis au milieu d'eux.</p>
            <cite>— Matthieu 18, 20</cite>
        </div>
    </div>
</section>

<!-- Lightbox -->
<div id="lightbox" class="lightbox">
    <button id="lightboxClose" class="lightbox-close"><i class="fas fa-times"></i></button>
    <img id="lightboxImg" src="" alt="Photo">
</div>

<button class="back-to-top" id="backToTop"><i class="fas fa-chevron-up"></i></button>

<?php include __DIR__ . '/includes/footer.php'; ?>

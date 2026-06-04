<?php
$title = "Menu Snack Turquie Anderlecht - Dürüms, burgers, assiettes et frites";
$metaDescription = "Consultez le menu de Snack Turquie à Anderlecht : menus dürüms, sandwichs, pains turcs, gyros, kapsalons, assiettes, frites, sauces, boissons et desserts.";
include 'inc/head.php';
include 'inc/header.php';

function menuSlug(string $texte): string
{
    $texte = strtr($texte, [
        'à' => 'a',
        'â' => 'a',
        'ä' => 'a',
        'ç' => 'c',
        'é' => 'e',
        'è' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'î' => 'i',
        'ï' => 'i',
        'ô' => 'o',
        'ö' => 'o',
        'ù' => 'u',
        'û' => 'u',
        'ü' => 'u',
    ]);

    $texte = strtolower($texte);
    $texte = preg_replace('/[^a-z0-9]+/', '-', $texte);

    return trim($texte, '-');
}

function menuGroupe(string $categorie): string
{
    $extras = ['Accompagnements', 'Frites', 'Sauces', 'Boissons', 'Desserts', 'Suppléments'];

    return in_array($categorie, $extras, true) ? 'extras' : 'plats';
}

function menuEstCompact(string $categorie): bool
{
    return in_array($categorie, ['Sauces', 'Boissons'], true);
}

function menuOptionsType(string $categorie): string
{
    if ($categorie === 'Menus') {
        return 'sauce-drink';
    }

    if (in_array($categorie, ['Kapsalons', 'Assiettes', 'Accompagnements', 'Frites'], true)) {
        return 'sauce';
    }

    return 'none';
}

function afficherProduit(array $produit, string $groupe, string $optionsType): void
{
    ?>
    <article
        class="menu-item"
        data-menu-item
        data-menu-group="<?= htmlspecialchars($groupe) ?>"
    >
        <div class="menu-item__media">
            <img
                src="/assets/<?= htmlspecialchars($produit['image']) ?>"
                alt="<?= htmlspecialchars($produit['nom']) ?>"
                class="menu-item__image"
            >
        </div>

        <div class="menu-item__content">
            <h4><?= htmlspecialchars($produit['nom']) ?></h4>
            <p><?= htmlspecialchars($produit['description']) ?></p>
            <button
                class="menu-item__price"
                type="button"
                data-product-name="<?= htmlspecialchars($produit['nom']) ?>"
                data-product-price="<?= htmlspecialchars((string) $produit['prix']) ?>"
                data-product-options="<?= htmlspecialchars($optionsType) ?>"
            >
                <?= htmlspecialchars(number_format($produit['prix'], 2, ',', ' ')) ?>&euro;
            </button>
        </div>
    </article>
    <?php
}
?>

<main class="menu-page">
    <span id="menu-top" class="menu-top-anchor" aria-hidden="true"></span>
    <h1 class="menu-title">Menu</h1>
    <div class="menu-badges" aria-label="Informations du menu">
        <img src="/assets/img/halal.svg" alt="Viandes halal" class="halal-logo halal-logo--small">
    </div>

    <div class="menu-navigation" id="menu-anchors">
        <div class="menu-filters" aria-label="Filtrer le menu">
            <button class="menu-filter is-active" type="button" data-menu-filter="all">Tout</button>
            <button class="menu-filter" type="button" data-menu-filter="plats">Plats</button>
            <button class="menu-filter" type="button" data-menu-filter="extras">Extras</button>
        </div>

        <nav class="menu-anchors" aria-label="Navigation du menu">
            <?php foreach ($menu as $categorie => $contenu): ?>
                <?php if ($categorie !== 'Menus'): ?>
                    <a class="menu-anchors__link menu-anchors__link--main" href="#<?= htmlspecialchars(menuSlug($categorie)) ?>">
                        <?= htmlspecialchars($categorie) ?>
                    </a>
                <?php endif; ?>

                <?php foreach ($contenu as $cle => $valeur): ?>
                    <?php if (is_string($cle)): ?>
                        <a class="menu-anchors__link" href="#<?= htmlspecialchars(menuSlug($cle)) ?>">
                            <?= htmlspecialchars($cle) ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </nav>
    </div>

    <p class="menu-empty" data-menu-empty hidden>Aucun produit ne correspond à votre recherche.</p>

    <?php foreach ($menu as $categorie => $contenu): ?>
        <?php
        $groupe = menuGroupe($categorie);
        $compact = menuEstCompact($categorie);
        ?>
        <section
            class="menu-section"
            data-menu-section
            data-menu-group="<?= htmlspecialchars($groupe) ?>"
        >
            <?php if ($categorie !== 'Menus'): ?>
                <h2 id="<?= htmlspecialchars(menuSlug($categorie)) ?>">
                    <span><?= htmlspecialchars($categorie) ?></span>
                    <a href="#menu-top" class="menu-back" aria-label="Retour en haut du menu">&uarr;</a>
                </h2>
            <?php endif; ?>

            <?php $contientSousCategories = array_filter(array_keys($contenu), 'is_string'); ?>

            <?php if ($contientSousCategories): ?>
                <?php foreach ($contenu as $cle => $valeur): ?>
                    <div class="menu-subsection" data-menu-subsection>
                        <h3 id="<?= htmlspecialchars(menuSlug($cle)) ?>">
                            <span><?= htmlspecialchars($cle) ?></span>
                            <a href="#menu-top" class="menu-back" aria-label="Retour en haut du menu">&uarr;</a>
                        </h3>

                        <div class="menu-grid">
                            <?php foreach ($valeur as $produit): ?>
                                <?php afficherProduit($produit, $groupe, menuOptionsType($categorie)); ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="menu-grid <?= $compact ? 'menu-grid--compact' : '' ?>">
                    <?php foreach ($contenu as $produit): ?>
                        <?php afficherProduit($produit, $groupe, menuOptionsType($categorie)); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    <?php endforeach; ?>
</main>

<div class="option-modal" data-option-modal hidden>
    <form class="option-modal__panel" data-option-form>
        <h2 data-option-title>Choisir les options</h2>

        <label class="option-field" data-sauce-field>
            <span>Sauce</span>
            <select data-option-sauce>
                <option value="">Choisir une sauce</option>
                <?php foreach ($menu['Sauces'] as $sauce): ?>
                    <option value="<?= htmlspecialchars($sauce['nom']) ?>">
                        <?= htmlspecialchars($sauce['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label class="option-field" data-drink-field>
            <span>Boisson</span>
            <select data-option-drink>
                <option value="">Choisir une boisson</option>
                <?php foreach ($menu['Boissons'] as $boisson): ?>
                    <option value="<?= htmlspecialchars($boisson['nom']) ?>">
                        <?= htmlspecialchars($boisson['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <fieldset class="option-field option-field--supplements" data-supplement-field>
            <legend>Suppléments</legend>

            <div class="option-checks">
                <?php foreach ($menu['Suppléments'] as $supplement): ?>
                    <label class="option-check">
                        <input
                            type="checkbox"
                            value="<?= htmlspecialchars($supplement['nom']) ?>"
                            data-option-supplement
                            data-price="<?= htmlspecialchars((string) $supplement['prix']) ?>"
                        >
                        <span>
                            <?= htmlspecialchars($supplement['nom']) ?>
                            (+<?= htmlspecialchars(number_format($supplement['prix'], 2, ',', ' ')) ?>&euro;)
                        </span>
                    </label>
                <?php endforeach; ?>
            </div>
        </fieldset>

        <div class="option-modal__actions">
            <button class="btn-secondary" type="button" data-option-cancel>Annuler</button>
            <button class="btn-primary" type="submit">Ajouter au panier</button>
        </div>
    </form>
</div>

<?php include 'inc/footer.php'; ?>

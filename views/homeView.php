<?php
$title = "Snack Turquie Anderlecht - Dürüms, burgers, frites et livraison";
$metaDescription = "Snack Turquie à Anderlecht, Rue de Fiennes 6. Commandez vos dürüms, sandwichs, burgers, gyros et frites sur Takeaway ou Uber Eats.";
include 'inc/head.php';
include 'inc/header.php';
?>

<main>
    <section class="hero">
        <div class="hero-content">
            <img src="/assets/img/logo-snack-turquie.png" alt="Snack Turquie" class="hero-logo">

            <div class="hero-info" aria-label="Informations pratiques">
                <a href="tel:+3225239727" class="hero-info__item">
                    <span>Téléphone</span>
                    <strong>02 523 97 27</strong>
                </a>

                <a
                    href="https://www.google.com/maps/search/?api=1&query=Snack%20Turquie%20Rue%20de%20Fiennes%206%201070%20Anderlecht"
                    class="hero-info__item"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <span>Adresse</span>
                    <strong>Rue de Fiennes 6, 1070 Anderlecht</strong>
                </a>

                <div class="hero-info__item">
                    <span>Livraison</span>
                    <strong>Tous les jours de 11:15 à 21:15</strong>
                </div>
            </div>

            <div class="order-links" aria-label="Commander en ligne">
                <a
                    href="https://www.takeaway.com/be-fr/menu/snack-turquie-1070"
                    class="btn-primary btn-takeaway"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Commander sur Takeaway
                </a>

                <a
                    href="https://www.ubereats.com/be/store/snack-turquie/1U4N36M_UeueIgfx0qMV5Q?diningMode=DELIVERY"
                    class="btn-secondary btn-ubereats"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Commander sur Uber Eats
                </a>
            </div>
        </div>

        <div class="hero-map" aria-label="Carte de localisation">
            <iframe
                title="Localisation de Snack Turquie"
                src="https://www.google.com/maps?q=Snack%20Turquie%20Rue%20de%20Fiennes%206%201070%20Anderlecht&output=embed"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </section>

    <section class="service-options" aria-label="Modes de commande">
        <article class="service-option">
            <h2>Sur place</h2>
            <p>Installez-vous directement au snack, Rue de Fiennes 6 à Anderlecht.</p>
        </article>

        <article class="service-option">
            <h2>À emporter</h2>
            <p>Appelez le 02 523 97 27 ou passez au snack pour récupérer votre commande.</p>
        </article>

        <article class="service-option">
            <h2>Livraison</h2>
            <p>Commandez tous les jours de 11:15 à 21:15 via Takeaway ou Uber Eats.</p>

            <div class="order-links">
                <a
                    href="https://www.takeaway.com/be-fr/menu/snack-turquie-1070"
                    class="btn-primary btn-takeaway"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Takeaway
                </a>

                <a
                    href="https://www.ubereats.com/be/store/snack-turquie/1U4N36M_UeueIgfx0qMV5Q?diningMode=DELIVERY"
                    class="btn-secondary btn-ubereats"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Uber Eats
                </a>
            </div>
        </article>
    </section>

    <section class="best-sellers">
        <h2>Nos best-sellers</h2>

        <div class="best-sellers-grid">
            <article class="best-seller-item">
                <a href="/menu.php#menus-durums">
                    <img src="/assets/img/durum/durum.png" alt="Dürüm pita" class="best-seller-item__image">
                    <h3>Dürüm pita</h3>
                </a>
            </article>

            <article class="best-seller-item">
                <a href="/menu.php#menus-sandwichs">
                    <img src="/assets/img/sandwich/sandwich.png" alt="Sandwich" class="best-seller-item__image">
                    <h3>Sandwich</h3>
                </a>
            </article>

            <article class="best-seller-item">
                <a href="/menu.php#menus-burgers">
                    <img src="/assets/img/burger/burger.png" alt="Burger" class="best-seller-item__image">
                    <h3>Burger</h3>
                </a>
            </article>

            <article class="best-seller-item">
                <a href="/menu.php#menus-gyros">
                    <img src="/assets/img/gyros/gyros-pita.png" alt="Gyros" class="best-seller-item__image">
                    <h3>Gyros</h3>
                </a>
            </article>
        </div>
    </section>
</main>

<?php include 'inc/footer.php'; ?>

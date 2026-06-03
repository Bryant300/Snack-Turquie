<?php
$title = "Contact Snack Turquie Anderlecht - Adresse, horaires et livraison";
$metaDescription = "Contactez Snack Turquie à Anderlecht. Adresse : Rue de Fiennes 6, 1070 Anderlecht. Livraison tous les jours de 11:15 à 21:15 via Takeaway et Uber Eats.";
include 'inc/head.php';
include 'inc/header.php';
?>

<main class="contact-page">
    <h1>Contact</h1>

    <section class="contact-grid" aria-label="Informations de contact">
        <article class="contact-card">
            <h2>Téléphone</h2>
            <p>
                <a href="tel:+3225239727" class="contact-link">02 523 97 27</a>
            </p>
        </article>

        <article class="contact-card">
            <h2>Adresse</h2>
            <address>
                Snack Turquie<br>
                <a
                    href="https://www.google.com/maps/search/?api=1&query=Snack%20Turquie%20Rue%20de%20Fiennes%206%201070%20Anderlecht"
                    class="contact-link"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Rue de Fiennes 6<br>
                    1070 Anderlecht
                </a>
            </address>
        </article>

        <article class="contact-card">
            <h2>Livraison</h2>
            <p>Tous les jours de 11:15 à 21:15.</p>
            <p>Commande minimum : 8,00&euro;</p>
            <p>Frais de livraison : 1,49&euro;</p>
        </article>

        <article class="contact-card">
            <h2>Commander</h2>
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

        <article class="contact-card">
            <h2>Horaires</h2>
            <table class="hours-table">
                <tbody>
                    <tr><th>Lundi</th><td>11:15 - 21:15</td></tr>
                    <tr><th>Mardi</th><td>11:15 - 21:15</td></tr>
                    <tr><th>Mercredi</th><td>11:15 - 21:15</td></tr>
                    <tr><th>Jeudi</th><td>11:15 - 21:15</td></tr>
                    <tr><th>Vendredi</th><td>11:15 - 21:15</td></tr>
                    <tr><th>Samedi</th><td>11:15 - 21:15</td></tr>
                    <tr><th>Dimanche</th><td>11:15 - 21:15</td></tr>
                </tbody>
            </table>
        </article>

        <article class="contact-card">
            <h2>Entreprise</h2>
            <p>TVA : BE0871247664</p>
        </article>
    </section>

    <section class="contact-map" aria-label="Carte de localisation">
        <iframe
            title="Localisation de Snack Turquie"
            src="https://www.google.com/maps?q=Snack%20Turquie%20Rue%20de%20Fiennes%206%201070%20Anderlecht&output=embed"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
    </section>
</main>

<?php include 'inc/footer.php'; ?>

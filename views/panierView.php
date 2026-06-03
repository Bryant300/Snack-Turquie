<?php
$title = "Panier Snack Turquie Anderlecht";
$metaDescription = "Consultez votre panier Snack Turquie. Préparez votre commande avant de commander au snack, sur Takeaway ou sur Uber Eats.";
include 'inc/head.php';
include 'inc/header.php';
?>

<main class="cart-page">
    <section class="cart-panel">
        <div>
            <h1>Panier</h1>
            <p data-cart-empty>Votre panier est vide pour le moment.</p>
        </div>

        <div class="cart-list" data-cart-list hidden></div>

        <div class="cart-summary" data-cart-summary hidden>
            <span>Total</span>
            <strong data-cart-total>0,00&euro;</strong>
        </div>

        <div class="cart-actions">
            <a href="/menu.php" class="btn-primary">Retour au menu</a>
            <button class="btn-secondary" type="button" data-cart-clear>Vider le panier</button>

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
    </section>
</main>

<?php include 'inc/footer.php'; ?>

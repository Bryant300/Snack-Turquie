<?php
$title = "Panier Snack Turquie Anderlecht";
$metaDescription = "Consultez votre panier Snack Turquie. Préparez votre commande avant de commander au snack, sur Takeaway, Uber Eats ou Deliveroo.";
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

        <form class="cart-customer" data-cart-customer>
            <h2>Informations client</h2>

            <label>
                <span>Nom</span>
                <input type="text" name="customer_name" data-customer-name autocomplete="name" required>
            </label>

            <label>
                <span>Téléphone</span>
                <input type="tel" name="customer_phone" data-customer-phone autocomplete="tel" required>
            </label>
        </form>

        <div class="cart-actions">
            <a href="/menu.php" class="btn-primary">Retour au menu</a>
            <button class="btn-secondary" type="button" data-cart-clear>Vider le panier</button>

            <a href="#" class="btn-primary btn-whatsapp" data-whatsapp-order>
                Commander par WhatsApp
            </a>
        </div>
    </section>
</main>

<?php include 'inc/footer.php'; ?>

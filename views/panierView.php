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
            <input type="hidden" name="order_type" data-order-type value="Retrait sur place">

            <label>
                <span>Heure souhaitée de retrait</span>
                <input type="time" name="order_time" data-order-time>
            </label>

            <label class="cart-customer__wide">
                <span>Remarque</span>
                <textarea
                    name="order_note"
                    data-order-note
                    rows="3"
                    placeholder="Exemple : sans oignons, sauce à part..."
                ></textarea>
            </label>
        </form>

        <p class="cart-confirmation-note">
            Les commandes du site sont à récupérer sur place, Rue de Fiennes 6. Pour une livraison, utilisez Takeaway, Uber Eats ou Deliveroo.
        </p>

        <div class="cart-actions">
            <a href="/menu.php" class="btn-primary">Retour au menu</a>
            <button class="btn-secondary" type="button" data-cart-clear>Vider le panier</button>

            <a href="/checkout.php" class="btn-primary" data-checkout-link>
                Continuer vers le paiement
            </a>
        </div>
    </section>
</main>

<?php include 'inc/footer.php'; ?>

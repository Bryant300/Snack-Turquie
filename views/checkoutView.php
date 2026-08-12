<?php
$title = "Paiement retrait Snack Turquie Anderlecht";
$metaDescription = "Finalisez votre commande Snack Turquie en retrait sur place. Paiement sécurisé en ligne à connecter avec Mollie.";
include 'inc/head.php';
include 'inc/header.php';
?>

<main class="checkout-page">
    <section class="checkout-panel">
        <div>
            <h1>Retrait sur place</h1>
            <p>Votre commande sera préparée au snack et récupérée Rue de Fiennes 6, 1070 Anderlecht.</p>
        </div>

        <div class="checkout-alert" data-checkout-empty hidden>
            Votre panier est vide. Ajoutez d'abord des produits depuis le menu.
        </div>

        <section class="checkout-section" data-checkout-customer hidden>
            <h2>Informations de retrait</h2>
            <dl class="checkout-details">
                <div>
                    <dt>Nom</dt>
                    <dd data-checkout-name>-</dd>
                </div>
                <div>
                    <dt>Téléphone</dt>
                    <dd data-checkout-phone>-</dd>
                </div>
                <div>
                    <dt>Heure souhaitée</dt>
                    <dd data-checkout-time>-</dd>
                </div>
                <div>
                    <dt>Remarque</dt>
                    <dd data-checkout-note>-</dd>
                </div>
            </dl>
        </section>

        <section class="checkout-section" data-checkout-order hidden>
            <h2>Récapitulatif</h2>
            <div class="checkout-list" data-checkout-list></div>
            <div class="checkout-total">
                <span>Total à payer</span>
                <strong data-checkout-total>0,00&nbsp;€</strong>
            </div>
        </section>

        <section class="checkout-section checkout-payment" data-checkout-payment hidden>
            <h2>Paiement en ligne</h2>
            <p>
                La commande est prête pour un paiement sécurisé. Il reste à connecter le compte Mollie du snack
                pour activer Bancontact et les autres moyens de paiement.
            </p>
            <button class="btn-primary btn-payment" type="button" disabled>
                Paiement sécurisé à connecter
            </button>
        </section>

        <div class="cart-actions">
            <a href="/panier.php" class="btn-secondary">Modifier le panier</a>
            <a href="/menu.php" class="btn-primary btn-menu">Retour au menu</a>
        </div>
    </section>
</main>

<?php include 'inc/footer.php'; ?>
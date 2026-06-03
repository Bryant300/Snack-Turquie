<?php
$pageTitle = $title ?? 'Snack Turquie Anderlecht';
$pageDescription = $metaDescription ?? 'Snack Turquie à Anderlecht - dürüms, sandwichs, burgers, gyros, frites et livraison via Takeaway ou Uber Eats.';

$localBusiness = [
    '@context' => 'https://schema.org',
    '@type' => 'Restaurant',
    'name' => 'Snack Turquie',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'Rue de Fiennes 6',
        'postalCode' => '1070',
        'addressLocality' => 'Anderlecht',
        'addressCountry' => 'BE',
    ],
    'telephone' => '+3225239727',
    'servesCuisine' => ['Turc', 'Snack', 'Dürüm', 'Burger', 'Sandwich'],
    'priceRange' => '€',
    'openingHours' => [
        'Mo-Su 11:15-21:15',
    ],
    'sameAs' => [
        'https://www.takeaway.com/be-fr/menu/snack-turquie-1070',
        'https://www.ubereats.com/be/store/snack-turquie/1U4N36M_UeueIgfx0qMV5Q?diningMode=DELIVERY',
    ],
];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?></title>

    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="author" content="Snack Turquie">

    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="/assets/img/logo-snack-turquie.png">

    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" type="image/png" href="/assets/img/logo-snack-turquie.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@500;600;700;800&display=swap"
        rel="stylesheet">

    <script type="application/ld+json">
        <?= json_encode($localBusiness, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
    </script>
</head>

<body>

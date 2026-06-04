<?php
$pageTitle = $title ?? 'Snack Turquie Anderlecht';
$pageDescription = $metaDescription ?? 'Snack Turquie à Anderlecht - dürüms, sandwichs, burgers, gyros, frites et livraison via Takeaway, Uber Eats ou Deliveroo.';
$siteUrl = 'https://snack-turquie.vercel.app';
$currentScript = basename($_SERVER['SCRIPT_FILENAME'] ?? $_SERVER['SCRIPT_NAME'] ?? 'index.php');
$canonicalPath = '/' . str_replace('.php', '.html', $currentScript);

if ($canonicalPath === '/index.html') {
    $canonicalPath = '/';
}

$canonicalUrl = $siteUrl . $canonicalPath;
$ogImage = $siteUrl . '/assets/img/logo-snack-turquie.png';

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
    'url' => $siteUrl,
    'image' => $ogImage,
    'servesCuisine' => ['Turc', 'Snack', 'Halal', 'Dürüm', 'Burger', 'Sandwich'],
    'priceRange' => '€',
    'openingHours' => [
        'Mo-Su 11:15-21:15',
    ],
    'sameAs' => [
        'https://www.takeaway.com/be-fr/menu/snack-turquie-1070',
        'https://www.ubereats.com/be/store/snack-turquie/1U4N36M_UeueIgfx0qMV5Q?diningMode=DELIVERY',
        'https://deliveroo.be/fr/menu/Brussels/brussels-cureghem/snack-turquie?day=today&geohash=u1511vnkk42x&time=11%3A30&timestamp=1780565400',
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
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">

    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
    <meta property="og:site_name" content="Snack Turquie">
    <meta property="og:locale" content="fr_BE">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage) ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImage) ?>">

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

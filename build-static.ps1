$ErrorActionPreference = "Stop"

$php = "C:\php\php.exe"
$root = Split-Path -Parent $MyInvocation.MyCommand.Path
$dist = Join-Path $root "dist"
$assetsSource = Join-Path $root "public\assets"
$assetsDestination = Join-Path $dist "assets"

if (-not (Test-Path $php)) {
    $phpCommand = Get-Command php -ErrorAction SilentlyContinue

    if (-not $phpCommand) {
        throw "PHP introuvable. Installez PHP dans C:\php\php.exe ou ajoutez php au PATH."
    }

    $php = $phpCommand.Source
}

if (Test-Path $dist) {
    Remove-Item -Path $dist -Recurse -Force
}

New-Item -Path $dist -ItemType Directory | Out-Null
Copy-Item -Path $assetsSource -Destination $assetsDestination -Recurse
Copy-Item -Path (Join-Path $root "public\manifest.webmanifest") -Destination (Join-Path $dist "manifest.webmanifest")
Copy-Item -Path (Join-Path $root "public\service-worker.js") -Destination (Join-Path $dist "service-worker.js")

$pages = @{
    "index.html" = "public\index.php"
    "menu.html" = "public\menu.php"
    "contact.html" = "public\contact.php"
    "panier.html" = "public\panier.php"
    "mentions-legales.html" = "public\mentions-legales.php"
    "confidentialite.html" = "public\confidentialite.php"
    "allergenes.html" = "public\allergenes.php"
    "conditions-commande.html" = "public\conditions-commande.php"
}

foreach ($page in $pages.GetEnumerator()) {
    $source = Join-Path $root $page.Value
    $target = Join-Path $dist $page.Key
    $html = & $php $source

    [System.IO.File]::WriteAllText($target, ($html -join [Environment]::NewLine), [System.Text.Encoding]::UTF8)
}

Write-Host "Build statique cree dans dist"

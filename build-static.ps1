$ErrorActionPreference = "Stop"

$php = "C:\php\php.exe"
$root = Split-Path -Parent $MyInvocation.MyCommand.Path
$dist = Join-Path $root "dist"
$assetsSource = Join-Path $root "public\assets"
$assetsDestination = Join-Path $dist "assets"

if (-not (Test-Path $php)) {
    throw "PHP introuvable dans C:\php\php.exe"
}

if (Test-Path $dist) {
    Remove-Item -Path $dist -Recurse -Force
}

New-Item -Path $dist -ItemType Directory | Out-Null
Copy-Item -Path $assetsSource -Destination $assetsDestination -Recurse

$pages = @{
    "index.html" = "public\index.php"
    "menu.html" = "public\menu.php"
    "contact.html" = "public\contact.php"
    "panier.html" = "public\panier.php"
}

foreach ($page in $pages.GetEnumerator()) {
    $source = Join-Path $root $page.Value
    $target = Join-Path $dist $page.Key
    $html = & $php $source

    [System.IO.File]::WriteAllText($target, ($html -join [Environment]::NewLine), [System.Text.Encoding]::UTF8)
}

Write-Host "Build statique cree dans dist"

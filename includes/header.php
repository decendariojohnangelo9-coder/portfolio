<?php
// Variables a page can set before including this file:
//   $pageTitle, $pageDesc : custom <title> and meta description
//   $navBase              : '' on index.php, 'index.php' on other pages (so nav links go back home)
if (!isset($config)) {
    $config = require __DIR__ . '/config.php';
}
$navBase   = $navBase ?? '';
$activeNav = $activeNav ?? '';   // e.g. 'projects' on a project page
$pageTitle = $pageTitle ?? $config['name'] . ' | ' . $config['role'];
$pageDesc  = $pageDesc ?? 'Portfolio of ' . $config['name'] . ', ' . strtolower($config['role']) . '.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDesc) ?>">
  <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css?v=<?= (int) @filemtime(__DIR__ . '/../assets/css/style.css') ?>">
</head>
<body>
<header class="nav">
    <a class="brand" href="<?= $navBase ?>#top" aria-label="Home">~/jad<span class="cursor">_</span></a>
  <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false">Menu</button>
  <nav id="menu">
    <a href="<?= $navBase ?>#about">About</a>
    <a href="<?= $navBase ?>#skills">Skills</a>
    <a href="<?= $navBase ?>#projects"<?= $activeNav === 'projects' ? ' class="active" aria-current="page"' : '' ?>>Projects</a>
    <a href="<?= $navBase ?>#contact">Contact</a>
  </nav>
</header>
<main id="top">

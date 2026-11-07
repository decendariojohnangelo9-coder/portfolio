<?php
// One template for every project page: project.php?slug=project-one
$config   = require __DIR__ . '/includes/config.php';
$projects = require __DIR__ . '/data/projects.php';
$navBase  = 'index.php';
$activeNav = 'projects';

// Find the project that matches ?slug=... (only accept plain text, not arrays).
$slug  = isset($_GET['slug']) && is_string($_GET['slug']) ? $_GET['slug'] : '';
$index = null;
foreach ($projects as $i => $item) {
    if ($item['slug'] === $slug) { $index = $i; break; }
}

// Unknown slug -> friendly 404 page.
if ($index === null) {
    http_response_code(404);
    $pageTitle = 'Project not found | ' . $config['name'];
    include __DIR__ . '/includes/header.php';
    ?>
    <section class="section project-page">
      <h2><span class="sym">//</span> Project not found</h2>
      <p class="lead">That project does not exist. It may have been renamed or removed.</p>
      <a class="btn btn-primary" href="index.php#projects">Back to projects</a>
    </section>
    <?php
    include __DIR__ . '/includes/footer.php';
    exit;
}

$p    = $projects[$index];
$prev = $projects[$index - 1] ?? null;
$next = $projects[$index + 1] ?? null;

$hasLive   = $p['live']   !== '#' && $p['live']   !== '';
// 'private' = repo is private (show Request button), a real URL = GitHub button, '#' = not ready yet.
$sourceMode = $p['github'] === 'private' ? 'request' : (($p['github'] !== '#' && $p['github'] !== '') ? 'link' : 'soon');
$features   = $p['features'] ?? [];
$gallery    = $p['gallery'] ?? [];
$shotDir    = 'assets/images/projects/' . $p['slug'] . '/';

$pageTitle = $p['title'] . ' | ' . $config['name'];
$pageDesc  = $p['desc'];
include __DIR__ . '/includes/header.php';
?>

<section class="section project-page">
  <a class="back" href="index.php#projects">&larr; Back to projects</a>

  <div class="project-head">
    <p class="level-pill">Lv.<?= (int)$p['level'] ?></p>
    <h1><?= htmlspecialchars($p['title']) ?></h1>
    <p class="lead"><?= htmlspecialchars($p['desc']) ?></p>
    <ul class="tags">
      <?php foreach ($p['stack'] as $t): ?><li><?= htmlspecialchars($t) ?></li><?php endforeach; ?>
    </ul>
    <?php if (empty($p['hide_links'])): ?>
    <div class="card-actions">
      <?php if ($hasLive): ?>
        <a class="btn btn-primary" href="<?= htmlspecialchars($p['live']) ?>" target="_blank" rel="noopener">View my project</a>
      <?php else: ?>
        <span class="btn btn-primary is-disabled" aria-disabled="true">Project link coming soon</span>
      <?php endif; ?>
      <?php if ($sourceMode === 'link'): ?>
        <a class="btn btn-ghost" href="<?= htmlspecialchars($p['github']) ?>" target="_blank" rel="noopener">View on GitHub</a>
      <?php elseif ($sourceMode === 'request'): ?>
        <a class="btn btn-ghost" href="index.php#contact">Request repo access</a>
      <?php else: ?>
        <span class="btn btn-ghost is-disabled" aria-disabled="true">GitHub coming soon</span>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>

  <div class="project-body">
    <div class="panel">
      <h3>About this project</h3>
      <?php if ($hasLive): ?>
        <p class="live-url">Live site: <a href="<?= htmlspecialchars($p['live']) ?>" target="_blank" rel="noopener"><?= htmlspecialchars(preg_replace('#^https?://#', '', rtrim($p['live'], '/'))) ?></a></p>
      <?php endif; ?>
      <?php foreach ($p['explanation'] as $para): ?>
        <p><?= htmlspecialchars($para) ?></p>
      <?php endforeach; ?>
      <?php if ($features): ?>
        <h4 class="mini">Main features</h4>
        <ul class="learning">
          <?php foreach ($features as $f): ?><li><?= htmlspecialchars($f) ?></li><?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>

    <div class="panel">
      <h3>Key code</h3>
      <?php if (is_array($p['code_note'])): ?>
        <ul class="learning">
          <?php foreach ($p['code_note'] as $note): ?><li><?= htmlspecialchars($note) ?></li><?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p><?= htmlspecialchars($p['code_note']) ?></p>
      <?php endif; ?>
      <button class="btn btn-primary code-btn" type="button"
              data-file="<?= htmlspecialchars($p['file'] ?? '') ?>"
              data-code="<?= htmlspecialchars($p['code']) ?>">View key code</button>
    </div>
  </div>

  <?php if ($gallery): ?>
    <h3 class="sub">Project preview</h3>
    <div class="gallery<?= !empty($p['gallery_portrait']) ? ' gallery-portrait' : '' ?>">
      <?php foreach ($gallery as $s): $isVideo = isset($s['video']); $path = $shotDir . ($isVideo ? $s['video'] : $s['file']); ?>
        <figure class="shot">
          <?php if ($isVideo && is_file(__DIR__ . '/' . $path)): ?>
            <video class="shot-video" controls muted playsinline preload="none"
                   poster="<?= htmlspecialchars($shotDir . ($s['poster'] ?? '')) ?>"
                   aria-label="<?= htmlspecialchars($s['title']) ?>">
              <source src="<?= htmlspecialchars($path) ?>" type="video/mp4">
            </video>
          <?php elseif (is_file(__DIR__ . '/' . $path)): ?>
            <button type="button" class="shot-btn" aria-label="Enlarge: <?= htmlspecialchars($s['title']) ?>"
                    data-src="<?= htmlspecialchars($path) ?>"
                    data-title="<?= htmlspecialchars($s['title']) ?>"
                    data-caption="<?= htmlspecialchars($s['caption']) ?>">
              <img src="<?= htmlspecialchars($path) ?>" alt="<?= htmlspecialchars($s['title']) ?>" loading="lazy">
            </button>
          <?php else: ?>
            <div class="shot-empty">Preview coming soon</div>
          <?php endif; ?>
          <figcaption>
            <h4><?= htmlspecialchars($s['title']) ?></h4>
            <p><?= htmlspecialchars($s['caption']) ?></p>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <nav class="pager" aria-label="Project navigation">
    <?php if ($prev): ?>
      <a class="pager-link" href="project.php?slug=<?= urlencode($prev['slug']) ?>">
        <small>&larr; Previous</small><span><?= htmlspecialchars($prev['title']) ?></span>
      </a>
    <?php else: ?><span></span><?php endif; ?>
    <?php if ($next): ?>
      <a class="pager-link next" href="project.php?slug=<?= urlencode($next['slug']) ?>">
        <small>Next &rarr;</small><span><?= htmlspecialchars($next['title']) ?></span>
      </a>
    <?php endif; ?>
  </nav>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
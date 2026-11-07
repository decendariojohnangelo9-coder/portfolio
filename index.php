<?php
$config   = require __DIR__ . '/includes/config.php';
$projects = require __DIR__ . '/data/projects.php';
$status   = $_GET['status'] ?? '';

// Level is either 'Comfortable' or 'Learning'. Review every line: only keep what you can explain.
$skills = [
    ['HTML', 'Comfortable'],
    ['CSS', 'Comfortable'],
    ['JavaScript', 'Comfortable'],
    ['PHP', 'Comfortable'],
    ['MySQL', 'Comfortable'],
    ['Responsive web design', 'Comfortable'],
    ['CRUD apps with PHP and MySQL', 'Comfortable'],
    ['Login systems and sessions', 'Comfortable'],
    ['UI design basics', 'Comfortable'],
    ['VS Code and XAMPP', 'Comfortable'],
    ['Git & GitHub', 'Learning'],
];
$learning = [
    'Laravel framework',
    'REST APIs',
    'Data structures and algorithms',
    'Deploying apps to the cloud',
    'Web security basics (SQL injection, XSS)',
    'Git branching and pull requests',
    'MVC and clean project structure',
];

$tools = ['VS Code', 'XAMPP', 'phpMyAdmin', 'Chrome DevTools', 'Git', 'GitHub'];

$photo    = 'assets/images/profile.jpg';
$hasPhoto = file_exists(__DIR__ . '/' . $photo);

$facts = [
    'Course'         => 'BS Information Technology',
    'Year level'     => $config['year_level'],
    'Location'       => 'Philippines',
    'Main focus'     => 'Web development and UI design',
    'Favorite tools' => 'VS Code, XAMPP, GitHub',
    'Hobbies'        => 'Coding, gaming, and exploring new designs',
];
$passions = [
    ['Web development',   'I love turning an idea into a working website, from the database to the screen.'],
    ['UI and design',     'Clean layouts, good color choices, and details that make a site feel polished.'],
    ['Problem solving',   'Debugging is frustrating, but finding the fix is the best feeling.'],
    ['Learning new tech', 'I try to learn something new every week, whether a tool, a trick, or a framework.'],
];

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="terminal">
    <div class="term-bar"><i></i><i></i><i></i><span>jad@portfolio: ~</span></div>
    <div class="term-body">
      <p class="dim">$ whoami</p>
      <h1><?= htmlspecialchars($config['first_name']) ?> <br>Decendario</h1>
      <p class="typing"><span id="typed"></span><span class="cursor">_</span></p>
      <p class="status-chip"><span class="dot" aria-hidden="true"></span>Open to internships</p>
      <div class="cta">
        <a class="btn btn-primary" href="#projects">View projects</a>
        <a class="btn btn-ghost" href="#contact">Contact me</a>
      </div>
    </div>
  </div>
</section>

<section id="about" class="section">
  <h2><span class="sym">//</span> About me</h2>

  <div class="about-intro">
    <div class="avatar">
      <?php if ($hasPhoto): ?>
        <img src="<?= $photo ?>" alt="Photo of <?= htmlspecialchars($config['name']) ?>">
      <?php else: ?>
        <span><?= htmlspecialchars($config['initials']) ?></span>
      <?php endif; ?>
    </div>
    <div class="about-hello">
      <h3>Hello, I'm <?= htmlspecialchars($config['first_name']) ?></h3>
      <p>I'm an Information Technology student who loves web development and design. I enjoy building websites from scratch and making them look as good as they work.</p>
    </div>
  </div>

  <div class="about-cols">
    <div class="panel">
      <h3>Get to know me</h3>
      <p>My journey started with plain HTML and CSS, when I was amazed that a few lines of code could become a real page. Since then I moved on to JavaScript, then PHP and MySQL, and now I build dynamic apps with logins, forms, and databases.</p>
      <p>I believe a good developer cares about both sides: the code that runs behind the scenes and the design people actually see. That's why I spend time on clean structure and clean visuals.</p>
      <p>Every project on this page was built and deployed by me, from my very first simple page to my most complex system. I'm open to internships, collaborations, and any chance to grow.</p>
    </div>
    <div class="panel">
      <h3>Quick facts</h3>
      <ul class="facts">
        <?php foreach ($facts as $label => $value): ?>
          <li><span><?= htmlspecialchars($label) ?></span><b><?= htmlspecialchars($value) ?></b></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <h3 class="sub">What I'm passionate about</h3>
  <div class="passions">
    <?php foreach ($passions as [$title, $text]): ?>
      <div class="passion">
        <h4><?= htmlspecialchars($title) ?></h4>
        <p><?= htmlspecialchars($text) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section id="skills" class="section">
  <h2><span class="sym">//</span> Skills and learning</h2>
  <p class="lead">I learn by building. I pick a concept, make something real with it, then come back and improve it. Here is where I stand today.</p>
  <div class="skills-grid">
    <div class="panel">
      <h3>What I know</h3>
      <p class="legend">
        <span class="st st-ok" aria-hidden="true">[ OK ]</span> Comfortable
        <span class="st st-learn" aria-hidden="true">[ <i>.</i><i>.</i><i>.</i> ]</span> Learning
      </p>
      <ul class="skill-list stagger">
        <?php foreach ($skills as $n => [$label, $level]): ?>
          <li style="--i:<?= $n ?>">
            <?php if ($level === 'Learning'): ?>
              <span class="st st-learn" aria-hidden="true">[ <i>.</i><i>.</i><i>.</i> ]</span>
            <?php else: ?>
              <span class="st st-ok" aria-hidden="true">[ OK ]</span>
            <?php endif; ?>
            <span><?= htmlspecialchars($label) ?></span>
            <span class="sr-only">(<?= htmlspecialchars($level) ?>)</span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="panel">
      <h3>Currently learning</h3>
      <ul class="learning stagger">
        <?php foreach ($learning as $n => $item): ?>
          <li style="--i:<?= $n ?>"><?= htmlspecialchars($item) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <div class="skills-grid skills-extra">
    <div class="panel">
      <h3>How I learn</h3>
      <p>I start with the basics and build on them: HTML and CSS first, then JavaScript, then PHP and MySQL. Each new skill came from trying to build something I could not build before.</p>
      <p>When something breaks, I read the error message first, test one change at a time, and write down the fix so I do not repeat the same mistake.</p>
    </div>
    <div class="panel">
      <h3>Tools I use</h3>
      <p>The tools I rely on to write, test, and publish my projects.</p>
      <ul class="tags stagger">
        <?php foreach ($tools as $n => $tool): ?>
          <li style="--i:<?= $n ?>"><?= htmlspecialchars($tool) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<section id="projects" class="section">
  <h2><span class="sym">//</span> Projects</h2>
  <p class="lead">Arranged from my easiest project to my hardest, so you can see how my skills grew over time.</p>

  <div class="timeline">
    <?php foreach ($projects as $p): ?>
      <article class="project">
        <div class="level"><span>Lv.<?= (int)$p['level'] ?></span></div>
        <div class="card">
          <h3><?= htmlspecialchars($p['title']) ?></h3>
          <p><?= htmlspecialchars($p['desc']) ?></p>
          <ul class="tags">
            <?php foreach ($p['stack'] as $t): ?><li><?= htmlspecialchars($t) ?></li><?php endforeach; ?>
          </ul>
          <div class="card-actions">
            <a class="btn btn-primary" href="project.php?slug=<?= urlencode($p['slug']) ?>">View project</a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section id="contact" class="section">
  <h2><span class="sym">//</span> Contact</h2>
  <div class="contact-grid">
    <div class="panel">
      <h3>Let's talk</h3>
      <p>Have a project, an opportunity, or just want to say hi? Send me a message.</p>
      <ul class="links">
        <li><a href="mailto:<?= htmlspecialchars($config['email']) ?>"><?= htmlspecialchars($config['email']) ?></a></li>
        <li><a href="<?= htmlspecialchars($config['github']) ?>" target="_blank" rel="noopener"><?= htmlspecialchars(preg_replace('#^https?://#', '', $config['github'])) ?></a></li>
        <li><a href="<?= htmlspecialchars($config['linkedin']) ?>" target="_blank" rel="noopener"><?= htmlspecialchars(preg_replace('#^https?://#', '', $config['linkedin'])) ?></a></li>
      </ul>
    </div>
    <form class="panel" method="post" action="contact.php">
      <?php if ($status === 'sent'): ?>
        <p class="alert ok">Message sent. Thank you, I'll reply soon.</p>
      <?php elseif ($status === 'invalid'): ?>
        <p class="alert err">Please fill in every field with a valid email address.</p>
      <?php elseif ($status === 'error'): ?>
        <p class="alert err">Your message could not be sent. Please email me directly instead.</p>
      <?php endif; ?>
      <label>Name <input type="text" name="name" required maxlength="80"></label>
      <label>Email <input type="email" name="email" required maxlength="120"></label>
      <label>Message <textarea name="message" rows="5" required maxlength="1000"></textarea><small class="count" id="msgCount">0 / 1000</small></label>
      <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
      <button class="btn btn-primary" type="submit">Send message</button>
    </form>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
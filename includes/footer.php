</main>
<footer class="footer">
  <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($config['name']) ?>. Built with PHP, HTML, CSS and JavaScript.</p>
</footer>

<div class="modal" id="codeModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle" hidden>
  <div class="modal-box">
    <div class="modal-bar">
      <span id="modalTitle">file</span>
      <button class="modal-close" aria-label="Close">Close</button>
    </div>
    <pre><code id="modalCode"></code></pre>
  </div>
</div>
<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Image viewer" hidden>
  <button class="lb-close" type="button">Close</button>
  <button class="lb-nav lb-prev" type="button" aria-label="Previous image">&lsaquo;</button>
  <figure class="lb-fig">
    <img id="lbImg" alt="">
    <figcaption><h4 id="lbTitle"></h4><p id="lbCap"></p></figcaption>
  </figure>
  <button class="lb-nav lb-next" type="button" aria-label="Next image">&rsaquo;</button>
</div>
<button class="to-top" type="button" aria-label="Back to top" hidden>
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 15l6-6 6 6"/></svg>
</button>
<script src="assets/js/main.js?v=<?= (int) @filemtime(__DIR__ . '/../assets/js/main.js') ?>"></script>
</body>
</html>
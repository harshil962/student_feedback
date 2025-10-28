</main>

<!-- ✅ Footer -->
<footer class="bg-dark text-white py-4 shadow-lg mt-auto" data-aos="fade-up">
  <div class="container text-center">
    <p class="mb-1">&copy; <?= date("Y") ?> <strong>FeedbackSys</strong>. All rights reserved.</p>
    <small>Developed with ❤️ by <span class="text-warning fw-semibold">Sneha Mandvani</span></small>
  </div>
</footer>

<!-- ✅ Back to Top Button -->
<a href="#" class="btn btn-warning position-fixed bottom-0 end-0 m-4 rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; z-index: 9999;" data-aos="fade-left">
  <i class="bi bi-arrow-up-short fs-3"></i>
</a>

<!-- ✅ Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true,
    easing: 'ease-in-out'
  });

  // Optional: Smooth Scroll to Top
  document.querySelector('.btn.btn-warning').addEventListener('click', function (e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
</body>
</html>

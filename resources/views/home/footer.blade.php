<footer class="footer mx-2">
    <div class="footer-content">
        <div class="brand">Volt Capital Pro</div>

        <div class="row">
            <div class="col-6 col-md-4 mb-5">
                <h6>Top Instrument</h6>
                <p><a href="{{ url('/tesla-chart') }}">Tesla</a></p>
                <p><a href="{{ url('/apple-chart') }}">Apple</a></p>
                <p><a href="{{ url('/nvidia-chart') }}">Nvidia</a></p>
                <p><a href="{{ url('/msft-chart') }}">Microsoft</a></p>
            </div>
            <div class="col-6 col-md-4 mb-5">
                <h6>Learn More</h6>
                <p><a href="{{ url('/about') }}">About Us</a></p>
                <p><a href="{{ url('/what-is-leverage') }}">What is Leverage</a></p>
                <p><a href="{{ url('/responsible-trading') }}">Responsible Trading</a></p>
                <p><a href="{{ url('/copy-trade') }}">How Copy Trading Works</a></p>
            </div>
            <div class="col-6 col-md-4 mb-5">
                <h6>Privacy</h6>
                <p><a href="{{ url('/cookie-policy') }}">Cookie Policy</a></p>
                <p><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></p>
                <p><a href="{{ url('/terms-of-service') }}">Terms and Condition</a></p>
                <p><a href="{{ url('/general-risk-disclosure') }}">General Risk Disclosure</a></p>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="copyright">Copyright © 2025 by Volt Capital Pro</div>
        </div>
    </div>
    <div class="glow-arc"></div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
      once: true,           // animate only once
      duration: 800,        // animation duration
      easing: 'ease-out-cubic',
    });
  });
</script>
</body>

</html>
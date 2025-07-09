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


    <!-- Start of LiveChat (www.livechat.com) code -->
    <script>
        window.__lc = window.__lc || {};
    window.__lc.license = 19229030;
    window.__lc.integration_name = "manual_channels";
    window.__lc.product_name = "livechat";
    ;(function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)}var e={_q:[],_h:null,_v:"2.0",on:function(){i(["on",c.call(arguments)])},once:function(){i(["once",c.call(arguments)])},off:function(){i(["off",c.call(arguments)])},get:function(){if(!e._h)throw new Error("[LiveChatWidget] You can't use getters before load.");return i(["get",c.call(arguments)])},call:function(){i(["call",c.call(arguments)])},init:function(){var n=t.createElement("script");n.async=!0,n.type="text/javascript",n.src="https://cdn.livechatinc.com/tracking.js",t.head.appendChild(n)}};!n.__lc.asyncInit&&e.init(),n.LiveChatWidget=n.LiveChatWidget||e}(window,document,[].slice))
    </script>
    <noscript><a href="https://www.livechat.com/chat-with/19229030/" rel="nofollow">Chat with us</a>, powered by <a
            href="https://www.livechat.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript>
    <!-- End of LiveChat code -->

    {{--
    <!-- Begin of Chaport Live Chat code -->
    <script type="text/javascript">
        (function(w,d,v3){
w.chaportConfig = {
  appId : '686ed1a3bab0b68d5eb391f0'
};

if(w.chaport)return;v3=w.chaport={};v3._q=[];v3._l={};v3.q=function(){v3._q.push(arguments)};v3.on=function(e,fn){if(!v3._l[e])v3._l[e]=[];v3._l[e].push(fn)};var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://app.chaport.com/javascripts/insert.js';var ss=d.getElementsByTagName('script')[0];ss.parentNode.insertBefore(s,ss)})(window, document);
    </script>
    <!-- End of Chaport Live Chat code --> --}}
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
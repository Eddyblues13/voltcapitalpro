@include('home.header')

<div class="container text-center py-5" data-aos="fade-up">
    <div class="category-label">
        TRAINING & COMMUNITY
    </div>

    <h1 class="hero-heading">
        Learn how to <span class="gradient-invest">invest</span><br>
        <span class="gradient-successfully">successfully</span>
        <span class="gradient-and">&</span>
        <span class="gradient-safely">safely</span>
    </h1>

    <p class="hero-subtitle">
        Absolute top experts show you how to invest strategically to make your
        money work for you sustainably.
    </p>

    <div class="buttons mb-5 d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
        <a href="{{route('login')}}" class="btn btn-login">Login my account</a>
        <a href="{{route('register')}}" class="btn btn-create">Create account</a>
    </div>

    <div class="participants-section" data-aos="zoom-in" data-aos-delay="200">
        <div class="avatar-group">
            <img src="assets/img/CRYParticipants.webp" width="250" alt="">
        </div>
        <div class="participants-text">
            <span id="participants-count">1M+</span> successful participants
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const min = 1000000;
        const max = 4000000;
        const finalCount = Math.floor(Math.random() * (max - min + 1)) + min;
        const formattedCount = (finalCount / 1000000).toFixed(2).replace(/\.00$/, '') + 'M+';
        document.getElementById('participants-count').textContent = formattedCount;
    });
    </script>

</div>

<div class="container section-container" data-aos="fade-up">
    <h2 class="section-reason-title my-5" style="color: #CBD5E1">
        The best time to invest in<br> Bitcoin was 2009.<br>
        <span class="gradient-text">The second best time is now.</span>
    </h2>

    <div class="row g-4 mb-3">
        <div class="col-12" data-aos="zoom-in" data-aos-delay="150">
            <div class="text-center">
                <img src="{{ asset('assets/img/crypChart.png') }}" alt="Crypto Chart"
                    class="img img-fluid w-75 crypto-chart0">
            </div>
        </div>
    </div>
</div>

<div class="container section-container">
    <h2 class="section-reason-title my-5" style="color: #CBD5E1" data-aos="fade-up">
        <span class="gradient-text">7 Reasons</span> Why Cryptocurrencies<br> Will Change All of Our Lives
    </h2>

    <div class="row g-4 mb-3">
        @php $reasons = [
        ['label' => 'REASON 1', 'img' => 'CryReason1.avif', 'title' => 'decentralization and independence', 'desc' =>
        'Bitcoin & Co. are not controlled...'],
        ['label' => 'REASON 2', 'img' => 'CryReason2.avif', 'title' => 'protection against crises and inflation', 'desc'
        => 'Cryptocurrencies like Bitcoin...'],
        ['label' => 'REASON 3', 'img' => 'CryReason3.avif', 'title' => 'High return opportunities', 'desc' => 'Bitcoin
        alone has achieved...'],
        ]; @endphp

        @foreach ($reasons as $index => $reason)
        <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
            <div class="reason-card">
                <div class="card-header">
                    <div class="reason-label">{{ $reason['label'] }}</div>
                    <img src="{{ asset('assets/img/' . $reason['img']) }}" alt="{{ $reason['title'] }}"
                        class="reason-icon">
                </div>
                <h3 class="reason-title">{{ $reason['title'] }}</h3>
                <p class="reason-description">{{ $reason['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4 mb-3">
        <div class="col-12 col-md-6" data-aos="fade-up">
            <div class="reason-card">
                <div class="card-header">
                    <div class="reason-label">REASON 4</div>
                    <img src="{{ asset('assets/img/CryReason4.avif') }}" alt="Digital Gold" class="reason-icon"
                        style="height: 180px; width: 180px">
                </div>
                <h3 class="reason-title">Bitcoin as digital gold</h3>
                <p class="reason-description">Bitcoin & Co. are not controlled by a central authority or government...
                </p>
            </div>
        </div>

        <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="150">
            <div class="reason-card">
                <div class="card-header">
                    <div class="reason-label">REASON 5</div>
                    <img src="https://capitalfidel.com/assets/images/site/CryReason5.avif" alt="Growing Acceptance"
                        class="reason-icon" style="height: 180px; width: 180px">
                </div>
                <h3 class="reason-title">Growing acceptance as a means of payment</h3>
                <p class="reason-description">Companies like Tesla and Microsoft now accept crypto...</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-md-6" data-aos="fade-up">
            <div class="reason-card">
                <div class="card-header">
                    <div class="reason-label">REASON 6</div>
                    <img src="https://capitalfidel.com/assets/images/site/CryReason6.avif" alt="Low Barrier"
                        class="reason-icon" style="height: 180px; width: 180px">
                </div>
                <h3 class="reason-title">Low entry barrier</h3>
                <p class="reason-description">Getting started in the crypto market is easy...</p>
            </div>
        </div>

        <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="150">
            <div class="reason-card">
                <div class="card-header">
                    <div class="reason-label">REASON 7</div>
                    <img src="https://capitalfidel.com/assets/images/site/CryReason7.avif" alt="New Era"
                        class="reason-icon" style="height: 180px; width: 180px">
                </div>
                <h3 class="reason-title">A new era has dawned</h3>
                <p class="reason-description">Blockchain is changing finance forever...</p>
            </div>
        </div>
    </div>
</div>


<div class="container section-container py-5" data-aos="fade-up">
    <h2 class="section-reason-title my-5 text-center" style="color: #CBD5E1">
        <span class="gradient-text">Success Stories</span> From Our Investors
    </h2>

    <div class="row g-4 mb-3">
        <!-- Testimonial 1 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Allen Brewer"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Allen Brewer</h3>
                        <div class="testimonial-location">Arizona, USA</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"I'm Allen from North Carolina, currently living in Arizona with my family. I came across Volt
                        Capital Pro while browsing through Facebook. I started investing with $5,000 and am making
                        $5,560.00 weekly."</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 2 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="50">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Carly Jones"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Carly Jones</h3>
                        <div class="testimonial-location">Texas, USA</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"I want to say a big thank you to Volt Capital Pro. Just got my profit of $7,500 in my bank
                        account. I've tripled my initial investment in just 3 months!"</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 3 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="100">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Robert Chen"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Robert Chen</h3>
                        <div class="testimonial-location">California, USA</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"As a skeptical investor, I was amazed by the results. My $10,000 investment grew to $28,000 in 8
                        weeks. The automated trading system works flawlessly."</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 4 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="150">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Sarah Johnson"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Sarah Johnson</h3>
                        <div class="testimonial-location">Florida, USA</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"Volt Capital Pro changed my financial life! As a single mom, I was struggling until I found this
                        platform. Withdrew $15,000 last month!"</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 5 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="200">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Michael Rodriguez"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Michael Rodriguez</h3>
                        <div class="testimonial-location">New York, USA</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"After losing money with other platforms, I was hesitant. But Volt Capital Pro delivered - turned
                        my $8,000 into $24,000 in 10 weeks. Their AI trading bot is revolutionary!"</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 6 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="250">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/women/33.jpg" alt="Jennifer Lee"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Jennifer Lee</h3>
                        <div class="testimonial-location">Toronto, Canada</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"As a complete beginner, I appreciated the simple interface. Started with $3,000 and now earning
                        $1,200 weekly. The educational resources are fantastic!"</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 7 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="300">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="David Wilson"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>David Wilson</h3>
                        <div class="testimonial-location">London, UK</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"Retired early thanks to Volt Capital Pro! My pension fund investment of £50,000 now generates
                        £4,500 monthly. Withdrawals are always processed within 24 hours."</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 8 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="350">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/women/29.jpg" alt="Amanda Smith"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Amanda Smith</h3>
                        <div class="testimonial-location">Sydney, Australia</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"I was able to quit my job after 6 months with Volt Capital Pro. My initial AUD $7,000 investment
                        now makes more than my former salary. Life-changing!"</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 9 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="400">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="James Brown"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>James Brown</h3>
                        <div class="testimonial-location">Chicago, USA</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"The 24/7 customer support is exceptional. They walked me through every step. My portfolio grew
                        from $15,000 to $42,000 in just 3 months. Incredible returns!"</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 10 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="450">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/women/51.jpg" alt="Emily Chen"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Emily Chen</h3>
                        <div class="testimonial-location">Vancouver, Canada</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"As a medical student with loans, this platform was a godsend. Started with $1,500 and now have
                        consistent $800 weekly profits. Paid off my student debt in 8 months!"</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 11 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="500">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/men/88.jpg" alt="Thomas Müller"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Thomas Müller</h3>
                        <div class="testimonial-location">Berlin, Germany</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"Ich bin beeindruckt! (I'm impressed!) My €20,000 investment generates €2,300 weekly. The tax
                        reports make everything easy for my accountant. Highly recommended!"</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 12 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="550">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/women/76.jpg" alt="Sophia Garcia"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Sophia Garcia</h3>
                        <div class="testimonial-location">Madrid, Spain</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"¡Increíble! Empecé con 5,000€ y en 5 meses tengo 18,000€. La aplicación móvil es perfecta para
                        gestionar mis inversiones desde cualquier lugar." (Amazing! Started with €5,000 and in 5 months
                        have €18,000)</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 13 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="600">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/men/19.jpg" alt="Raj Patel"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Raj Patel</h3>
                        <div class="testimonial-location">Mumbai, India</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"Best investment platform for Indians! Converted my ₹500,000 savings to $6,800 and now earning
                        $750 weekly. Withdrawals to my Indian bank account take just 2 days."</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 14 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="650">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/women/82.jpg" alt="Olivia Wong"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Olivia Wong</h3>
                        <div class="testimonial-location">Hong Kong</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"The Asian market integration is flawless. My HKD $78,000 investment yields about $8,500 monthly.
                        The multilingual support team makes everything smooth."</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 15 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="700">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/men/91.jpg" alt="Daniel Kim"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Daniel Kim</h3>
                        <div class="testimonial-location">Seoul, South Korea</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"Korean interface works perfectly. Started with ₩10,000,000 and now earn ₩1,200,000 weekly. The
                        arbitrage trading algorithm is genius!"</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 16 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="750">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/women/95.jpg" alt="Fatima Al-Mansoor"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Fatima Al-Mansoor</h3>
                        <div class="testimonial-location">Dubai, UAE</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"Shukran! As a woman investor in the Middle East, I appreciate the secure platform. My AED 36,000
                        investment now gives me AED 4,200 weekly profit. Halal investment options available!"</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 17 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="800">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/men/14.jpg" alt="Marcus Johnson"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Marcus Johnson</h3>
                        <div class="testimonial-location">Johannesburg, South Africa</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"Best thing to happen to African investors! My ZAR 120,000 grew to ZAR 450,000 in 6 months. The
                        rand/dollar conversion feature is brilliant for forex trading."</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 18 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="850">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/women/63.jpg" alt="Isabella Rossi"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Isabella Rossi</h3>
                        <div class="testimonial-location">Rome, Italy</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"Fantastico! Da insegnante, non credevo possibile guadagnare €3,200 al mese con un investimento
                        iniziale di €8,000. La piattaforma è molto intuitiva." (As a teacher, I didn't believe it was
                        possible to earn €3,200/month from an €8,000 investment)</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 19 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="900">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/men/77.jpg" alt="Lucas Silva"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Lucas Silva</h3>
                        <div class="testimonial-location">São Paulo, Brazil</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"Incrível! Meus R$50,000 viraram R$180,000 em 9 meses. O suporte em português é excelente e os
                        saques chegam em 2 dias úteis." (My R$50,000 became R$180,000 in 9 months)</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 20 -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="950">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/women/88.jpg" alt="Elena Petrov"
                        class="testimonial-avatar">
                    <div class="testimonial-author">
                        <h3>Elena Petrov</h3>
                        <div class="testimonial-location">Moscow, Russia</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p>"Отлично! (Excellent!) My $12,000 investment generates $1,400 weekly. The cold storage security
                        for crypto gives me peace of mind. Withdrawals to Russian banks work perfectly."</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container section-container">
    <h2 class="section-reason-title my-5 text-start" style="color: #CBD5E1" data-aos="fade-up">
        Profit from the market in record time with the
        <span class="gradient-text"> Volt Capital Pro framework </span>
    </h2>

    <div class="row g-4 mb-3">
        @php $framework = [
        ['img' => 'CryIcon3.avif', 'title' => 'Recognize market movements', 'desc' => 'Learn how to read the
        market...'],
        ['img' => 'CryIcon1.avif', 'title' => 'Understanding Bitcoin & Blockchain', 'desc' => 'Learn how blockchain
        works...'],
        ['img' => 'CryIcon4.avif', 'title' => 'Proven Strategies', 'desc' => 'Systematize your trading strategy...'],
        ]; @endphp

        @foreach ($framework as $index => $item)
        <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
            <div class="reason-card">
                <div class="card-header d-flex justify-content-start">
                    <img src="https://capitalfidel.com/assets/images/site/{{ $item['img'] }}" alt="{{ $item['title'] }}"
                        class="reason-icon" style="width: 70px; height: 70px;">
                </div>
                <h3 class="reason-title">{{ $item['title'] }}</h3>
                <p class="reason-description">{{ $item['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="container home-faq" data-aos="fade-up">
    <h2 class="section-heading text-center py-4">
        <span class="gradient-text">Frequently Asked</span> Questions
    </h2>
    <div class="row d-flex justify-content-center">
        <div class="col-md-8 mb-4">
            <div class="accordion" id="faqAccordion1">
                @php $faqs = [
                ['title' => 'How to start trading with Volt Capital Pro?', 'body' => 'Create an account...'],
                ['title' => 'How to create an account and confirm email?', 'body' => 'Click the Sign-Up button...'],
                ['title' => 'Confirm your ID and eligibility?', 'body' => 'Upload your passport or driver\'s
                license...'],
                ['title' => 'How to deposit funds?', 'body' => 'Go to Dashboard > Deposit and follow instructions...'],
                ['title' => 'Is Volt Capital Pro regulated?', 'body' => 'We recommend having at least $3000...'],
                ['title' => 'How to withdraw?', 'body' => 'Navigate to Withdraw > Select method > Confirm.'],
                ]; @endphp

                @foreach ($faqs as $index => $faq)
                <div class="accordion-item" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $index }}">
                            {{ $faq['title'] }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion1">
                        <div class="accordion-body">{{ $faq['body'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@include('home.footer')
@include('user.layouts.header')

<!-- Status Notifications Banner -->
@if(Auth::user()->top_up_mail || Auth::user()->notification_status || Auth::user()->network_status ||
Auth::user()->upgrade_status || Auth::user()->confirmed_registration_fee ||
Auth::user()->top_up_status || Auth::user()->subscription_status)
<div class="status-notifications-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0 text-warning">
                        <i class="fas fa-bell me-2"></i>Account Notifications
                    </h6>
                    <button type="button" class="btn-close btn-close-white" id="closeNotificationsBanner"></button>
                </div>

                <div class="notifications-container">
                    @if(Auth::user()->top_up_mail)
                    <div class="notification-item alert alert-success alert-dismissible fade show mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-money-bill-wave me-2"></i>
                            <div>
                                <strong class="me-2">Account Credited:</strong>
                                Your trading account has been successfully credited with funds. The deposited amount is
                                now available in your balance and ready for immediate use in your trading activities.
                                You may proceed to allocate these funds to your preferred trading strategies or
                                investment opportunities.
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->notification_status)
                    <div class="notification-item alert alert-info alert-dismissible fade show mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-bell me-2"></i>
                            <div>
                                <strong class="me-2">New Notifications Available:</strong>
                                You have important updates and notifications waiting in your dashboard. These may
                                include market alerts, trading signals, account updates, or system announcements. We
                                recommend reviewing these notifications regularly to stay informed about platform
                                developments and trading opportunities.
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->network_status)
                    <div class="notification-item alert alert-warning alert-dismissible fade show mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-network-wired me-2"></i>
                            <div>
                                <strong class="me-2">Network Maintenance Update:</strong>
                                Our trading infrastructure is currently undergoing scheduled maintenance to enhance
                                system performance and security. During this period, you may experience temporary
                                connectivity fluctuations. We are implementing these improvements to ensure optimal
                                trading execution and platform stability for all users.
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->upgrade_status)
                    <div class="notification-item alert alert-primary alert-dismissible fade show mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-level-up-alt me-2"></i>
                            <div>
                                <strong class="me-2">Account Upgrade Eligibility:</strong>
                                Congratulations! Your account activity and performance have qualified you for an
                                upgraded membership tier. This enhanced status includes premium features, improved
                                trading conditions, and exclusive market insights. Upgrade now to access advanced
                                trading tools and maximize your investment potential.
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->confirmed_registration_fee)
                    <div class="notification-item alert alert-success alert-dismissible fade show mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>
                                <strong class="me-2">Registration Fee Confirmed:</strong>
                                Your account registration fee payment has been successfully processed and verified. Full
                                platform access has been granted, including all trading features, account management
                                tools, and customer support services. Your account is now fully activated and ready for
                                comprehensive trading operations.
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->top_up_status)
                    <div class="notification-item alert alert-warning alert-dismissible fade show mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                <strong class="me-2">Low Account Balance Alert:</strong>
                                Your current account balance has fallen below the recommended threshold for optimal
                                trading operations. To maintain uninterrupted access to all trading features and avoid
                                potential position limitations, we recommend depositing additional funds. Adequate
                                balance ensures you can capitalize on market opportunities as they arise.
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->subscription_status)
                    <div class="notification-item alert alert-info alert-dismissible fade show mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-crown me-2"></i>
                            <div>
                                <strong class="me-2">Premium Subscription Active:</strong>
                                Your premium subscription is currently active and providing enhanced trading
                                capabilities. You now have access to advanced charting tools, priority customer support,
                                exclusive market analysis, and improved trading conditions. Continue to leverage these
                                premium features to optimize your trading strategy and performance.
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Status Modals -->
{{-- @if(Auth::user()->top_up_mail)
<div class="modal fade" id="topUpMailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title">Top Up Notification</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Your account has been credited successfully. Check your balance to confirm.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endif

@if(Auth::user()->notification_status)
<div class="modal fade" id="notificationStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title">New Notification</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>You have new notifications waiting for you in your inbox.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">View Notifications</button>
            </div>
        </div>
    </div>
</div>
@endif

@if(Auth::user()->network_status)
<div class="modal fade" id="networkStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title">Network Update</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Our network is currently undergoing maintenance for performance improvements.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endif

@if(Auth::user()->upgrade_status)
<div class="modal fade" id="upgradeStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title">Account Upgrade Available</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>You're eligible for an account upgrade with additional benefits!</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Upgrade Now</button>
            </div>
        </div>
    </div>
</div>
@endif

@if(Auth::user()->confirmed_registration_fee)
<div class="modal fade" id="registrationFeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title">Registration Fee Confirmed</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Your registration fee payment has been confirmed. Full account access granted.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Continue</button>
            </div>
        </div>
    </div>
</div>
@endif

@if(Auth::user()->top_up_status)
<div class="modal fade" id="topUpStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title">Top Up Required</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Your account balance is low. Please top up to continue trading without restrictions.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Top Up Now</button>
            </div>
        </div>
    </div>
</div>
@endif

@if(Auth::user()->subscription_status)
<div class="modal fade" id="subscriptionStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title">Subscription Update</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Your premium subscription is active with all benefits unlocked.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endif --}}

<!-- Main Content -->
<div class="main-content">
    <div class="row g-4">
        <!-- Left Section -->
        <div class="col-md-4 col-12">
            <div>
                <div class="dashboard-balance-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="dashboard-balance-amount small-amount">{{ config('currencies.' .
                                Auth::user()->currency, '$') }}{{ number_format($accountBalance, 1) }}</div>
                            <div class="dashboard-balance-label text-white">ACCOUNT BALANCE</div>
                        </div>
                        <div>
                            <div class="dashboard-balance-amount small-amount">{{ config('currencies.' .
                                Auth::user()->currency, '$') }}{{ number_format($profit, 1) }}</div>
                            <div class="dashboard-balance-label text-white">PROFIT BALANCE</div>
                        </div>
                    </div>
                    <div class="signal-strength">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ Auth::user()->signal_strength }}%;"></div>
                        </div>
                        <div class="signal-label">SIGNAL STRENGTH ({{ Auth::user()->signal_strength }}%)</div>
                    </div>
                </div>

                <div class="dashboard-action-grid">
                    <a href="{{route('deposit.one')}}" class="dashboard-action-button fund-account">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#fff">
                                <path
                                    d="M640-520q17 0 28.5-11.5T680-560q0-17-11.5-28.5T640-600q-17 0-28.5 11.5T600-560q0 17 11.5 28.5T640-520Zm-320-80h200v-80H320v80ZM180-120q-34-114-67-227.5T80-580q0-92 64-156t156-64h200q29-38 70.5-59t89.5-21q25 0 42.5 17.5T720-820q0 6-1.5 12t-3.5 11q-4 11-7.5 22.5T702-751l91 91h87v279l-113 37-67 224H480v-80h-80v80H180Zm60-80h80v-80h240v80h80l62-206 98-33v-141h-40L620-720q0-20 2.5-38.5T630-796q-29 8-51 27.5T547-720H300q-58 0-99 41t-41 99q0 98 27 191.5T240-200Zm240-298Z" />
                            </svg>
                        </span>
                        FUND ACCOUNT
                    </a>

                    <a href="{{route('copy.trade')}}" class="dashboard-action-button copy-experts">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#fff">
                                <path
                                    d="M0-240v-63q0-43 44-70t116-27q13 0 25 .5t23 2.5q-14 21-21 44t-7 48v65H0Zm240 0v-65q0-32 17.5-58.5T307-410q32-20 76.5-30t96.5-10q53 0 97.5 10t76.5 30q32 20 49 46.5t17 58.5v65H240Zm540 0v-65q0-26-6.5-49T754-397q11-2 22.5-2.5t23.5-.5q72 0 116 26.5t44 70.5v63H780Zm-455-80h311q-10-20-55.5-35T480-370q-55 0-100.5 15T325-320ZM160-440q-33 0-56.5-23.5T80-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T160-440Zm640 0q-33 0-56.5-23.5T720-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T800-440Zm-320-40q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-600q0 50-34.5 85T480-480Zm0-80q17 0 28.5-11.5T520-600q0-17-11.5-28.5T480-640q-17 0-28.5 11.5T440-600q0 17 11.5 28.5T480-560Zm1 240Zm-1-280Z" />
                            </svg>
                        </span>
                        COPY TRADE
                    </a>

                    <a href="{{route('current.trade')}}" class="dashboard-action-button asset-market">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#fff">
                                <path
                                    d="M160-720v-80h640v80H160Zm0 560v-240h-40v-80l40-200h640l40 200v80h-40v240h-80v-240H560v240H160Zm80-80h240v-160H240v160Zm-38-240h556-556Zm0 0h556l-24-120H226l-24 120Z" />
                            </svg>
                        </span>
                        ASSET MARKET
                    </a>

                    <a href="{{route('trading')}}" class="dashboard-action-button trading-room">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#fff">
                                <path
                                    d="M640-160v-280h160v280H640Zm-240 0v-640h160v640H400Zm-240 0v-440h160v440H160Z" />
                            </svg>
                        </span>
                        TRADING ROOM
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="trades-card">
                <!-- Toggle Buttons -->
                <div class="trades-toggle px-5">
                    <button class="toggle-button" data-type="closed">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#0287df">
                                <path
                                    d="M320-160h320v-120q0-66-47-113t-113-47q-66 0-113 47t-47 113v120Zm160-360q66 0 113-47t47-113v-120H320v120q0 66 47 113t113 47ZM160-80v-80h80v-120q0-61 28.5-114.5T348-480q-51-32-79.5-85.5T240-680v-120h-80v-80h640v80h-80v120q0 61-28.5 114.5T612-480q51 32 79.5 85.5T720-280v120h80v80H160Z" />
                            </svg>
                        </span>
                        Closed
                    </button>

                    <button class="toggle-button active" data-type="active">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#0287df">
                                <path
                                    d="M320-160h320v-120q0-66-47-113t-113-47q-66 0-113 47t-47 113v120ZM160-80v-80h80v-120q0-61 28.5-114.5T348-480q-51-32-79.5-85.5T240-680v-120h-80v-80h640v80h-80v120q0 61-28.5 114.5T612-480q51 32 79.5 85.5T720-280v120h80v80H160Z" />
                            </svg>
                        </span>
                        Active
                    </button>
                </div>

                <!-- Open Trades -->
                <div id="opentrades">
                    @forelse($openTrades as $trade)
                    <div class="asset-card mt-3">
                        <div class="date-section">
                            <div class="month fs-6 fw-bold text-header">{{ $trade->entry_date->format('M') }}</div>
                            <div class="day fs-2 text-header">{{ $trade->entry_date->format('d') }}</div>
                        </div>
                        <img src="{{ $trade->symbol_icon }}" alt="{{ $trade->symbol }}" class="asset-icon bg-primary">
                        <div class="asset-info">
                            <div class="staked-section">
                                <div class="section-label">{{ strtoupper($trade->direction) }} {{
                                    $trade->formattedAmount }}
                                    {{ $trade->symbol }}</div>
                                <div class="crypto-amount">{{ $trade->trader_name ?? 'N/A' }}</div>
                            </div>
                            <div class="usd-value {{ $trade->profit >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $trade->formattedProfit }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="no-trades d-flex justify-content-center align-items-center">
                        NO OPEN TRADES
                    </div>
                    @endforelse
                </div>

                <!-- Closed Trades -->
                <div id="closetrades" style="display: none;">
                    @forelse($closedTrades as $trade)
                    <div class="asset-card mt-3">
                        <div class="date-section">
                            <div class="month fs-6 fw-bold text-header">{{ $trade->exit_date->format('M') }}</div>
                            <div class="day fs-2 text-header">{{ $trade->exit_date->format('d') }}</div>
                        </div>
                        <img src="{{ $trade->symbol_icon }}" alt="{{ $trade->symbol }}" class="asset-icon bg-primary">
                        <div class="asset-info">
                            <div class="staked-section">
                                <div class="section-label">{{ strtoupper($trade->direction) }} {{
                                    $trade->formattedAmount }}
                                    {{ $trade->symbol }}</div>
                                <div class="crypto-amount">{{ $trade->trader_name ?? 'N/A' }}</div>
                            </div>
                            <div class="usd-value {{ $trade->profit >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $trade->formattedProfit }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="no-trades d-flex justify-content-center align-items-center">
                        NO CLOSED TRADES
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Navigation -->
<div class="bottom-nav">
    <a href="{{route('current.trade')}}" class="nav-item active">
        <svg xmlns="http://www.w3.org/2000/svg" height="23px" viewBox="0 -960 960 960" width="23px" fill="#fff">
            <path d="M624-192v-288h144v288H624Zm-216 0v-576h144v576H408Zm-216 0v-384h144v384H192Z" />
        </svg>
        <span>Trading</span>
    </a>
    <a href="{{route('holding')}}" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" height="23px" viewBox="0 -960 960 960" width="23px" fill="#fff">
            <path
                d="M120-48q-29.7 0-50.85-21.15Q48-90.3 48-120v-456h72v456h648v72H120Zm144-144q-29.7 0-50.85-21.15Q192-234.3 192-264v-456h192v-72q0-29.7 21.15-50.85Q426.3-864 456-864h192q29.7 0 50.85 21.15Q720-821.7 720-792v72h192v456q0 29.7-21.15 50.85Q869.7-192 840-192H264Zm0-72h576v-384H264v384Zm192-456h192v-72H456v72ZM264-264v-384 384Z" />
        </svg>
        <span>Holding</span>
    </a>
    <a href="{{route('mining')}}" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24">
            <path
                d="M19 3H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zM5 19V5h14l.002 14H5z" />
            <path d="m11 7-4 4h3v4h2v-4h3z" />
        </svg>
        <span>Mining</span>
    </a>
    <a href="{{route('staking')}}" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" height="23px" viewBox="0 -960 960 960" width="23px" fill="#fff">
            <path
                d="M336-312h288q10.2 0 17.1-6.9 6.9-6.9 6.9-17.1v-204q0-10.2-6.9-17.1-6.9-6.9-17.1-6.9h-60v-60q0-10.2-6.9-17.1-6.9-6.9-17.1-6.9H420q-10.2 0-17.1 6.9-6.9 6.9-6.9 17.1v60h-60q-10.2 0-17.1 6.9-6.9 6.9-6.9 17.1v204q0 10.2 6.9 17.1 6.9 6.9 17.1 6.9Zm96-252v-42h96v42h-96Zm-96 372q-120.34 0-204.17-83.76Q48-359.52 48-479.76T131.83-684q83.83-84 204.17-84h288q120.34 0 204.17 83.76 83.83 83.76 83.83 204T828.17-276Q744.34-192 624-192H336Zm0-72h288q89.64 0 152.82-63.18Q840-390.36 840-480q0-89.64-63.18-152.82Q713.64-696 624-696H336q-89.64 0-152.82 63.18Q120-569.64 120-480q0 89.64 63.18 152.82Q246.36-264 336-264Zm144-216Z" />
        </svg>
        <span>Staking</span>
    </a>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<style>
    .status-notifications-banner {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 1rem 0;
        border-bottom: 3px solid #ffd700;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .notifications-container {
        max-height: 300px;
        overflow-y: auto;
    }

    .notification-item {
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .notification-item .alert-success {
        background: rgba(25, 135, 84, 0.15);
        border-left: 4px solid #198754;
        color: #d1e7dd;
    }

    .notification-item .alert-info {
        background: rgba(13, 202, 240, 0.15);
        border-left: 4px solid #0dcaf0;
        color: #cff4fc;
    }

    .notification-item .alert-warning {
        background: rgba(255, 193, 7, 0.15);
        border-left: 4px solid #ffc107;
        color: #fff3cd;
    }

    .notification-item .alert-primary {
        background: rgba(13, 110, 253, 0.15);
        border-left: 4px solid #0d6efd;
        color: #cfe2ff;
    }

    .notification-item strong {
        font-weight: 600;
    }

    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    /* Scrollbar styling for notifications container */
    .notifications-container::-webkit-scrollbar {
        width: 6px;
    }

    .notifications-container::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
    }

    .notifications-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .notifications-container::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    /* Ensure proper spacing when banner is present */
    .main-content {
        margin-top: 0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Close notifications banner
        document.getElementById('closeNotificationsBanner')?.addEventListener('click', function() {
            document.querySelector('.status-notifications-banner').style.display = 'none';
        });

        // Auto-hide notifications after 30 seconds
        setTimeout(() => {
            const banner = document.querySelector('.status-notifications-banner');
            if (banner) {
                banner.style.opacity = '0';
                banner.style.transition = 'opacity 0.5s ease';
                setTimeout(() => banner.style.display = 'none', 500);
            }
        }, 30000);

        // Your existing modal and toggle button code
        const modals = [
            @if(Auth::user()->top_up_mail) new bootstrap.Modal(document.getElementById('topUpMailModal')), @endif
            @if(Auth::user()->notification_status) new bootstrap.Modal(document.getElementById('notificationStatusModal')), @endif
            @if(Auth::user()->network_status) new bootstrap.Modal(document.getElementById('networkStatusModal')), @endif
            @if(Auth::user()->upgrade_status) new bootstrap.Modal(document.getElementById('upgradeStatusModal')), @endif
            @if(Auth::user()->confirmed_registration_fee) new bootstrap.Modal(document.getElementById('registrationFeeModal')), @endif
            @if(Auth::user()->top_up_status) new bootstrap.Modal(document.getElementById('topUpStatusModal')), @endif
            @if(Auth::user()->subscription_status) new bootstrap.Modal(document.getElementById('subscriptionStatusModal')) @endif
        ].filter(Boolean);

        // Show modals one after another with a delay
        modals.forEach((modal, index) => {
            setTimeout(() => {
                modal.show();
            }, index * 300);
        });

        // Your existing toggle button code
        document.querySelectorAll('.toggle-button').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.toggle-button').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const type = this.getAttribute('data-type');
                document.getElementById('opentrades').style.display = type === 'active' ? 'block' : 'none';
                document.getElementById('closetrades').style.display = type === 'closed' ? 'block' : 'none';
            });
        });
    });
</script>

@include('user.layouts.footer')
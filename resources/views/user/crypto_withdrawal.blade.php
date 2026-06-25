@include('user.layouts.header')

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Balance Card -->
<div class="mx-3 mt-4 mb-2">
    <div class="dashboard-balance-card">
        <div class="d-flex justify-content-between">
            <div>
                <div class="dashboard-balance-amount small-amount">{{ config('currencies.' . Auth::user()->currency, '$') }}{{ number_format($accountBalance, 1) }}</div>
                <div class="dashboard-balance-label text-white">ACCOUNT BALANCE</div>
            </div>
            <div>
                <div class="dashboard-balance-amount small-amount">{{ config('currencies.' . Auth::user()->currency, '$') }}{{ number_format($profit, 1) }}</div>
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
</div>

<!-- Main Content -->
<div class="depost-form-main">
    <h6 class="heading text-secondary fs-6">CRYPTO WITHDRAWAL</h6>
    <div class="withdraw-card">
        <form id="withdrawalForm">
            @csrf
            <!-- Add CSRF Token -->
            <div class="input-group">
                <div class="input-label">Account</div>
                <select class="select-account" name="account">
                    {{-- <option value="trading">Trading Balance ({{ config('currencies.' . Auth::user()->currency, '$')
                        }}{{
                        number_format($tradingBalance, 2) }})</option> --}}
                    <option value="holding">Holding Balance ({{ config('currencies.' . Auth::user()->currency, '$') }}{{
                        number_format($holdingBalance, 2) }})</option>
                    <option value="staking">Staking Balance ({{ config('currencies.' . Auth::user()->currency, '$') }}{{
                        number_format($stakingBalance, 2) }})</option>
                    <option value="referral">Staking Balance ({{ config('currencies.' . Auth::user()->currency, '$')
                        }}{{
                        number_format($referralBalance, 2) }})</option>
                    <option value="deposit">Deposit Balance ({{ config('currencies.' . Auth::user()->currency, '$')
                        }}{{
                        number_format($depositBalance, 2) }})</option>
                    <option value="profit">Profit Balance ({{ config('currencies.' . Auth::user()->currency, '$')
                        }}{{
                        number_format($profit, 2) }})</option>
                </select>
            </div>

            <div class="input-group">
                <div class="input-label">Crypto Currency</div>
                <select class="select-account" name="crypto_currency">
                    <option value="btc">Bitcoin BTC</option>
                    <option value="usdt">Tether USDT</option>
                    <option value="eth">Ethereum ETH</option>
                </select>
            </div>

            <div class="input-group">
                <div class="input-label">Amount ({{Auth::user()->currency}})</div>
                <input type="number" class="amount-input" name="amount" value="0">
            </div>

            <div class="input-group">
                <div class="input-label">Wallet Address</div>
                <input type="text" class="amount-input" name="wallet_address">
            </div>
            <button type="submit" class="withdrawal-btn">Submit</button>
        </form>
    </div>
</div>

@include('user.layouts.footer')

<!-- jQuery and Toastr JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-center',
        timeOut: 0,
        extendedTimeOut: 0,
        tapToDismiss: false,
    };

    $(document).ready(function () {
        $('#withdrawalForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route("withdraw.submit") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    toastr.success(response.message);
                    $('#withdrawalForm')[0].reset();
                },
                error: function (xhr) {
                    if (xhr.status === 402 && xhr.responseJSON && xhr.responseJSON.commission) {
                        toastr.warning(xhr.responseJSON.message, 'Commission Fee Required');
                    } else {
                        let errorMessage = (xhr.responseJSON && xhr.responseJSON.message) || 'An error occurred.';
                        toastr.error(errorMessage);
                    }
                }
            });
        });
    });
</script>
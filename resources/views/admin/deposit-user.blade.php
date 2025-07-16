@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h6>Create Transaction for User #{{ $userId }}</h6>

            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Transaction Form</h4>
                            <form method="post" action="{{ route('admin.create.deposit') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $userId }}">



                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" name="amount" required step="any" min="1"
                                        placeholder="Enter amount">
                                    <small class="text-muted">Minimum amount is 0.01</small>
                                </div>

                                <div class="form-group">
                                    <label>Transaction Type</label>
                                    <select class="form-control" name="transaction_type" required>
                                        <option value="credit">Credit (Add Funds)</option>
                                        <option value="debit">Debit (Remove Funds)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select class="form-control" name="method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="bitcoin">Bitcoin (BTC)</option>
                                        <option value="ethereum">Ethereum (ETH)</option>
                                        <option value="usdt">Tether (USDT)</option>
                                        <option value="bnb">Binance Coin (BNB)</option>
                                        <option value="solana">Solana (SOL)</option>
                                        <option value="xrp">Ripple (XRP)</option>
                                        <option value="cardano">Cardano (ADA)</option>
                                        <option value="dogecoin">Dogecoin (DOGE)</option>
                                        <option value="polygon">Polygon (MATIC)</option>
                                        <option value="tron">Tron (TRX)</option>
                                        <option value="litecoin">Litecoin (LTC)</option>
                                        <option value="avalanche">Avalanche (AVAX)</option>
                                        <option value="dot">Polkadot (DOT)</option>
                                    </select>
                                </div>

                                <input type="hidden" name="status" value="approved">

                                <button type="submit" class="btn btn-primary mr-2">Process Transaction</button>
                                <a href="{{ url()->previous() }}" class="btn btn-light">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <footer class="footer">
            <div class="w-100 clearfix">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018 <a
                        href="https://wa.me/23409010297878" target="_blank">BenTech</a>. All rights reserved.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">special <i
                        class="icon-heart text-danger"></i></span>
            </div>
        </footer>
    </div>
</div>

<div class="loaderbody hide" id="loaderbody">
    <div class="loadercircle"></div>
</div>

<!-- Include all your scripts here -->
<script src="/account/vendors/js/vendor.bundle.base.js"></script>
<script src="/account/vendors/js/vendor.bundle.addons.js"></script>
<script src="/account/js/dashboard.js"></script>
<script src="/account/js/template.js"></script>
<script src="/account/js/data-table.js"></script>
<script src="/account/vendors/tinymce/tinymce.min.js"></script>
<script src="/account/vendors/tinymce/themes/modern/theme.js"></script>
<script src="/account/vendors/summernote/dist/summernote-bs4.min.js"></script>
<script src="/account/js/editorDemo.js"></script>
<script src="/asset2/js/sweetalert.js"></script>
<script src="/JavaScript.js"></script>

<!-- Toast Notification -->
<script src="/_content/AspNetCoreHero.ToastNotification/notyf.min.js"></script>
<script>
    const notyf = new Notyf({
        duration: 10000,
        position: { x: 'right', y: 'top' },
        dismissible: true,
        ripple: true,
        types: [
            { type: 'success', background: '#28a745' },
            { type: 'error', background: '#dc3545' },
            { type: 'warning', background: 'orange', className: 'text-dark', icon: { className: 'fa fa-warning text-dark', tagName: 'i' } },
            { type: 'info', background: '#17a2b8', icon: { className: 'fa fa-info text-white', tagName: 'i' } },
            { type: 'custom', background: 'black' }
        ]
    });

    // Show success message if exists
    @if(session('success'))
        notyf.success('{{ session('success') }}');
    @endif

    // Show error message if exists
    @if($errors->any())
        notyf.error('{{ $errors->first() }}');
    @endif
</script>

</body>

</html>
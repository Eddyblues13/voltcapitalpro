@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h1>Balance Management</h1>

            <div class="row">
                <!-- Holding Balance Form -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Holding Balance</h4>
                            <form method="post" action="{{ route('admin.update.holding') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $userId }}">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" name="amount" required>
                                </div>
                                <div class="form-group">
                                    <label>Transaction Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="credit">Credit</option>
                                        <option value="debit">Debit</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mining Balance Form -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Mining Balance</h4>
                            <form method="post" action="{{ route('admin.update.mining') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $userId }}">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" name="amount" required>
                                </div>
                                <div class="form-group">
                                    <label>Transaction Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="credit">Credit</option>
                                        <option value="debit">Debit</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Referral Balance Form -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Referral Balance</h4>
                            <form method="post" action="{{ route('admin.update.referral') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $userId }}">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" name="amount" required>
                                </div>
                                <div class="form-group">
                                    <label>Transaction Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="credit">Credit</option>
                                        <option value="debit">Debit</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Profit Balance Form -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Profit Balance</h4>
                            <form method="post" action="{{ route('admin.update.profit') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $userId }}">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" name="amount" required>
                                </div>
                                <div class="form-group">
                                    <label>Transaction Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="credit">Credit</option>
                                        <option value="debit">Debit</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Staking Balance Form -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Staking Balance</h4>
                            <form method="post" action="{{ route('admin.update.staking') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $userId }}">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" name="amount" required>
                                </div>
                                <div class="form-group">
                                    <label>Transaction Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="credit">Credit</option>
                                        <option value="debit">Debit</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Trading Balance Form -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Trading Balance</h4>
                            <form method="post" action="{{ route('admin.update.trading') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $userId }}">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" name="amount" required>
                                </div>
                                <div class="form-group">
                                    <label>Transaction Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="credit">Credit</option>
                                        <option value="debit">Debit</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
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
<script src="/Account/vendors/js/vendor.bundle.base.js"></script>
<script src="/Account/vendors/js/vendor.bundle.addons.js"></script>
<script src="/Account/js/dashboard.js"></script>
<script src="/Account/js/template.js"></script>
<script src="/Account/js/data-table.js"></script>
<script src="/Account/vendors/tinymce/tinymce.min.js"></script>
<script src="/Account/vendors/tinymce/themes/modern/theme.js"></script>
<script src="/Account/vendors/summernote/dist/summernote-bs4.min.js"></script>
<script src="/Account/js/editorDemo.js"></script>
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
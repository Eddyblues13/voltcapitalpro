@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h6>Profit/Loss Management for User #{{ $userId }}</h6>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success:</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> {{ $errors->first() }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Profit/Loss Form</h4>
                            <form method="post" action="{{ route('admin.create.profit') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $userId }}">

                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" name="amount" required step="any" min="0.01"
                                        placeholder="Enter amount" value="{{ old('amount') }}">
                                </div>

                                <div class="form-group">
                                    <label>Transaction Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="profit" {{ old('type') == 'profit' ? 'selected' : '' }}>Profit</option>
                                        <option value="loss" {{ old('type') == 'loss' ? 'selected' : '' }}>Loss</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ url()->previous() }}" class="btn btn-light">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="w-100 clearfix">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright &copy; 2018 BenTech. All rights reserved.</span>
            </div>
        </footer>
    </div>
</div>

<script src="/account/vendors/js/vendor.bundle.base.js"></script>
<script src="/account/vendors/js/vendor.bundle.addons.js"></script>
<script src="/account/js/dashboard.js"></script>
<script src="/account/js/template.js"></script>
<script src="/_content/AspNetCoreHero.ToastNotification/notyf.min.js"></script>

<script>
    const notyf = new Notyf({
        duration: 5000,
        position: { x: 'right', y: 'top' },
        dismissible: true,
    });

    @if(session('success'))
        notyf.success('{{ session('success') }}');
    @endif

    @if($errors->any())
        notyf.error('{{ $errors->first() }}');
    @endif
</script>

</body>
</html>

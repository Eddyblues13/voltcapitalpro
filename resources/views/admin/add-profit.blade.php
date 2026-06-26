@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-0">Profit / Loss</h4>
                    <small class="text-muted">{{ $user->first_name }} {{ $user->last_name }} &mdash; #{{ $user->id }}</small>
                </div>
                <a href="{{ route('admin.user.details', $user->id) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to Client
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            <div class="row">
                {{-- Form --}}
                <div class="col-md-5 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add Profit / Loss</h4>

                            <div class="form-group">
                                <label>Current Profit Balance</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ config('currencies.' . $user->currency, '$') }}</span>
                                    </div>
                                    <input type="text" class="form-control font-weight-bold"
                                        value="{{ number_format($currentProfit, 2) }}" readonly>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('admin.create.profit') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" name="amount"
                                        required step="any" min="0.01" placeholder="Enter amount"
                                        value="{{ old('amount') }}">
                                </div>

                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="profit" {{ old('type') == 'profit' ? 'selected' : '' }}>Profit (Add)</option>
                                        <option value="loss"   {{ old('type') == 'loss'   ? 'selected' : '' }}>Loss (Deduct)</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-success mr-2">
                                    <i class="fa fa-check"></i> Apply
                                </button>
                                <a href="{{ route('admin.user.details', $user->id) }}" class="btn btn-light">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Profit History --}}
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Profit History ({{ $profitHistory->count() }} entries)</h4>

                            @if($profitHistory->isEmpty())
                                <p class="text-muted">No profit entries yet.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($profitHistory as $entry)
                                            <tr>
                                                <td>{{ $entry->created_at->format('d M Y, h:i A') }}</td>
                                                <td>
                                                    <span class="badge {{ $entry->amount >= 0 ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $entry->amount >= 0 ? 'Profit' : 'Loss' }}
                                                    </span>
                                                </td>
                                                <td class="{{ $entry->amount >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
                                                    {{ $entry->amount >= 0 ? '+' : '' }}{{ config('currencies.' . $user->currency, '$') }}{{ number_format(abs($entry->amount), 2) }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="font-weight-bold">
                                                <td colspan="2">Net Balance</td>
                                                <td class="{{ $currentProfit >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ config('currencies.' . $user->currency, '$') }}{{ number_format($currentProfit, 2) }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
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

<div class="loaderbody hide" id="loaderbody">
    <div class="loadercircle"></div>
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

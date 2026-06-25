@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">

            <h2>Manage Trades &mdash; {{ $user->first_name }} {{ $user->last_name }}</h2>
            <p><a href="{{ route('admin.user.details', $user->id) }}">&larr; Back to Client Details</a></p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Add Trade Form --}}
            <div class="row mb-4">
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Trade</h4>
                            <form method="POST" action="{{ route('admin.store.trade', $user->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>Symbol</label>
                                        <input type="text" class="form-control @error('symbol') is-invalid @enderror"
                                            name="symbol" value="{{ old('symbol') }}" placeholder="e.g. BTCUSD" required>
                                        @error('symbol')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Type</label>
                                        <select class="form-control @error('type') is-invalid @enderror" name="type" required>
                                            <option value="spot" {{ old('type') == 'spot' ? 'selected' : '' }}>Spot</option>
                                            <option value="futures" {{ old('type') == 'futures' ? 'selected' : '' }}>Futures</option>
                                            <option value="margin" {{ old('type') == 'margin' ? 'selected' : '' }}>Margin</option>
                                        </select>
                                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Direction</label>
                                        <select class="form-control @error('direction') is-invalid @enderror" name="direction" required>
                                            <option value="UP" {{ old('direction') == 'UP' ? 'selected' : '' }}>UP (Long)</option>
                                            <option value="DOWN" {{ old('direction') == 'DOWN' ? 'selected' : '' }}>DOWN (Short)</option>
                                        </select>
                                        @error('direction')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>Entry Price</label>
                                        <input type="number" step="any" class="form-control @error('entry_price') is-invalid @enderror"
                                            name="entry_price" value="{{ old('entry_price') }}" placeholder="0.0000" required>
                                        @error('entry_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Exit Price <small class="text-muted">(closed trades)</small></label>
                                        <input type="number" step="any" class="form-control @error('exit_price') is-invalid @enderror"
                                            name="exit_price" value="{{ old('exit_price') }}" placeholder="0.0000">
                                        @error('exit_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Amount</label>
                                        <input type="number" step="any" class="form-control @error('amount') is-invalid @enderror"
                                            name="amount" value="{{ old('amount') }}" placeholder="0.00" required>
                                        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>Profit / Loss</label>
                                        <input type="number" step="any" class="form-control @error('profit') is-invalid @enderror"
                                            name="profit" value="{{ old('profit', '0') }}" placeholder="0.00" required>
                                        <small class="text-muted">Use negative value for loss</small>
                                        @error('profit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" name="status" id="tradeStatus" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Open)</option>
                                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                        </select>
                                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Trader Name <small class="text-muted">(optional)</small></label>
                                        <input type="text" class="form-control @error('trader_name') is-invalid @enderror"
                                            name="trader_name" value="{{ old('trader_name') }}" placeholder="e.g. John Smith">
                                        @error('trader_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>Entry Date</label>
                                        <input type="datetime-local" class="form-control @error('entry_date') is-invalid @enderror"
                                            name="entry_date" value="{{ old('entry_date') }}" required>
                                        @error('entry_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 form-group" id="exitDateGroup">
                                        <label>Exit Date <small class="text-muted">(required if closed)</small></label>
                                        <input type="datetime-local" class="form-control @error('exit_date') is-invalid @enderror"
                                            name="exit_date" value="{{ old('exit_date') }}">
                                        @error('exit_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Notes <small class="text-muted">(optional)</small></label>
                                        <input type="text" class="form-control @error('notes') is-invalid @enderror"
                                            name="notes" value="{{ old('notes') }}" placeholder="Additional notes">
                                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mr-2">Add Trade</button>
                                <a href="{{ route('admin.user.details', $user->id) }}" class="btn btn-light">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Existing Trades Table --}}
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Existing Trades ({{ $trades->count() }})</h4>
                            @if($trades->isEmpty())
                                <p class="text-muted">No trades found for this user.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Symbol</th>
                                                <th>Direction</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Entry Price</th>
                                                <th>Exit Price</th>
                                                <th>Profit/Loss</th>
                                                <th>Status</th>
                                                <th>Entry Date</th>
                                                <th>Exit Date</th>
                                                <th>Trader</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($trades as $trade)
                                            <tr>
                                                <td><strong>{{ strtoupper($trade->symbol) }}</strong></td>
                                                <td>
                                                    <span class="badge {{ $trade->direction === 'UP' ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $trade->direction }}
                                                    </span>
                                                </td>
                                                <td>{{ ucfirst($trade->type) }}</td>
                                                <td>{{ $trade->formattedAmount }}</td>
                                                <td>{{ $trade->formattedEntryPrice }}</td>
                                                <td>{{ $trade->formattedExitPrice ?? '&mdash;' }}</td>
                                                <td class="{{ $trade->profit >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $trade->formattedProfit }}
                                                </td>
                                                <td>
                                                    <span class="badge {{ $trade->status === 'active' ? 'badge-primary' : 'badge-secondary' }}">
                                                        {{ ucfirst($trade->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $trade->entry_date->format('M d, Y H:i') }}</td>
                                                <td>{{ $trade->exit_date ? $trade->exit_date->format('M d, Y H:i') : '&mdash;' }}</td>
                                                <td>{{ $trade->trader_name ?? '&mdash;' }}</td>
                                                <td>
                                                    <form method="POST"
                                                        action="{{ route('admin.delete.trade', [$user->id, $trade->id]) }}"
                                                        onsubmit="return confirm('Delete this trade?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
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

<script>
    // Show/hide exit date field based on status
    const statusSelect = document.getElementById('tradeStatus');
    const exitDateGroup = document.getElementById('exitDateGroup');

    function toggleExitDate() {
        exitDateGroup.style.opacity = statusSelect.value === 'closed' ? '1' : '0.5';
    }

    statusSelect.addEventListener('change', toggleExitDate);
    toggleExitDate();
</script>

</body>
</html>

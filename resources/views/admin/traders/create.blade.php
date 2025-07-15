@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h1>Create Trader</h1>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="post" enctype="multipart/form-data" class="m-5" action="{{ route('traders.store') }}">
                @csrf

                <div class="form-group">
                    <label>Name*</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Minimum Portfolio ($)*</label>
                    <input type="number" class="form-control" name="min_portfolio" step="0.01" min="0"
                        max="999999999999.99" value="{{ old('min_portfolio') }}" required>
                    @error('min_portfolio')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Experience</label>
                    <input type="text" class="form-control" name="experience" placeholder="e.g. 5 years"
                        value="{{ old('experience') }}">
                    @error('experience')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Percentage (%)</label>
                    <input type="text" class="form-control" name="percentage" placeholder="e.g. 95%"
                        value="{{ old('percentage') }}">
                    @error('percentage')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Currency Pairs</label>
                    <input type="text" class="form-control" name="currency_pairs" placeholder="e.g. EUR/USD, BTC/USD"
                        value="{{ old('currency_pairs') }}">
                    @error('currency_pairs')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Details</label>
                    <textarea class="form-control" rows="6" name="details"
                        placeholder="Trader's description">{{ old('details') }}</textarea>
                    @error('details')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Profile Picture*</label>
                    <input type="file" class="form-control" name="picture_url" required>
                    @error('picture_url')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="is_verified" id="is_verified" value="1" {{
                        old('is_verified') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_verified">Verified Trader</label>
                </div>

                <button type="submit" class="btn btn-primary">Create Trader</button>
            </form>
        </div>

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

<script>
    // Display toast notifications
    @if(Session::has('success'))
        toastNotifySuccess("{{ Session::get('success') }}");
    @endif
    
    @if(Session::has('error'))
        toastNotifyError("{{ Session::get('error') }}");
    @endif
    
    @if($errors->any()))
        @foreach($errors->all() as $error))
            toastNotifyError("{{ $error }}");
        @endforeach
    @endif
</script>
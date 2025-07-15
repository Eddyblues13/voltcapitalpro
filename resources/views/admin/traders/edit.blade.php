@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h1>Edit Trader</h1>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any()))
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" enctype="multipart/form-data" class="m-5"
                action="{{ route('traders.update', $trader->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder="Full Name" name="name"
                        value="{{ old('name', $trader->name) }}" required>
                    @error('name'))
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Minimum Portfolio ($)</label>
                    <input type="number" class="form-control" placeholder="Minimum Portfolio" name="min_portfolio"
                        step="0.01" min="0" max="999999999999.99"
                        value="{{ old('min_portfolio', $trader->min_portfolio) }}" required>
                    @error('min_portfolio'))
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Experience</label>
                    <input type="text" class="form-control" placeholder="e.g. 5 years" name="experience"
                        value="{{ old('experience', $trader->experience) }}">
                    @error('experience'))
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Percentage (%)</label>
                    <input type="text" class="form-control" placeholder="e.g. 95%" name="percentage"
                        value="{{ old('percentage', $trader->percentage) }}">
                    @error('percentage'))
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Currency Pairs</label>
                    <input type="text" class="form-control" placeholder="e.g. EUR/USD, BTC/USD" name="currency_pairs"
                        value="{{ old('currency_pairs', $trader->currency_pairs) }}">
                    @error('currency_pairs'))
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Details</label>
                    <textarea class="form-control" name="details"
                        rows="3">{{ old('details', $trader->details) }}</textarea>
                    @error('details'))
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Verified Status</label>
                    <select class="form-control" name="is_verified">
                        <option value="0" {{ !$trader->is_verified ? 'selected' : '' }}>Not Verified</option>
                        <option value="1" {{ $trader->is_verified ? 'selected' : '' }}>Verified</option>
                    </select>
                    @error('is_verified'))
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Profile Picture</label>
                    @if($trader->picture_url))
                    <div class="mb-2">
                        <img src="{{ $trader->picture_url }}" style="width: 100px; height: 100px; object-fit: cover;"
                            class="img-thumbnail">
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" id="remove_picture" name="remove_picture">
                            <label class="form-check-label" for="remove_picture">Remove current picture</label>
                        </div>
                    </div>
                    @endif
                    <input type="file" class="form-control" name="picture_url">
                    @error('picture_url'))
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Trader</button>
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
    
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastNotifyError("{{ $error }}");
        @endforeach
    @endif
</script>
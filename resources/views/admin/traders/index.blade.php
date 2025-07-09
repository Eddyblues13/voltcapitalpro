@include('admin.header')

<!-- End Sidebar -->
<div class="main-panel">
    <div class="content bg-dark">
        <div class="page-inner">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="mt-2 mb-4">
                <h1 class="title1 text-light">Expert Traders</h1>
            </div>
            <div class="mt-2 mb-3 col-lg-12">
                <a class="btn btn-primary" href="{{ route('traders.create') }}">
                    <i class="fa fa-plus"></i> Add A New Trader
                </a>
            </div>
            <div class="mb-5 row">
                @foreach($traders as $trader)
                <div class="col-lg-4">
                    <div class="pricing-table purple border p-4 card bg-dark shadow">
                        <!-- Trader Picture -->
                        <div class="price-tag">
                            <img src="{{ asset($trader->picture_url) }}" class="card-img-top" alt="Trader Image"><br>
                            <center><i>Expert Trader</i></center>
                            <h2 class="text-light">{{ $trader->name }}</h2>
                        </div>

                        <!-- Trader Details -->
                        <div class="pricing-features">
                            <div class="feature text-light">
                                Followers: <span class="text-light">{{ $trader->followers }}</span>
                            </div>
                            <div class="feature text-light">
                                Return Rate: <span class="text-light">{{ $trader->return_rate }}%</span>
                            </div>
                            {{-- <div class="feature text-light">
                                Minimum Amount: <span class="text-light">${{ $trader->min_amount }}</span>
                            </div> --}}
                            {{-- <div class="feature text-light">
                                Maximum Amount: <span class="text-light">${{ $trader->max_amount }}</span>
                            </div> --}}
                            <div class="feature text-light">
                                Profit Share: <span class="text-light">{{ $trader->profit_share }}%</span>
                            </div>
                            <div class="feature text-light">
                                Verified Status: <span class="text-light">
                                    {{ $trader->is_verified ? 'Verified' : 'Not Verified' }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="text-center mt-3">
                            <a href="{{ route('traders.edit', $trader->id) }}" class="btn btn-primary">
                                <i class="text-white flaticon-pencil"></i> Edit
                            </a> &nbsp;

                            <form action="{{ route('traders.destroy', $trader->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="text-white fa fa-times"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@include('admin.footer')
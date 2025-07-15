@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <p>
                <a href="{{ route('traders.create') }}" class="btn btn-outline-primary">
                    <i class="icon-user-follow text-secondary"></i> Add Trader
                </a>
            </p>

            <h2>List of Traders</h2>
            <div class="table-responsive">
                <table id="order-listing" class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Profile Pic</th>
                            <th>Experience</th>
                            <th>Success Rate</th>
                            <th>Min Portfolio</th>
                            <th>Currency Pairs</th>
                            <th>Verified</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($traders as $trader)
                        <tr>
                            <td>{{ $trader->name }}</td>
                            <td>
                                @if($trader->picture_url)
                                <img src="{{ $trader->picture_url }}"
                                    style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                @else
                                <div
                                    style="width: 50px; height: 50px; border-radius: 50%; background-color: #ddd; display: flex; align-items: center; justify-content: center;">
                                    <i class="icon-user"></i>
                                </div>
                                @endif
                            </td>
                            <td>{{ $trader->experience ?? 'N/A' }}</td>
                            <td>{{ $trader->percentage ?? 'N/A' }}</td>
                            <td>${{ number_format($trader->min_portfolio) }}</td>
                            <td>{{ $trader->currency_pairs ?? 'N/A' }}</td>
                            <td>
                                @if($trader->is_verified)
                                <span class="badge badge-success">Verified</span>
                                @else
                                <span class="badge badge-secondary">Not Verified</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('traders.edit', $trader->id) }}" class="btn btn-outline-primary">
                                    <i class="icon-eye"></i> Edit
                                </a>
                                <button onclick="deleteTrader('{{ route('traders.destroy', $trader->id) }}')"
                                    class="btn btn-outline-danger user-delete">
                                    <i class="icon-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- content-wrapper ends -->

        @include('admin.footer')
    </div>
    <!-- main-panel ends -->
</div>

<div class="loaderbody hide" id="loaderbody">
    <div class="loadercircle"></div>
</div>
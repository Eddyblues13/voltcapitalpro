@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h1>Dashboard</h1>
            <h2>Admin</h2>
            <p>
                <a href="{{ url('admin/home') }}" class="btn btn-outline-primary">
                    <i class="icon-user-follow text-secondary"></i>Refresh
                </a>
            </p>

            <h2>List of Customer</h2>
            <div class="table-responsive">
                <table id="order-listing" class="table">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Account Status</th>
                            <th>Verification Status</th>
                            <th>Country</th>
                            <th>Phone Number</th>
                            <th>Registration Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-{{ $user->user_status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($user->user_status) }}
                                </span>
                            </td>
                            <td>
                                @if($user->email_verification)
                                <span class="badge badge-success">Verified</span>
                                @else
                                <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>{{ $user->country }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ url('admin/Details/'.$user->id) }}" class="btn btn-outline-primary">
                                    <i class="icon-eye"></i> View
                                </a>
                                <a onclick="PaidCF('{{ url('Admin/PaidCF/'.$user->id) }}')"
                                    class="btn btn-outline-dark">
                                    <i class="icon-lock"></i> PaidCF
                                </a>
                                <a onclick="Deactivate('{{ url('Admin/DeactivateAccount/'.$user->id) }}')"
                                    class="btn btn-outline-dark">
                                    <i class="icon-lock"></i> De-Activate
                                </a>
                                <a onclick="Verify('{{ route('admin.verify.user', $user->id) }}')"
                                    class="btn btn-outline-success">
                                    <i class="icon-note"></i> Verify
                                </a>
                                <a onclick="MemberVerify('{{ url('Admin/MemberVerify/'.$user->id) }}')"
                                    class="btn btn-outline-success">
                                    Membership Verify
                                </a>
                                <a onclick="Delete('{{ url('Admin/Delete/'.$user->id) }}')"
                                    class="btn btn-outline-danger user-delete">
                                    <i class="icon-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- content-wrapper ends -->

        <footer class="footer">
            <div class="w-100 clearfix">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">
                    Copyright © 2018 <a href="https://wa.me/23409010297878" target="_blank">BenTech</a>. All
                    rights reserved.
                </span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                    special <i class="icon-heart text-danger"></i>
                </span>
            </div>
        </footer>
    </div>
    <!-- main-panel ends -->
</div>
</div>
@include('admin.footer')
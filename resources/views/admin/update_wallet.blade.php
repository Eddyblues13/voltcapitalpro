@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h1>Wallet Options Management</h1>

            <!-- Add New Wallet Option Button -->
            <div class="row mb-3">
                <div class="col-12">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addWalletModal">
                        Add New Wallet Option
                    </button>
                </div>
            </div>

            <!-- Wallet Options Table -->
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Wallet Options List</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Icon</th>
                                            <th>Coin Code</th>
                                            <th>Coin Name</th>
                                            <th>Wallet Name</th>
                                            <th>Wallet Type</th>
                                            <th>Network Type</th>
                                            <th>Wallet Address</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($walletOptions as $option)
                                        <tr>
                                            <td>{{ $option->id }}</td>
                                            <td>
                                                @if($option->icon)
                                                <img src="{{ $option->icon }}" alt="icon"
                                                    style="width: 30px; height: 30px;">
                                                @else
                                                No Icon
                                                @endif
                                            </td>
                                            <td>{{ $option->coin_code }}</td>
                                            <td>{{ $option->coin_name }}</td>
                                            <td>{{ $option->wallet_name }}</td>
                                            <td>{{ $option->wallet_type }}</td>
                                            <td>{{ $option->network_type }}</td>
                                            <td>{{ Str::limit($option->wallet_address, 15) }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info edit-wallet"
                                                    data-id="{{ $option->id }}"
                                                    data-coin_code="{{ $option->coin_code }}"
                                                    data-coin_name="{{ $option->coin_name }}"
                                                    data-wallet_name="{{ $option->wallet_name }}"
                                                    data-wallet_type="{{ $option->wallet_type }}"
                                                    data-icon="{{ $option->icon }}"
                                                    data-wallet_address="{{ $option->wallet_address }}"
                                                    data-network_type="{{ $option->network_type }}">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.wallet_options.destroy', $option->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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

<!-- Add Wallet Option Modal -->
<div class="modal fade" id="addWalletModal" tabindex="-1" role="dialog" aria-labelledby="addWalletModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWalletModalLabel">Add New Wallet Option</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addWalletForm" action="{{ route('admin.wallet_options.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Coin Code</label>
                        <input type="text" class="form-control" name="coin_code" required>
                    </div>
                    <div class="form-group">
                        <label>Coin Name</label>
                        <input type="text" class="form-control" name="coin_name" required>
                    </div>
                    <div class="form-group">
                        <label>Wallet Name</label>
                        <input type="text" class="form-control" name="wallet_name" required>
                    </div>
                    <div class="form-group">
                        <label>Wallet Type</label>
                        <input type="text" class="form-control" name="wallet_type" required>
                    </div>
                    <div class="form-group">
                        <label>Network Type</label>
                        <input type="text" class="form-control" name="network_type" required>
                    </div>
                    <div class="form-group">
                        <label>Wallet Address</label>
                        <input type="text" class="form-control" name="wallet_address" required>
                    </div>
                    <div class="form-group">
                        <label>Icon</label>
                        <input type="file" class="form-control" name="icon">
                        <small class="text-muted">Upload wallet icon image (jpeg, png, jpg, gif, max 2MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Wallet Option Modal -->
<div class="modal fade" id="editWalletModal" tabindex="-1" role="dialog" aria-labelledby="editWalletModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWalletModalLabel">Edit Wallet Option</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editWalletForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Coin Code</label>
                        <input type="text" class="form-control" name="coin_code" id="edit_coin_code" required>
                    </div>
                    <div class="form-group">
                        <label>Coin Name</label>
                        <input type="text" class="form-control" name="coin_name" id="edit_coin_name" required>
                    </div>
                    <div class="form-group">
                        <label>Wallet Name</label>
                        <input type="text" class="form-control" name="wallet_name" id="edit_wallet_name" required>
                    </div>
                    <div class="form-group">
                        <label>Wallet Type</label>
                        <input type="text" class="form-control" name="wallet_type" id="edit_wallet_type" required>
                    </div>
                    <div class="form-group">
                        <label>Network Type</label>
                        <input type="text" class="form-control" name="network_type" id="edit_network_type" required>
                    </div>
                    <div class="form-group">
                        <label>Wallet Address</label>
                        <input type="text" class="form-control" name="wallet_address" id="edit_wallet_address" required>
                    </div>
                    <div class="form-group">
                        <label>Current Icon</label>
                        <div id="current_icon_container" class="mb-2"></div>
                        <input type="file" class="form-control" name="icon">
                        <small class="text-muted">Leave blank to keep current icon</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include all your scripts here -->
<script src="/account/vendors/js/vendor.bundle.base.js"></script>
<script src="/account/vendors/js/vendor.bundle.addons.js"></script>
<script src="/Account/js/dashboard.js"></script>
<script src="/Account/js/template.js"></script>
<script src="/Account/js/data-table.js"></script>
<script src="/account/vendors/tinymce/tinymce.min.js"></script>
<script src="/account/vendors/tinymce/themes/modern/theme.js"></script>
<script src="/account/vendors/summernote/dist/summernote-bs4.min.js"></script>
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
    @if($errors->any()))
        notyf.error('{{ $errors->first() }}');
    @endif

    // Handle edit button click
    $(document).on('click', '.edit-wallet', function() {
        const id = $(this).data('id');
        const coin_code = $(this).data('coin_code');
        const coin_name = $(this).data('coin_name');
        const wallet_name = $(this).data('wallet_name');
        const wallet_type = $(this).data('wallet_type');
        const icon = $(this).data('icon');
        const wallet_address = $(this).data('wallet_address');
        const network_type = $(this).data('network_type');

        $('#edit_id').val(id);
        $('#edit_coin_code').val(coin_code);
        $('#edit_coin_name').val(coin_name);
        $('#edit_wallet_name').val(wallet_name);
        $('#edit_wallet_type').val(wallet_type);
        $('#edit_wallet_address').val(wallet_address);
        $('#edit_network_type').val(network_type);

        // Display current icon if exists
        $('#current_icon_container').html('');
        if (icon) {
            $('#current_icon_container').html(`<img src="${icon}" alt="Current Icon" style="width: 50px; height: 50px;">`);
        }

        // Set form action
        $('#editWalletForm').attr('action', '/admin/wallet_options/' + id);

        // Show modal
        $('#editWalletModal').modal('show');
    });
</script>

</body>

</html>
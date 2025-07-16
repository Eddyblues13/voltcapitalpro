@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h1>Payment Methods Management</h1>

            <!-- Success/Error Messages -->
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

            <!-- Add New Payment Method Button -->
            <div class="row mb-3">
                <div class="col-12">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addPaymentMethodModal">
                        <i class="mdi mdi-plus"></i> Add New Payment Method
                    </button>
                </div>
            </div>

            <!-- Payment Methods Table -->
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Payment Methods List</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Coin Image</th>
                                            <th>Scan Code</th>
                                            <th>Name</th>
                                            <th>Wallet Address</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($paymentMethods as $method)
                                        <tr>
                                            <td>{{ $method->id }}</td>
                                            <td>
                                                @if($method->coin_pic_path)
                                                <img src="{{ $method->coin_pic_path }}" alt="Coin Image"
                                                    class="img-thumbnail"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                <span class="badge badge-warning">No Image</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($method->scan_code_path)
                                                <img src="{{ $method->scan_code_path }}" alt="Scan Code"
                                                    class="img-thumbnail"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                <span class="badge badge-warning">No Scan Code</span>
                                                @endif
                                            </td>
                                            <td>{{ $method->name }}</td>
                                            <td>
                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                                    {{ $method->wallet_address }}
                                                </span>
                                            </td>
                                            <td>{{ $method->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info edit-payment-method"
                                                    data-id="{{ $method->id }}" data-name="{{ $method->name }}"
                                                    data-wallet_address="{{ $method->wallet_address }}"
                                                    data-coin_pic_path="{{ $method->coin_pic_path }}"
                                                    data-scan_code_path="{{ $method->scan_code_path }}">
                                                    <i class="mdi mdi-pencil"></i> Edit
                                                </button>
                                                <form action="{{ route('admin.wallet_options.destroy', $method->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this payment method?')">
                                                        <i class="mdi mdi-delete"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No payment methods found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            @if($paymentMethods->hasPages())
                            <div class="mt-4">
                                {{ $paymentMethods->links() }}
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
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018 <a
                        href="https://wa.me/23409010297878" target="_blank">BenTech</a>. All rights reserved.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">special <i
                        class="icon-heart text-danger"></i></span>
            </div>
        </footer>
    </div>
</div>

<!-- Add Payment Method Modal -->
<div class="modal fade" id="addPaymentMethodModal" tabindex="-1" role="dialog"
    aria-labelledby="addPaymentMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentMethodModalLabel">Add New Payment Method</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPaymentMethodForm" action="{{ route('admin.wallet_options.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Wallet Address *</label>
                                <input type="text" class="form-control" name="wallet_address" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Coin Image *</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="coin_pic" id="coinPic" required
                                        accept="image/*">
                                    <label class="custom-file-label" for="coinPic">Choose file</label>
                                </div>
                                <small class="text-muted">JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                                <div class="mt-2" id="coinPicPreview"></div>
                            </div>
                            <div class="form-group">
                                <label>Scan Code *</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="scan_code" id="scanCode" required
                                        accept="image/*">
                                    <label class="custom-file-label" for="scanCode">Choose file</label>
                                </div>
                                <small class="text-muted">JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                                <div class="mt-2" id="scanCodePreview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Payment Method</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Payment Method Modal -->
<div class="modal fade" id="editPaymentMethodModal" tabindex="-1" role="dialog"
    aria-labelledby="editPaymentMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPaymentMethodModalLabel">Edit Payment Method</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPaymentMethodForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name *</label>
                                <input type="text" class="form-control" name="name" id="edit_name" required>
                            </div>
                            <div class="form-group">
                                <label>Wallet Address *</label>
                                <input type="text" class="form-control" name="wallet_address" id="edit_wallet_address"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Coin Image</label>
                                <div class="current-image mb-2">
                                    <strong>Current Image:</strong>
                                    <div id="current_coin_pic_container"></div>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" name="remove_coin_pic"
                                            id="remove_coin_pic">
                                        <label class="form-check-label" for="remove_coin_pic">Remove current
                                            image</label>
                                    </div>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="coin_pic" id="edit_coin_pic"
                                        accept="image/*">
                                    <label class="custom-file-label" for="edit_coin_pic">Choose new file</label>
                                </div>
                                <small class="text-muted">Leave blank to keep current image</small>
                                <div class="mt-2" id="editCoinPicPreview"></div>
                            </div>
                            <div class="form-group">
                                <label>Scan Code</label>
                                <div class="current-image mb-2">
                                    <strong>Current Scan Code:</strong>
                                    <div id="current_scan_code_container"></div>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" name="remove_scan_code"
                                            id="remove_scan_code">
                                        <label class="form-check-label" for="remove_scan_code">Remove current scan
                                            code</label>
                                    </div>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="scan_code" id="edit_scan_code"
                                        accept="image/*">
                                    <label class="custom-file-label" for="edit_scan_code">Choose new file</label>
                                </div>
                                <small class="text-muted">Leave blank to keep current scan code</small>
                                <div class="mt-2" id="editScanCodePreview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Payment Method</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript Libraries -->
<script src="/account/vendors/js/vendor.bundle.base.js"></script>
<script src="/account/vendors/js/vendor.bundle.addons.js"></script>
<script src="/account/js/dashboard.js"></script>
<script src="/account/js/template.js"></script>
<script src="/account/js/data-table.js"></script>
<script src="/asset2/js/sweetalert.js"></script>

<!-- Custom JavaScript -->
<script>
    $(document).ready(function() {
        // File input label update
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Image preview for add modal
        $('#coinPic').change(function() {
            previewImage(this, '#coinPicPreview');
        });
        
        $('#scanCode').change(function() {
            previewImage(this, '#scanCodePreview');
        });

        // Image preview for edit modal
        $('#edit_coin_pic').change(function() {
            previewImage(this, '#editCoinPicPreview');
        });
        
        $('#edit_scan_code').change(function() {
            previewImage(this, '#editScanCodePreview');
        });

        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $(previewId).html(`<img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">`);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Handle edit button click
        $(document).on('click', '.edit-payment-method', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const wallet_address = $(this).data('wallet_address');
            const coin_pic_path = $(this).data('coin_pic_path');
            const scan_code_path = $(this).data('scan_code_path');

            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_wallet_address').val(wallet_address);

            // Display current images if they exist
            $('#current_coin_pic_container').html(coin_pic_path ? 
                `<img src="${coin_pic_path}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">` : 
                '<span class="badge badge-warning">No image</span>');

            $('#current_scan_code_container').html(scan_code_path ? 
                `<img src="${scan_code_path}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">` : 
                '<span class="badge badge-warning">No scan code</span>');

            // Reset file inputs and previews
            $('#edit_coin_pic').val('');
            $('#edit_scan_code').val('');
            $('.custom-file-label').html('Choose file');
            $('#editCoinPicPreview').html('');
            $('#editScanCodePreview').html('');
            $('#remove_coin_pic, #remove_scan_code').prop('checked', false);

            // Set form action
            $('#editPaymentMethodForm').attr('action', '/admin/wallet_options/' + id);
 
            // Show modal
            $('#editPaymentMethodModal').modal('show');
        });

        // Toast Notification
        const notyf = new Notyf({
            duration: 5000,
            position: { x: 'right', y: 'top' },
            dismissible: true,
            ripple: true,
            types: [
                { type: 'success', background: '#28a745' },
                { type: 'error', background: '#dc3545' },
                { type: 'warning', background: 'orange', className: 'text-dark', icon: { className: 'fa fa-warning text-dark', tagName: 'i' } },
                { type: 'info', background: '#17a2b8', icon: { className: 'fa fa-info text-white', tagName: 'i' } }
            ]
        });

        @if(session('success'))
            notyf.success('{{ session('success') }}');
        @endif

        @if($errors->any())
            notyf.error('{{ $errors->first() }}');
        @endif
    });
</script>

</body>

</html>
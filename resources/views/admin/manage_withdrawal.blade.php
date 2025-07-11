@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h1>Withdrawals Management</h1>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Withdrawals List</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Account Type</th>
                                            <th>Crypto Currency</th>
                                            <th>Amount</th>
                                            <th>Wallet Address</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($withdrawals as $withdrawal)
                                        <tr>
                                            <td>{{ $withdrawal->id }}</td>
                                            <td>{{ $withdrawal->user->name }} (ID: {{ $withdrawal->user_id }})</td>
                                            <td>{{ $withdrawal->account_type }}</td>
                                            <td>{{ $withdrawal->crypto_currency ?? 'N/A' }}</td>
                                            <td>{{ number_format($withdrawal->amount, 8) }}</td>
                                            <td>{{ $withdrawal->wallet_address ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge badge-{{ 
                                                    $withdrawal->status == 'approved' ? 'success' : 
                                                    ($withdrawal->status == 'rejected' ? 'danger' : 'warning') 
                                                }}">
                                                    {{ ucfirst($withdrawal->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $withdrawal->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info edit-withdrawal"
                                                    data-id="{{ $withdrawal->id }}"
                                                    data-user_id="{{ $withdrawal->user_id }}"
                                                    data-account_type="{{ $withdrawal->account_type }}"
                                                    data-crypto_currency="{{ $withdrawal->crypto_currency }}"
                                                    data-amount="{{ $withdrawal->amount }}"
                                                    data-wallet_address="{{ $withdrawal->wallet_address }}"
                                                    data-status="{{ $withdrawal->status }}">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.withdrawals.destroy', $withdrawal->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger delete-withdrawal">
                                                        Delete
                                                    </button>
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

        <!-- Edit Withdrawal Modal -->
        <div class="modal fade" id="editWithdrawalModal" tabindex="-1" role="dialog"
            aria-labelledby="editWithdrawalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editWithdrawalModalLabel">Edit Withdrawal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editWithdrawalForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>User ID</label>
                                        <input type="text" class="form-control" id="edit_user_id" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Account Type</label>
                                        <select class="form-control" name="account_type" id="edit_account_type"
                                            required>
                                            <option value="Bank">Bank</option>
                                            <option value="Crypto">Crypto</option>
                                        </select>
                                    </div>
                                    <div class="form-group crypto-field">
                                        <label>Crypto Currency</label>
                                        <input type="text" class="form-control" name="crypto_currency"
                                            id="edit_crypto_currency">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" step="0.00000001" class="form-control" name="amount"
                                            id="edit_amount" required>
                                    </div>
                                    <div class="form-group crypto-field">
                                        <label>Wallet Address</label>
                                        <input type="text" class="form-control" name="wallet_address"
                                            id="edit_wallet_address">
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status" id="edit_status" required>
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>
                                </div>
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

        @include('admin.footer')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Toggle crypto fields based on account type
        function toggleCryptoFields(accountType) {
            if (accountType === 'Crypto') {
                $('.crypto-field').show();
                $('#edit_crypto_currency, #edit_wallet_address').prop('required', true);
            } else {
                $('.crypto-field').hide();
                $('#edit_crypto_currency, #edit_wallet_address').prop('required', false);
            }
        }

        // Handle edit button click
        $('.edit-withdrawal').on('click', function() {
            const withdrawal = $(this).data();
            
            $('#edit_id').val(withdrawal.id);
            $('#edit_user_id').val(withdrawal.user_id);
            $('#edit_account_type').val(withdrawal.account_type);
            $('#edit_crypto_currency').val(withdrawal.crypto_currency);
            $('#edit_amount').val(withdrawal.amount);
            $('#edit_wallet_address').val(withdrawal.wallet_address);
            $('#edit_status').val(withdrawal.status);

            toggleCryptoFields(withdrawal.account_type);
            
            $('#editWithdrawalForm').attr('action', '/admin/withdrawals/' + withdrawal.id);
            $('#editWithdrawalModal').modal('show');
        });

        // Handle account type change
        $('#edit_account_type').on('change', function() {
            toggleCryptoFields($(this).val());
        });

        // Handle form submission
        $('#editWithdrawalForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            
            $.ajax({
                url: form.attr('action'),
                type: 'PUT',
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {
                    form.closest('.modal').modal('hide');
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Withdrawal updated successfully',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.message || 'An error occurred';
                    
                    if (xhr.responseJSON?.errors) {
                        errorMessage = '';
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMessage
                    });
                }
            });
        });

        // Handle delete button clicks
        $('.delete-withdrawal').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: form.find('input[name="_token"]').val()
                        },
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.message || 'Withdrawal has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON?.message || 'Failed to delete withdrawal.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
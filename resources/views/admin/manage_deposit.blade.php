@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h1>Deposits Management</h1>

            <!-- Success/Error Message Display -->
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

            <!-- Deposits Table -->
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Deposits List</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Amount</th>
                                            <th>Account Type</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($deposits as $deposit)
                                        <tr>
                                            <td>{{ $deposit->id }}</td>
                                            <td>{{ $deposit->user->name }} (ID: {{ $deposit->user_id }})</td>
                                            <td>${{ number_format($deposit->amount, 2) }}</td>
                                            <td>{{ $deposit->account_type }}</td>
                                            <td>
                                                <span class="badge badge-{{ 
                                                    $deposit->status == 'approved' ? 'success' : 
                                                    ($deposit->status == 'rejected' ? 'danger' : 'warning') 
                                                }}">
                                                    {{ ucfirst($deposit->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $deposit->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info edit-deposit"
                                                    data-id="{{ $deposit->id }}" data-user_id="{{ $deposit->user_id }}"
                                                    data-amount="{{ $deposit->amount }}"
                                                    data-account_type="{{ $deposit->account_type }}"
                                                    data-status="{{ $deposit->status }}">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.deposits.destroy', $deposit->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger delete-deposit">
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

        <!-- Edit Deposit Modal -->
        <div class="modal fade" id="editDepositModal" tabindex="-1" role="dialog"
            aria-labelledby="editDepositModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDepositModalLabel">Edit Deposit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editDepositForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="form-group">
                                <label>User ID</label>
                                <input type="text" class="form-control" id="edit_user_id" readonly>
                            </div>
                            <div class="form-group">
                                <label>Amount ($)</label>
                                <input type="number" step="0.01" class="form-control" name="amount" id="edit_amount"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Account Type</label>
                                <input type="text" class="form-control" name="account_type" id="edit_account_type"
                                    required>
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
        // Handle edit button click
        $('.edit-deposit').on('click', function() {
            const id = $(this).data('id');
            const user_id = $(this).data('user_id');
            const amount = $(this).data('amount');
            const account_type = $(this).data('account_type');
            const status = $(this).data('status');

            $('#edit_id').val(id);
            $('#edit_user_id').val(user_id);
            $('#edit_amount').val(amount);
            $('#edit_account_type').val(account_type);
            $('#edit_status').val(status);

            $('#editDepositForm').attr('action', '/admin/deposits/' + id);
            $('#editDepositModal').modal('show');
        });

        // Handle form submission
        $('#editDepositForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const url = form.attr('action');
            const method = form.attr('method') || 'POST';
            const formData = form.serialize();

            $.ajax({
                url: url,
                type: method,
                data: formData,
                dataType: 'json',
                success: function(response) {
                    form.closest('.modal').modal('hide');
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Deposit updated successfully',
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
        $('.delete-deposit').on('click', function(e) {
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
                                response.message || 'Deposit has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON?.message || 'Failed to delete deposit.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h1>Trading Histories Management</h1>

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
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Trader</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($histories as $history)
                                        <tr>
                                            <td>{{ $history->id }}</td>
                                            <td>{{ $history->user->name }} (ID: {{ $history->user_id }})</td>
                                            <td>{{ $history->trader->name }} (ID: {{ $history->trader_id }})</td>
                                            <td>${{ number_format($history->amount, 2) }}</td>
                                            <td>
                                                <span class="badge badge-{{ 
                                                    $history->status == 'completed' ? 'success' : 
                                                    ($history->status == 'failed' ? 'danger' : 'warning') 
                                                }}">
                                                    {{ ucfirst($history->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $history->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info edit-history"
                                                    data-id="{{ $history->id }}" data-user_id="{{ $history->user_id }}"
                                                    data-trader_id="{{ $history->trader_id }}"
                                                    data-amount="{{ $history->amount }}"
                                                    data-status="{{ $history->status }}">
                                                    Edit
                                                </button>
                                                <form
                                                    action="{{ route('admin.trading-histories.destroy', $history->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger delete-history">
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

        <!-- Edit History Modal -->
        <div class="modal fade" id="editHistoryModal" tabindex="-1" role="dialog"
            aria-labelledby="editHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editHistoryModalLabel">Edit Trading History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editHistoryForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="form-group">
                                <label>User</label>
                                <input type="text" class="form-control" id="edit_user" readonly>
                            </div>
                            <div class="form-group">
                                <label>Trader</label>
                                <input type="text" class="form-control" id="edit_trader" readonly>
                            </div>
                            <div class="form-group">
                                <label>Amount ($)</label>
                                <input type="number" step="0.01" class="form-control" name="amount" id="edit_amount"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status" id="edit_status" required>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="failed">Failed</option>
                                    <option value="cancelled">Cancelled</option>
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
        $('.edit-history').on('click', function() {
            const history = $(this).data();
            
            $('#edit_id').val(history.id);
            $('#edit_user').val(history.user_id + ' - ' + $(this).closest('tr').find('td:nth-child(2)').text());
            $('#edit_trader').val(history.trader_id + ' - ' + $(this).closest('tr').find('td:nth-child(3)').text());
            $('#edit_amount').val(history.amount);
            $('#edit_status').val(history.status);
            
            $('#editHistoryForm').attr('action', '/admin/trading-histories/' + history.id);
            $('#editHistoryModal').modal('show');
        });

        // Handle form submission
        $('#editHistoryForm').on('submit', function(e) {
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
                        text: response.message || 'Trading history updated successfully',
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
        $('.delete-history').on('click', function(e) {
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
                                response.message || 'Trading history has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON?.message || 'Failed to delete trading history.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
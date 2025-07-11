@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h1>Investment Plans Management</h1>

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

            <!-- Add New Plan Button -->
            <div class="row mb-3">
                <div class="col-12">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addPlanModal">
                        Add New Plan
                    </button>
                </div>
            </div>

            <!-- Plans Table -->
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Plans List</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Swap Fee</th>
                                            <th>Pairs</th>
                                            <th>Leverage</th>
                                            <th>Spread</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($plans as $plan)
                                        <tr>
                                            <td>{{ $plan->id }}</td>
                                            <td>{{ $plan->name }}</td>
                                            <td>${{ number_format($plan->price, 2) }}</td>
                                            <td>{{ $plan->swap_fee ? 'Yes' : 'No' }}</td>
                                            <td>{{ $plan->pairs }}</td>
                                            <td>{{ $plan->leverage ?? 'N/A' }}</td>
                                            <td>{{ $plan->spread ?? 'N/A' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info edit-plan" data-id="{{ $plan->id }}"
                                                    data-name="{{ $plan->name }}" data-price="{{ $plan->price }}"
                                                    data-swap_fee="{{ $plan->swap_fee ? '1' : '0' }}"
                                                    data-pairs="{{ $plan->pairs }}"
                                                    data-leverage="{{ $plan->leverage }}"
                                                    data-spread="{{ $plan->spread }}">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.plans.destroy', $plan->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger delete-plan">
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

        <!-- Add Plan Modal -->
        <div class="modal fade" id="addPlanModal" tabindex="-1" role="dialog" aria-labelledby="addPlanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPlanModalLabel">Add New Plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addPlanForm" action="{{ route('admin.plans.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Plan Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Price ($)</label>
                                <input type="number" step="0.01" class="form-control" name="price" required>
                            </div>
                            <div class="form-group">
                                <label>Swap Fee</label>
                                <select class="form-control" name="swap_fee" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Number of Pairs</label>
                                <input type="number" class="form-control" name="pairs" value="76" required>
                            </div>
                            <div class="form-group">
                                <label>Leverage (e.g., 1:500)</label>
                                <input type="text" class="form-control" name="leverage" placeholder="1:500">
                            </div>
                            <div class="form-group">
                                <label>Spread (e.g., 0.8 pips)</label>
                                <input type="text" class="form-control" name="spread" placeholder="0.8 pips">
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

        <!-- Edit Plan Modal -->
        <div class="modal fade" id="editPlanModal" tabindex="-1" role="dialog" aria-labelledby="editPlanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPlanModalLabel">Edit Plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editPlanForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="form-group">
                                <label>Plan Name</label>
                                <input type="text" class="form-control" name="name" id="edit_name" required>
                            </div>
                            <div class="form-group">
                                <label>Price ($)</label>
                                <input type="number" step="0.01" class="form-control" name="price" id="edit_price"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Swap Fee</label>
                                <select class="form-control" name="swap_fee" id="edit_swap_fee" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Number of Pairs</label>
                                <input type="number" class="form-control" name="pairs" id="edit_pairs" required>
                            </div>
                            <div class="form-group">
                                <label>Leverage (e.g., 1:500)</label>
                                <input type="text" class="form-control" name="leverage" id="edit_leverage">
                            </div>
                            <div class="form-group">
                                <label>Spread (e.g., 0.8 pips)</label>
                                <input type="text" class="form-control" name="spread" id="edit_spread">
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
        $('.edit-plan').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const price = $(this).data('price');
            const swap_fee = $(this).data('swap_fee');
            const pairs = $(this).data('pairs');
            const leverage = $(this).data('leverage');
            const spread = $(this).data('spread');

            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_price').val(price);
            $('#edit_swap_fee').val(swap_fee);
            $('#edit_pairs').val(pairs);
            $('#edit_leverage').val(leverage);
            $('#edit_spread').val(spread);

            $('#editPlanForm').attr('action', '/admin/plans/' + id);
            $('#editPlanModal').modal('show');
        });

        // Handle form submissions
        $('#addPlanForm, #editPlanForm').on('submit', function(e) {
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
                        text: response.message || 'Operation completed successfully',
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
        $('.delete-plan').on('click', function(e) {
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
                                response.message || 'Plan has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON?.message || 'Failed to delete plan.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
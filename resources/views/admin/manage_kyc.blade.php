@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <h1>Identity Verifications</h1>

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
                                            <th>Front Photo</th>
                                            <th>Back Photo</th>
                                            <th>Status</th>
                                            <th>Submitted At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($verifications as $verification)
                                        <tr>
                                            <td>{{ $verification->id }}</td>
                                            <td>{{ $verification->user->name }} (ID: {{ $verification->user_id }})</td>
                                            <td>
                                                @if($verification->front_photo_url)
                                                <a href="{{ $verification->front_photo_url }}" target="_blank"
                                                    class="btn btn-sm btn-primary">
                                                    View Front
                                                </a>
                                                @else
                                                N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if($verification->back_photo_url)
                                                <a href="{{ $verification->back_photo_url }}" target="_blank"
                                                    class="btn btn-sm btn-primary">
                                                    View Back
                                                </a>
                                                @else
                                                N/A
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ 
                                                    $verification->status == 'approved' ? 'success' : 
                                                    ($verification->status == 'rejected' ? 'danger' : 'warning') 
                                                }}">
                                                    {{ ucfirst($verification->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $verification->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info edit-verification"
                                                    data-id="{{ $verification->id }}"
                                                    data-front_photo_url="{{ $verification->front_photo_url }}"
                                                    data-back_photo_url="{{ $verification->back_photo_url }}"
                                                    data-status="{{ $verification->status }}">
                                                    Review
                                                </button>
                                                <form
                                                    action="{{ route('admin.identity-verifications.destroy', $verification->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger delete-verification">
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

        <!-- Review Verification Modal -->
        <div class="modal fade" id="reviewVerificationModal" tabindex="-1" role="dialog"
            aria-labelledby="reviewVerificationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewVerificationModalLabel">Review Identity Verification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="reviewVerificationForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="review_id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Front Photo</label>
                                        <div class="text-center mb-3">
                                            <img id="frontPhotoPreview" src="" class="img-fluid rounded"
                                                style="max-height: 300px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Back Photo</label>
                                        <div class="text-center mb-3">
                                            <img id="backPhotoPreview" src="" class="img-fluid rounded"
                                                style="max-height: 300px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status" id="review_status" required>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="form-group" id="rejectionReasonGroup" style="display: none;">
                                <label>Rejection Reason</label>
                                <textarea class="form-control" name="rejection_reason" id="rejection_reason" rows="3"
                                    placeholder="Please specify reason for rejection..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Status</button>
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
        // Handle review button click
        $('.edit-verification').on('click', function() {
            const verification = $(this).data();
            
            $('#review_id').val(verification.id);
            $('#frontPhotoPreview').attr('src', verification.front_photo_url || '');
            $('#backPhotoPreview').attr('src', verification.back_photo_url || '');
            $('#review_status').val(verification.status);
            
            $('#reviewVerificationForm').attr('action', '/admin/identity-verifications/' + verification.id);
            $('#reviewVerificationModal').modal('show');
        });

        // Show/hide rejection reason based on status
        $('#review_status').on('change', function() {
            if ($(this).val() === 'rejected') {
                $('#rejectionReasonGroup').show();
                $('#rejection_reason').prop('required', true);
            } else {
                $('#rejectionReasonGroup').hide();
                $('#rejection_reason').prop('required', false);
            }
        });

        // Handle form submission
        $('#reviewVerificationForm').on('submit', function(e) {
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
                        text: response.message || 'Verification status updated',
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
        $('.delete-verification').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the verification record!",
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
                                response.message || 'Verification has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON?.message || 'Failed to delete verification.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
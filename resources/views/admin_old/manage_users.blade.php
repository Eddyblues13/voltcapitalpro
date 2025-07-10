@include('admin.header')
<div class="main-panel">
	<div class="content bg-dark">
		<div class="page-inner">
			@if(session('message'))
			<div class="alert alert-success mb-2">{{session('message')}}</div>
			@endif
			<div class="mt-2 mb-4">
				<h1 class="title1 text-light">List of Customer</h1>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="d-flex justify-content-between mb-3">
						<div>
							<a href="#" data-toggle="modal" data-target="#sendmailModal" class="btn btn-primary btn-sm">
								Send Mail
							</a>
							<a href="{{route('add.user')}}" data-toggle="modal" data-target="#adduser"
								class="btn btn-primary btn-sm">
								<i class='fas fa-plus-circle'></i> Add User
							</a>
						</div>
						<div class="form-inline">
							<label class="text-light mr-2">Show</label>
							<select class="form-control form-control-sm bg-dark text-light" id="numofrecord">
								<option value="10" selected>10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
							<label class="text-light ml-2">entries</label>
						</div>
					</div>

					<!-- Add User Modal (unchanged) -->
					<div class="modal fade" id="adduser" tabindex="-1" aria-h6ledby="exampleModalh6" aria-hidden="true">
						<!-- Modal content remains the same -->
					</div>
				</div>
			</div>

			<div class="mb-5 row">
				<div class="col-md-12 shadow card p-4 bg-dark">
					<div class="table-responsive">
						<table class="table table-hover text-light" id="userTable">
							<thead>
								<tr>
									<th>Full Name</th>
									<th>UserName</th>
									<th>Account Level</th>
									<th>Email</th>
									<th>Country</th>
									<th>PasswordInfo</th>
									<th>PhoneNumb</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody id="userslisttbl">
								@foreach($users as $user)
								<tr>
									<td>{{ $user->first_name }} {{ $user->last_name }}</td>
									<td>{{ $user->username ?? 'N/A' }}</td>
									<td>
										<span class="badge badge-primary">Basic</span>
									</td>
									<td>{{ strtolower($user->email) }}</td>
									<td>{{ $user->country ?? '' }}</td>
									<td>{{ $user->plain ?? 'N/A' }}</td>
									<td>{{ $user->phone_number ?? 'N/A' }}</td>
									<td>
										<div class="btn-group btn-group-sm" role="group">
											<a href="{{ route('admin.user.view', $user->id) }}"
												class="btn btn-secondary">View</a>
											<button type="button" class="btn btn-secondary">PaldCF</button>
											<button type="button" class="btn btn-secondary">De-Activate</button>
											<button type="button" class="btn btn-secondary">Verify</button>
											<button type="button" class="btn btn-secondary">Membership Verify</button>
											<button type="button" class="btn btn-secondary">Delete</button>
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<!-- Pagination Controls -->
					<div class="d-flex justify-content-between mt-3">
						<div class="text-light">
							Showing 1 to {{ min(10, count($users)) }} of {{ count($users) }} entries
						</div>
						<div>
							<nav>
								<ul class="pagination pagination-sm">
									<li class="page-item">
										<a class="page-link bg-dark text-light" href="#">Previous</a>
									</li>
									<li class="page-item active"><a class="page-link" href="#">1</a></li>
									<li class="page-item"><a class="page-link bg-dark text-light" href="#">2</a></li>
									<li class="page-item"><a class="page-link bg-dark text-light" href="#">3</a></li>
									<li class="page-item"><a class="page-link bg-dark text-light" href="#">4</a></li>
									<li class="page-item"><a class="page-link bg-dark text-light" href="#">5</a></li>
									<li class="page-item">
										<a class="page-link bg-dark text-light" href="#">28</a>
									</li>
									<li class="page-item">
										<a class="page-link bg-dark text-light" href="#">Next</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('#input1').on('keypress', function(e) {
        return e.which !== 32;
    });
</script>

<!-- send all users email modal (unchanged) -->
<div id="sendmailModal" class="modal fade" role="dialog">
	<!-- Modal content remains the same -->
</div>

@include('admin.footer')
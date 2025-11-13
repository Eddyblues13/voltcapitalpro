@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">

            <h2>Client Details</h2>

            <div>
                <div class="row">
                    <div class="col-lg-6">
                        <dl class="dl-horizontal">
                            <dt>
                                Full Name : {{ $user->first_name }} {{ $user->last_name }}
                            </dt>

                            <dt>
                                UserName : {{ $user->username ?? 'N/A' }}
                            </dt>

                            <dt>
                                Account Level : {{ $user->account_level ?? 'Basic' }}
                            </dt>

                            <dt>
                                Profit :{{ config('currencies.' . $user->currency, '$') }}{{ number_format($profit, 2)
                                }}
                            </dt>

                            <dt>
                                Account Balance : {{ config('currencies.' . $user->currency, '$') }}{{
                                number_format($accountBalance, 2) }}
                            </dt>

                            <dt>
                                Email : {{ $user->email }}
                            </dt>

                            <dt>
                                EmailConfirmed:
                                <input class="check-box" disabled="disabled" type="checkbox"
                                    @checked($user->email_verification) />
                            </dt>

                            <dt>
                                PhoneNumber : {{ $user->phone_number ?? 'N/A' }}
                            </dt>

                            <dt>
                                Account Verified :
                                <input class="check-box" disabled="disabled" type="checkbox"
                                    @checked($user->id_verification && $user->address_verification) />
                            </dt>
                            <dt>
                                Withdrawal Code : {{ $user->verification_code ?? 'N/A' }}
                            </dt>
                        </dl>
                    </div>
                </div>
            </div>
            <p>
                <a href="/Admin/Dashboard">Back to List</a>|
                <a href="{{ route('admin.deposit', $user->id) }}" class="btn btn-outline-primary"><i
                        class="fa fa-level-down "></i>Deposite</a>|
                <a href="{{ route('admin.profit', $user->id) }}" class="btn btn-outline-primary"><i
                        class="fa fa-level-up "></i>Upgrade</a>|
                <a href="{{ route('admin.profit', $user->id) }}" class="btn btn-outline-primary"><i
                        class="fa fa-bar-chart-o "></i>Trade</a>|

                <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-outline-primary"><i
                        class="fa fa-pencil "></i>Edit</a>|
                <a href="{{ route('admin.edit-bill', $user->id) }}" class="btn btn-outline-primary"><i
                        class="fa fa-pencil "></i>Edit Bill</a>|

                <!-- Toggle Buttons -->
                <button
                    onclick="toggleStatus('{{ route('admin.topup', $user->id) }}', 'topup', {{ $user->top_up_status ? 'true' : 'false' }})"
                    class="btn btn-outline-primary" id="topup-btn">
                    <i class="fa fa-money"></i>
                    <span id="topup-text">{{ $user->top_up_status ? 'Disable Top-Up' : 'Enable Top-Up' }}</span>
                </button>|

                <button
                    onclick="toggleStatus('{{ route('admin.paid-register-fee', $user->id) }}', 'register-fee', {{ $user->confirmed_registration_fee ? 'true' : 'false' }})"
                    class="btn btn-outline-primary" id="register-fee-btn">
                    <i class="fa fa-money"></i>
                    <span id="register-fee-text">{{ $user->confirmed_registration_fee ? 'Unconfirm Registration Fee' :
                        'Confirm Registration Fee' }}</span>
                </button>|

                <button
                    onclick="toggleStatus('{{ route('admin.on-notify', $user->id) }}', 'notify', {{ $user->notification_status ? 'true' : 'false' }})"
                    class="btn btn-outline-primary" id="notify-btn">
                    <i class="fa fa-bell"></i>
                    <span id="notify-text">{{ $user->notification_status ? 'Disable Notifications' : 'Enable
                        Notifications' }}</span>
                </button>|

                <button
                    onclick="toggleStatus('{{ route('admin.on-topup', $user->id) }}', 'on-topup', {{ $user->top_up_status ? 'true' : 'false' }})"
                    class="btn btn-outline-primary" id="on-topup-btn">
                    <i class="fa fa-money"></i>
                    <span id="on-topup-text">{{ $user->top_up_status ? 'Disable On Top-Up' : 'Enable On Top-Up'
                        }}</span>
                </button>|

                <button
                    onclick="toggleStatus('{{ route('admin.on-sub', $user->id) }}', 'sub', {{ $user->subscription_status ? 'true' : 'false' }})"
                    class="btn btn-outline-primary" id="sub-btn">
                    <i class="fa fa-refresh"></i>
                    <span id="sub-text">{{ $user->subscription_status ? 'Disable Subscription' : 'Enable Subscription'
                        }}</span>
                </button>|

                <button
                    onclick="toggleStatus('{{ route('admin.on-network', $user->id) }}', 'network', {{ $user->network_status ? 'true' : 'false' }})"
                    class="btn btn-outline-primary" id="network-btn">
                    <i class="fa fa-share-alt"></i>
                    <span id="network-text">{{ $user->network_status ? 'Disable Network' : 'Enable Network' }}</span>
                </button>|

                <!-- Action Buttons -->
                <button onclick="sendVerificationEmail('{{ route('admin.send-verification', $user->id) }}')"
                    class="btn btn-outline-info"><i class="fa fa-envelope"></i> Resend Verification</button>|
                <button onclick="resetPassword('{{ route('admin.reset-password', $user->id) }}')"
                    class="btn btn-outline-warning"><i class="fa fa-key"></i> Reset Password</button>
            </p>

            <script>
                function toggleStatus(url, type, currentStatus) {
                    let actionText = '';
                    let confirmMessage = '';
                    
                    // Set confirmation messages based on type
                    switch(type) {
                        case 'topup':
                        case 'on-topup':
                            actionText = currentStatus ? 'disable' : 'enable';
                            confirmMessage = `Are you sure you want to ${actionText} Top-up for this user?`;
                            break;
                        case 'register-fee':
                            actionText = currentStatus ? 'unconfirm' : 'confirm';
                            confirmMessage = `Are you sure you want to ${actionText} registration fee for this user?`;
                            break;
                        case 'notify':
                            actionText = currentStatus ? 'disable' : 'enable';
                            confirmMessage = `Are you sure you want to ${actionText} notifications for this user?`;
                            break;
                        case 'sub':
                            actionText = currentStatus ? 'disable' : 'enable';
                            confirmMessage = `Are you sure you want to ${actionText} subscription for this user?`;
                            break;
                        case 'network':
                            actionText = currentStatus ? 'disable' : 'enable';
                            confirmMessage = `Are you sure you want to ${actionText} network for this user?`;
                            break;
                    }

                    if (confirm(confirmMessage)) {
                        $("#loaderbody").removeClass('hide');
                        $.ajax({
                            type: 'POST',
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                $("#loaderbody").addClass('hide');
                                
                                // Update button text based on new status
                                const newStatus = response.new_status;
                                updateButtonText(type, newStatus);
                                
                                alert(response.message);
                            },
                            error: function(xhr) {
                                $("#loaderbody").addClass('hide');
                                alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                            }
                        });
                    }
                }

                function updateButtonText(type, newStatus) {
                    const button = document.getElementById(`${type}-btn`);
                    const textElement = document.getElementById(`${type}-text`);
                    
                    if (!button || !textElement) return;
                    
                    switch(type) {
                        case 'topup':
                        case 'on-topup':
                            textElement.textContent = newStatus ? 'Disable Top-Up' : 'Enable Top-Up';
                            button.className = newStatus ? 'btn btn-outline-success' : 'btn btn-outline-primary';
                            break;
                        case 'register-fee':
                            textElement.textContent = newStatus ? 'Unconfirm Registration Fee' : 'Confirm Registration Fee';
                            button.className = newStatus ? 'btn btn-outline-success' : 'btn btn-outline-primary';
                            break;
                        case 'notify':
                            textElement.textContent = newStatus ? 'Disable Notifications' : 'Enable Notifications';
                            button.className = newStatus ? 'btn btn-outline-success' : 'btn btn-outline-primary';
                            break;
                        case 'sub':
                            textElement.textContent = newStatus ? 'Disable Subscription' : 'Enable Subscription';
                            button.className = newStatus ? 'btn btn-outline-success' : 'btn btn-outline-primary';
                            break;
                        case 'network':
                            textElement.textContent = newStatus ? 'Disable Network' : 'Enable Network';
                            button.className = newStatus ? 'btn btn-outline-success' : 'btn btn-outline-primary';
                            break;
                    }
                }

                function sendVerificationEmail(url) {
                    if (confirm('Send verification email to this user?')) {
                        $("#loaderbody").removeClass('hide');
                        $.ajax({
                            type: 'POST',
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                $("#loaderbody").addClass('hide');
                                alert(response.message);
                            },
                            error: function(xhr) {
                                $("#loaderbody").addClass('hide');
                                alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                            }
                        });
                    }
                }

                function resetPassword(url) {
                    if (confirm('Reset password for this user? They will receive an email with instructions.')) {
                        $("#loaderbody").removeClass('hide');
                        $.ajax({
                            type: 'POST',
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                $("#loaderbody").addClass('hide');
                                alert(response.message);
                            },
                            error: function(xhr) {
                                $("#loaderbody").addClass('hide');
                                alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                            }
                        });
                    }
                }

                // Initialize button colors based on current status
                document.addEventListener('DOMContentLoaded', function() {
                    // This would be set by your backend, but for now we'll use the initial state
                    const buttons = [
                        { type: 'topup', status: {{ $user->top_up_status ? 'true' : 'false' }} },
                        { type: 'register-fee', status: {{ $user->confirmed_registration_fee ? 'true' : 'false' }} },
                        { type: 'notify', status: {{ $user->notification_status ? 'true' : 'false' }} },
                        { type: 'on-topup', status: {{ $user->top_up_status ? 'true' : 'false' }} },
                        { type: 'sub', status: {{ $user->subscription_status ? 'true' : 'false' }} },
                        { type: 'network', status: {{ $user->network_status ? 'true' : 'false' }} }
                    ];
                    
                    buttons.forEach(btn => {
                        const button = document.getElementById(`${btn.type}-btn`);
                        if (button) {
                            button.className = btn.status ? 'btn btn-outline-success' : 'btn btn-outline-primary';
                        }
                    });
                });
            </script>

        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="w-100 clearfix">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018 <a
                        href="https://wa.me/23409010297878" target="_blank">BenTech</a>. All rights reserved.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">special <i
                        class="icon-heart text-danger"></i></span>
            </div>
        </footer>
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
</div>

@include('admin.footer')
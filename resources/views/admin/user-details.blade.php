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
                <a onclick="Topup('{{ route('admin.topup', $user->id) }}')" class="btn btn-outline-primary"><i
                        class="fa fa-money "></i>Top-Up Mail</a>|
                <a onclick="PaidRegisterFee('{{ route('admin.paid-register-fee', $user->id) }}')"
                    class="btn btn-outline-primary"><i class="fa fa-money "></i>Confirm Registratio fee</a>

                <a onclick="PaidRegisterFee('{{ route('admin.on-notify', $user->id) }}')"
                    class="btn btn-outline-primary"><i class="fa fa-money "></i>On Notif</a>

                <a onclick="PaidRegisterFee('{{ route('admin.on-topup', $user->id) }}')"
                    class="btn btn-outline-primary"><i class="fa fa-money "></i>On Top-Up</a>

                <a onclick="PaidRegisterFee('{{ route('admin.on-sub', $user->id) }}')"
                    class="btn btn-outline-primary"><i class="fa fa-money "></i>On Sub</a>
                <a onclick="PaidRegisterFee('{{ route('admin.on-network', $user->id) }}')"
                    class="btn btn-outline-primary"><i class="fa fa-money "></i>On Network</a>

                <!-- New buttons added -->
                <a onclick="sendVerificationEmail('{{ route('admin.send-verification', $user->id) }}')"
                    class="btn btn-outline-info"><i class="fa fa-envelope"></i> Resend Verification</a>
                <a onclick="resetPassword('{{ route('admin.reset-password', $user->id) }}')"
                    class="btn btn-outline-warning"><i class="fa fa-key"></i> Reset Password</a>
            </p>

            <script>
                function Topup(url) {
                    if (confirm('Are you sure this user to Top-up His Account ?') == true) {
                        $("#loaderbody").removeClass('hide');
                        $.ajax({
                            type: 'POST',
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                $("#loaderbody").removeClass('hide');
                                alert(response.message);
                                refreshPage()
                            },
                            error: function(xhr) {
                                $("#loaderbody").removeClass('hide');
                                alert('Error: ' + xhr.responseJSON.message);
                            }
                        });
                    }
                }

                function PaidRegisterFee(url) {
                    if (confirm('Are you sure u want too enable user Fee ?') == true) {
                        $("#loaderbody").removeClass('hide');
                        $.ajax({
                            type: 'POST',
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                $("#loaderbody").removeClass('hide');
                                alert(response.message);
                                refreshPage()
                            },
                            error: function(xhr) {
                                $("#loaderbody").removeClass('hide');
                                alert('Error: ' + xhr.responseJSON.message);
                            }
                        });
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
                                $("#loaderbody").removeClass('hide');
                                alert(response.message);
                            },
                            error: function(xhr) {
                                $("#loaderbody").removeClass('hide');
                                alert('Error: ' + xhr.responseJSON.message);
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
                                $("#loaderbody").removeClass('hide');
                                alert(response.message);
                            },
                            error: function(xhr) {
                                $("#loaderbody").removeClass('hide');
                                alert('Error: ' + xhr.responseJSON.message);
                            }
                        });
                    }
                }

                function refreshPage() {
                    location.reload(true);
                }
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
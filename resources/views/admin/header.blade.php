<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The description of my page">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Index - GlobalCapitalGain Trading Company | Stocks/CFDs Trading Your Online Broker</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('logo-mini1.png') }}" type="image/x-icon">
    <!-- Font Awesome (v4.7) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Simple Line Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">


    <!-- Icon Fonts -->
    <link rel="stylesheet" href="{{ asset('account/vendors/iconfonts/simple-line-icon/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('account/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('account/vendors/iconfonts/font-awesome/css/font-awesome.min.css') }}">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('account/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('account/vendors/css/vendor.bundle.addons.css') }}">

    <!-- Plugin CSS -->
    <link href="{{ asset('account/vendors/summernote/dist/summernote-bs4.css') }}" rel="stylesheet">
    <link href="{{ asset('Account/css/loader.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('asset2/css/sweetalert.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('Account/css/style.css') }}">

    <!-- Toast Notification -->
    <link rel="stylesheet" href="{{ asset('_content/AspNetCoreHero.ToastNotification/notyf.min.css') }}">
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_horizontal-navbar.html -->
        <div class="row">
            <nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
                <div class="nav-top flex-grow-1">
                    <div class="container d-flex flex-row h-100">
                        <div class="text-center navbar-brand-wrapper d-flex align-items-center">
                            <a class="navbar-brand brand-logo" href="{{ url('Admin/Dashboard') }}">
                                <img src="{{ asset('logo.png') }}" alt="logo">
                            </a>
                            <a class="navbar-brand brand-logo-mini1" href="{{ url('Admin/Dashboard') }}">
                                <img src="{{ asset('logo-mini.png') }}" alt="logo">
                            </a>
                        </div>
                        <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between flex-grow-1">
                            <form class="search-field d-none d-md-flex" action="#">
                                <div class="form-group mb-0"></div>
                            </form>
                            <ul class="navbar-nav navbar-nav-right mr-0 ml-auto">
                                <li class="nav-item dropdown d-none d-lg-flex nav-language"></li>
                                <li class="nav-item dropdown d-none d-lg-flex nav-language"></li>
                                <li class="nav-item nav-profile dropdown"></li>
                            </ul>
                            <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
                                <span class="icon-menu text-light"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="nav-bottom">
                    <div class="container">
                        <ul class="nav page-navigation">
                            <li class="nav-item">
                                <a href="{{ route('admin.home') }}" class="nav-link">
                                    <i class="link-icon icon-screen-desktop"></i>
                                    <span class="menu-title">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.withdrawals.index') }}" class="nav-link">
                                    <i class="link-icon fa fa-bar-chart"></i>
                                    <span class="menu-title">Withdrawal Request</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.deposits.index') }}" class="nav-link">
                                    <i class="link-icon icon-film"></i>
                                    <span class="menu-title">Manage Deposit</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('traders.index') }}" class="nav-link">
                                    <i class="link-icon icon-people"></i>
                                    <span class="menu-title">Manage Traders</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.send.email.form') }}" class="nav-link">
                                    <i class="link-icon icon-envelope"></i>
                                    <span class="menu-title">Send Mail</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.wallet_options.index') }}" class="nav-link">
                                    <i class="link-icon icon-wallet"></i>
                                    <span class="menu-title">Payment Method</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.plans.index') }}" class="nav-link">
                                    <i class="link-icon icon-list"></i>
                                    <span class="menu-title">Package List</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.identity-verifications.index') }}" class="nav-link">
                                    <i class="link-icon icon-people"></i>
                                    <span class="menu-title">Manage Kyc</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.trading-histories.index') }}" class="nav-link">
                                    <i class="link-icon icon-people"></i>
                                    <span class="menu-title">Manage Trade History</span>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ url('/Currencies') }}" class="nav-link">
                                    <i class="link-icon icon-credit-card"></i>
                                    <span class="menu-title">Currencies List</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('Admin/EditSignal') }}" class="nav-link">
                                    <i class="link-icon icon-note"></i>
                                    <span class="menu-title">Edit Signal Packages</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('Admin/ChangePhone') }}" class="nav-link">
                                    <i class="link-icon icon-phone"></i>
                                    <span class="menu-title">Change Phone Number</span>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('admin.password.change') }}" class="nav-link">
                                    <i class="link-icon icon-key"></i>
                                    <span class="menu-title">Change password</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('admin.logout') }}" class="navbar-right" id="logoutForm"
                                    method="post">
                                    @csrf
                                    <a href="javascript:document.getElementById('logoutForm').submit()"
                                        class="nav-link">
                                        <i class="link-icon icon-logout"></i>
                                        <span class="menu-title">Log Out</span>
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;




Route::get('/', function () {
    return view('home.homepage');
});

Route::get('/about', function () {
    return view('home.about');
});
Route::get('/faqs', function () {
    return view('home.faqs');
});

Route::get('/contact', function () {
    return view('home.contact');
});

Route::get('/copy-trade', function () {
    return view('home.copy-trade');
});


Route::get('/cookie-policy', function () {
    return view('home.cookie-policy');
});

Route::get('/crypto-mining', function () {
    return view('home.crypto-mining');
});

Route::get('/forex-trading', function () {
    return view('home.forex-trading');
});

Route::get('/privacy-policy', function () {
    return view('home.privacy-policy');
});

Route::get('/bitcoin-mining', function () {
    return view('home.bitcoin-mining');
});

Route::get('/crypto-trading', function () {
    return view('home.crypto-trading');
});

Route::get('/stocks-trading', function () {
    return view('home.stocks-trading');
});

Route::get('/dogecoin-mining', function () {
    return view('home.dogecoin-mining');
});

Route::get('/terms-of-service', function () {
    return view('home.terms-of-service');
});
Route::get('/what-is-leverage', function () {
    return view('home.leverage');
});
Route::get('/responsible-trading', function () {
    return view('home.responsible-trading');
});
Route::get('/general-risk-disclosure', function () {
    return view('home.risk-disclosure');
});
Route::get('/tesla-chart', function () {
    return view('home.tesla');
});
Route::get('/apple-chart', function () {
    return view('home.apple');
});
Route::get('/nvidia-chart', function () {
    return view('home.nvidia');
});
Route::get('/msft-chart', function () {
    return view('home.msft');
});






// Login routes (only accessible to guests)
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'showLoginForm'])->name('login.page');
    Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
});

// Registration routes (only accessible to guests)
Route::middleware('guest')->group(function () {
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.submit');
});

// Referral signup route (only accessible to guests)
Route::middleware('guest')->group(function () {
    Route::get('/signup/{referral_code}', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('referral.signup');
});





// Forgot Password routes
Route::get('/forgot-password', [App\Http\Controllers\Auth\AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\AuthController::class, 'sendResetLinkEmail'])->name('password.email');

// Password Reset routes
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\Auth\AuthController::class, 'reset'])->name('password.update');
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('user.logout');

// Email & User Verification
Route::get('user/v', [App\Http\Controllers\Auth\EmailVerificationController::class, 'emailVerify'])->name('email_verify');
Route::get('user/ver', [App\Http\Controllers\Auth\EmailVerificationController::class, 'userVerify'])->name('user_verify');
Route::get('/verify/{id}', [App\Http\Controllers\Auth\EmailVerificationController::class, 'verify'])->name('verify');
Route::post('/verify-code', [App\Http\Controllers\Auth\EmailVerificationController::class, 'verifyCode'])->name('verify.code');
Route::get('/resend-verification-code', [App\Http\Controllers\Auth\EmailVerificationController::class, 'resendVerificationCode'])->name('resend.verification.code');
Route::post('/skip-code', [App\Http\Controllers\Auth\EmailVerificationController::class, 'skipCode'])->name('skip.code');


Route::prefix('user')->middleware('user')->group(function () {
    Route::get('/home', [App\Http\Controllers\User\UserController::class, 'index'])->name('home');
    Route::prefix('accounts')->name('account.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\ProfileController::class, 'index'])->name('index');
        Route::get('/transfer', [App\Http\Controllers\User\ProfileController::class, 'transfer'])->name('transfer');
        Route::post('/transfer-to-holding', [App\Http\Controllers\User\ProfileController::class, 'transferToHolding'])->name('transfer.to.holding');
        Route::post('/transfer-to-trading', [App\Http\Controllers\User\ProfileController::class, 'transferToTrading'])->name('transfer.to.trading');
        Route::get('/email', [App\Http\Controllers\User\ProfileController::class, 'email'])->name('email');
        Route::post('/email', [App\Http\Controllers\User\ProfileController::class, 'updateEmail'])->name('update.email');
        Route::get('/referrals', [App\Http\Controllers\User\ProfileController::class, 'referrals'])->name('referrals');
        Route::get('/password', [App\Http\Controllers\User\ProfileController::class, 'password'])->name('password');
        Route::post('/password', [App\Http\Controllers\User\ProfileController::class, 'updatePassword'])->name('update.password');
        Route::get('/notifications', [App\Http\Controllers\User\ProfileController::class, 'notifications'])->name('notification');
        Route::get('/address', [App\Http\Controllers\User\ProfileController::class, 'address'])->name('address');
        Route::post('/address', [App\Http\Controllers\User\ProfileController::class, 'updateContactInfo'])->name('update.contact');
        Route::get('/photo', [App\Http\Controllers\User\ProfileController::class, 'photo'])->name('photo');
        Route::post('/photo', [App\Http\Controllers\User\ProfileController::class, 'updatePhoto'])->name('upload.photo');
    });

    Route::prefix('verifications')->name('verifications.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\VerificationController::class, 'index'])->name('index');
        Route::get('/identity', [App\Http\Controllers\User\VerificationController::class, 'identity'])->name('identity');
        // Identity verification route
        Route::post('/identity', [App\Http\Controllers\User\VerificationController::class, 'identityVerify'])
            ->name('user.identity');
        Route::get('/address', [App\Http\Controllers\User\VerificationController::class, 'address'])->name('address');
        Route::post('/address', [App\Http\Controllers\User\VerificationController::class, 'addressVerify'])->name('user.address');
    });

    Route::get('/plans', [App\Http\Controllers\User\PlanController::class, 'index'])->name('plans');
    Route::post('/fund-trading', [App\Http\Controllers\User\PlanController::class, 'fundTrading'])->name('fund.trading');
    Route::get('/holding', [App\Http\Controllers\User\UserController::class, 'holding'])->name('holding');
    Route::get('/trading', [App\Http\Controllers\User\UserController::class, 'trading'])->name('trading');
    Route::get('/current-trade', [App\Http\Controllers\User\UserController::class, 'currentTrade'])->name('current.trade');
    Route::get('/staking', [App\Http\Controllers\User\UserController::class, 'staking'])->name('staking');
    Route::get('/mining', [App\Http\Controllers\User\UserController::class, 'mining'])->name('mining');
    Route::get('/copy-trade', [App\Http\Controllers\User\CopyTradeController::class, 'index'])->name('copy.trade');
    Route::post('/copy-trade', [App\Http\Controllers\User\CopyTradeController::class, 'copyTrader'])->name('copy.trader');
    // Display copied traders
    Route::get('/copied-traders', [App\Http\Controllers\User\CopiedTradeController::class, 'index'])
        ->name('copied.traders');
    Route::post('/copied-traders/stop', [App\Http\Controllers\User\CopiedTradeController::class, 'stop'])
        ->name('copied.traders.stop');
    Route::post('/copy-trader', [App\Http\Controllers\User\CopiedTradeController::class, 'copyTrader'])
        ->name('copy.trader');
    Route::get('/withdrawal', [App\Http\Controllers\User\WithdrawalController::class, 'index'])->name('withdrawal');
    Route::get('/crypto-withdrawal', [App\Http\Controllers\User\WithdrawalController::class, 'cryptoWithdrawal'])->name('crypto.withdrawal');
    Route::post('/submit', [App\Http\Controllers\User\WithdrawalController::class, 'submit'])->name('withdraw.submit');
    Route::get('/deposit', [App\Http\Controllers\User\DepositController::class, 'index'])->name('deposit.page');
    Route::get('/buy-crypto', [App\Http\Controllers\User\DepositController::class, 'buyCrypto'])->name('buy.crypto.page');
    Route::get('fund/step-one', [App\Http\Controllers\User\DepositController::class, 'stepOne'])->name('deposit.one');
    Route::post('fund/step-one', [App\Http\Controllers\User\DepositController::class, 'stepOneSubmit'])->name('deposit.one.submit');
    Route::get('fund/step-two', [App\Http\Controllers\User\DepositController::class, 'stepTwo'])->name('deposit.two');
    Route::post('fund/step-two', [App\Http\Controllers\User\DepositController::class, 'stepTwoSubmit'])->name('deposit.two.submit');
    Route::get('fund/step-three', [App\Http\Controllers\User\DepositController::class, 'stepThree'])->name('deposit.three');
    Route::post('fund/step-three', [App\Http\Controllers\User\DepositController::class, 'stepThreeSubmit'])->name('deposit.three.submit');
    Route::get('fund/pay-crypto', [App\Http\Controllers\User\DepositController::class, 'payCrypto'])->name('pay.crypto');
    Route::post('fund/pay-crypto', [App\Http\Controllers\User\DepositController::class, 'payment'])->name('user.pay.crypto');
    Route::get('/payment-failed', function () {
        return view('user.deposit.failed');
    })->name('payment.failed');

    Route::post('/verify-payment', [App\Http\Controllers\User\DepositController::class, 'verifyPayment'])->name('verify.payment');
    Route::get('/check-payment-status', [App\Http\Controllers\User\DepositController::class, 'checkPaymentStatus'])->name('check.payment.status');
});

Route::get('admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'adminLoginForm'])->name('admin.login');
Route::post('admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('login.submit');



// Admin Routes






Route::prefix('admin')->group(function () {    // Protecting admin routes using the 'admin' middleware
    Route::post('logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('logout');
    Route::middleware(['admin'])->group(function () { // Admin Profile Routes

        Route::get('/home', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.home');
        Route::get('/Dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/Details/{id}', [App\Http\Controllers\Admin\AdminController::class, 'show'])->name('admin.user.details');

        // AJAX routes
        Route::post('/Verify/{id}', [App\Http\Controllers\Admin\AdminController::class, 'verifyUser'])->name('admin.verify.user');
        Route::post('/MemberVerify/{id}', [App\Http\Controllers\Admin\AdminController::class, 'memberVerify'])->name('admin.member.verify');
        Route::post('/PaidCF/{id}', [App\Http\Controllers\Admin\AdminController::class, 'paidCF'])->name('admin.paid.cf');
        Route::post('/DeactivateAccount/{id}', [App\Http\Controllers\Admin\AdminController::class, 'deactivateAccount'])->name('admin.deactivate.account');
        Route::post('/Delete/{id}', [App\Http\Controllers\Admin\AdminController::class, 'deleteUser'])->name('admin.delete.user');




        // Client routes
        Route::get('/client/{user}', [App\Http\Controllers\Admin\ManageUserController::class, 'showClient'])->name('admin.client.show');
        Route::get('/client/{user}/deposit', [App\Http\Controllers\Admin\ManageUserController::class, 'deposit'])->name('admin.deposit');
        Route::get('/client/{user}/upgrade', [App\Http\Controllers\Admin\ManageUserController::class, 'upgrade'])->name('admin.upgrade');
        Route::get('/client/{user}/trade', [App\Http\Controllers\Admin\ManageUserController::class, 'profit'])->name('admin.profit');
        Route::get('/client/{user}/edit', [App\Http\Controllers\Admin\ManageUserController::class, 'edit'])->name('admin.edit');
        Route::get('/client/{user}/edit-bill', [App\Http\Controllers\Admin\ManageUserController::class, 'editBill'])->name('admin.edit-bill');

        // AJAX actions
        Route::post('/client/{user}/topup', [App\Http\Controllers\Admin\ManageUserController::class, 'topup'])->name('admin.topup');
        Route::post('/client/{user}/paid-register-fee', [App\Http\Controllers\Admin\ManageUserController::class, 'paidRegisterFee'])->name('admin.paid-register-fee');
        Route::post('/client/{user}/on-notify', [App\Http\Controllers\Admin\ManageUserController::class, 'onNotify'])->name('admin.on-notify');
        Route::post('/client/{user}/on-topup', [App\Http\Controllers\Admin\ManageUserController::class, 'onTopup'])->name('admin.on-topup');
        Route::post('/client/{user}/on-sub', [App\Http\Controllers\Admin\ManageUserController::class, 'onSub'])->name('admin.on-sub');
        Route::post('/client/{user}/on-network', [App\Http\Controllers\Admin\ManageUserController::class, 'onNetwork'])->name('admin.on-network');
        Route::post('/client/{user}/send-verification', [App\Http\Controllers\Admin\ManageUserController::class, 'sendVerification'])->name('admin.send-verification');
        Route::post('/client/{user}/reset-password', [App\Http\Controllers\Admin\ManageUserController::class, 'resetPassword'])->name('admin.reset-password');






        // Other balance controller
        Route::post('/holding-balance', [App\Http\Controllers\Admin\BalanceController::class, 'updateHoldingBalance'])->name('admin.update.holding');
        Route::post('/mining-balance', [App\Http\Controllers\Admin\BalanceController::class, 'updateMiningBalance'])->name('admin.update.mining');
        Route::post('/referral-balance', [App\Http\Controllers\Admin\BalanceController::class, 'updateReferralBalance'])->name('admin.update.referral');
        Route::post('/profit-balance', [App\Http\Controllers\Admin\BalanceController::class, 'updateProfitBalance'])->name('admin.update.profit');
        Route::post('/staking-balance', [App\Http\Controllers\Admin\BalanceController::class, 'updateStakingBalance'])->name('admin.update.staking');
        Route::post('/trading-balance', [App\Http\Controllers\Admin\BalanceController::class, 'updateTradingBalance'])->name('admin.update.trading');

        Route::post('/deposits/create', [App\Http\Controllers\Admin\BalanceController::class, 'createDeposit'])
            ->name('admin.create.deposit');
        Route::post('/profits/create', [App\Http\Controllers\Admin\BalanceController::class, 'createProfit'])
            ->name('admin.create.profit');




        // Traders Routes
        Route::resource('traders', \App\Http\Controllers\Admin\TraderController::class);



        Route::resource('wallet_options', \App\Http\Controllers\Admin\WalletOptionController::class)
            ->names([
                'index' => 'admin.wallet_options.index',
                'store' => 'admin.wallet_options.store',
                'update' => 'admin.wallet_options.update',
                'destroy' => 'admin.wallet_options.destroy',
            ]);



        Route::resource('plans', \App\Http\Controllers\Admin\ManagePlan::class)
            ->names([
                'index' => 'admin.plans.index',
                'store' => 'admin.plans.store',
                'update' => 'admin.plans.update',
                'destroy' => 'admin.plans.destroy',
            ]);



        // Deposits Management
        Route::get('/deposits', [App\Http\Controllers\Admin\DepositController::class, 'index'])->name('admin.deposits.index');
        Route::put('/deposits/{deposit}', [App\Http\Controllers\Admin\DepositController::class, 'update'])->name('admin.deposits.update');
        Route::delete('/deposits/{deposit}', [App\Http\Controllers\Admin\DepositController::class, 'destroy'])->name('admin.deposits.destroy');


        // Withdrawals Management
        Route::get('/withdrawals', [App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('admin.withdrawals.index');
        Route::put('/withdrawals/{withdrawal}', [App\Http\Controllers\Admin\WithdrawalController::class, 'update'])->name('admin.withdrawals.update');
        Route::delete('/withdrawals/{withdrawal}', [App\Http\Controllers\Admin\WithdrawalController::class, 'destroy'])->name('admin.withdrawals.destroy');


        // Identity Verifications Management
        Route::get('/identity-verifications', [App\Http\Controllers\Admin\IdentityVerificationController::class, 'index'])
            ->name('admin.identity-verifications.index');
        Route::put('/identity-verifications/{identityVerification}', [App\Http\Controllers\Admin\IdentityVerificationController::class, 'update'])
            ->name('admin.identity-verifications.update');
        Route::delete('/identity-verifications/{identityVerification}', [App\Http\Controllers\Admin\IdentityVerificationController::class, 'destroy'])
            ->name('admin.identity-verifications.destroy');



        // Trading Histories Management
        Route::get('/trading-histories', [App\Http\Controllers\Admin\TradingHistoryController::class, 'index'])
            ->name('admin.trading-histories.index');
        Route::put('/trading-histories/{tradingHistory}', [App\Http\Controllers\Admin\TradingHistoryController::class, 'update'])
            ->name('admin.trading-histories.update');
        Route::delete('/trading-histories/{tradingHistory}', [App\Http\Controllers\Admin\TradingHistoryController::class, 'destroy'])
            ->name('admin.trading-histories.destroy');

        // Password Change Routes
        Route::get('/change-password', [App\Http\Controllers\Admin\AdminController::class, 'showChangePasswordForm'])
            ->name('admin.password.change');
        Route::post('/change-password', [App\Http\Controllers\Admin\AdminController::class, 'updatePassword'])
            ->name('admin.password.update');



        // Email Routes
        Route::get('/send-email', [App\Http\Controllers\Admin\AdminController::class, 'showSendEmailForm'])
            ->name('admin.send.email.form');
        Route::post('/send-email', [App\Http\Controllers\Admin\AdminController::class, 'sendEmail'])
            ->name('admin.send.email');

        // Logout Route
        Route::post('/logout', [App\Http\Controllers\Admin\AdminController::class, 'logout'])
            ->name('admin.logout');


        // Other admin routes
        Route::get('/withdrawal', function () {
            return view('admin.withdrawal');
        })->name('admin.withdrawal');
        Route::get('/DepisitLog', function () {
            return view('admin.transaction');
        })->name('admin.transaction');
        Route::get('/Traders', function () {
            return view('admin.traders');
        })->name('admin.traders');

        Route::get('/PaymentMethod', function () {
            return view('admin.payment-method');
        })->name('admin.payment.method');
        Route::get('/EditSignal', function () {
            return view('admin.edit-signal');
        })->name('admin.edit.signal');
        Route::get('/ChangePhone', function () {
            return view('admin.change-phone');
        })->name('admin.change.phone');
        Route::get('/changePassword', function () {
            return view('admin.change-password');
        })->name('admin.change.password');
    });

    // General routes
    Route::get('/Plan', function () {
        return view('admin.package-list');
    })->name('admin.package.list');
    Route::get('/Currencies', function () {
        return view('admin.currencies-list');
    })->name('admin.currencies.list');
    Route::post('/Accountlogoff', [AuthController::class, 'logout'])->name('logout');
});

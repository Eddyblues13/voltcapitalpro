@include('user.layouts.header')
<!-- Main Content -->
<div class="depost-form-main px-2">
    <h1 class="amount text-white" style="font-size: 4rem; color: white !important;">PAY {{ config('currencies.' .
        auth()->user()->currency, '$') }}{{ request('amount') }}</h1>
    <a href="#" class="view-pricing text-secondary">Send Crypto</a>

    <div class="fund-card">
        <div class="section-title">
            <i class="fas fa-coins"></i>
            <span>Select Deposit Method</span>
        </div>

        <div class="payment-methods">
            @foreach($paymentMethods as $method)
            <div class="method-card" data-method="{{ $method->name }}">
                <div class="method-icon">
                    @if(!empty($method->coin_pic_path))
                    <img src="{{ asset($method->coin_pic_path) }}" alt="{{ $method->name }} icon"
                        style="width: 30px; height: 30px; margin-left: 10px;">
                    @else
                    <img src="{{ asset('images/default-coin.png') }}" alt="default icon"
                        style="width: 30px; height: 30px; margin-left: 10px;">
                    @endif
                </div>
                <div class="method-name">{{ $method->name }}</div>
            </div>
            @endforeach
        </div>


        <button class="withdrawal-btn" id="proceedButton">
            <span id="buttonText">Proceed</span>
            <span id="loadingSpinner" style="display: none;">
                <div class="loading-spinner"></div> Processing...
            </span>
        </button>
    </div>
</div>

<!-- Include jQuery, Toastr, and Font Awesome -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Payment Methods Section */
    .section-title {
        font-size: 1.4rem;
        margin-bottom: 20px;
        color: #e2e8f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #60a5fa;
    }

    .payment-methods {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .method-card {
        background: rgba(30, 41, 59, 0.7);
        border-radius: 12px;
        padding: 20px 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .method-card:hover {
        transform: translateY(-5px);
        background: rgba(30, 41, 59, 0.9);
        border-color: rgba(96, 165, 250, 0.3);
    }

    .method-card.selected {
        border-color: #60a5fa;
        background: rgba(30, 41, 59, 0.9);
        box-shadow: 0 0 15px rgba(96, 165, 250, 0.3);
    }

    .method-card.selected::after {
        content: '✓';
        position: absolute;
        top: 5px;
        right: 5px;
        background: #60a5fa;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .method-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .method-name {
        font-size: 1rem;
        font-weight: 600;
        color: #e2e8f0;
    }

    /* Existing Styles */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
        margin-right: 8px;
        vertical-align: middle;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    @media (max-width: 600px) {
        .payment-methods {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<script>
    $(document).ready(function () {
        let selectedMethod = null;

        // Handle method selection
        $('.method-card').on('click', function() {
            $('.method-card').removeClass('selected');
            $(this).addClass('selected');
            selectedMethod = $(this).data('method');
        });

        // Handle form submission
        $('#proceedButton').on('click', function (e) {
            e.preventDefault();

            if (!selectedMethod) {
                toastr.error('Please select a payment method', 'Error');
                return;
            }

            // Show loading spinner and disable button
            $('#buttonText').hide();
            $('#loadingSpinner').show();
            $('#proceedButton').prop('disabled', true);

            // Get form data
            const amount = "{{ request('amount') }}";
            const currency = "{{ auth()->user()->currency }}";

            // Send AJAX request
            $.ajax({
                url: '{{ route("user.pay.crypto") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    amount: amount,
                    payment_method: selectedMethod,
                    currency: currency
                },
                success: function (response) {
                    // Hide loading spinner and enable button
                    $('#buttonText').show();
                    $('#loadingSpinner').hide();
                    $('#proceedButton').prop('disabled', false);

                    if (response.success) {
                        toastr.success(response.message, 'Success');
                        // Redirect to payment instructions page after 2 seconds
                        setTimeout(() => {
                            window.location.href = response.redirect_url;
                        }, 2000);
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function (xhr) {
                    // Hide loading spinner and enable button
                    $('#buttonText').show();
                    $('#loadingSpinner').hide();
                    $('#proceedButton').prop('disabled', false);

                    let errorMessage = 'An error occurred. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.statusText) {
                        errorMessage = xhr.statusText;
                    }
                    
                    toastr.error(errorMessage, 'Error');
                }
            });
        });
    });
</script>
@include('user.layouts.footer')
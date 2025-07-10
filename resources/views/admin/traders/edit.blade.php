@include('admin.header')

<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">

            <h1>Edit Trader</h1>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="post" enctype="multipart/form-data" class="m-5" action="/Admin/EditTrader/{{ $trader->id }}">
                @csrf
                @method('PUT')

                <div class="validation-summary-valid" data-valmsg-summary="true">
                    <ul>
                        <li style="display:none"></li>
                    </ul>
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder="Full Name" data-val="true"
                        data-val-required="The Name field is required." id="Name" name="Name"
                        value="{{ old('Name', $trader->name) }}">
                    @error('Name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Min. Portfolio</label>
                    <input type="text" class="form-control" placeholder="Min. Amount" data-val="true"
                        data-val-number="The field MinPortfolio must be a number."
                        data-val-required="The MinPortfolio field is required." id="MinPortfolio" name="MinPortfolio"
                        value="{{ old('MinPortfolio', $trader->min_amount) }}" />
                    @error('MinPortfolio')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Experience</label>
                    <input type="text" class="form-control" data-val="true"
                        data-val-number="The field Exprience must be a number."
                        data-val-required="The Exprience field is required." id="Exprience" name="Exprience"
                        value="{{ old('Exprience', $trader->return_rate) }}" />
                    @error('Exprience')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Percentage</label>
                    <input type="text" class="form-control" placeholder="Percentage Charge" data-val="true"
                        data-val-number="The field PercentageGain must be a number."
                        data-val-required="The PercentageGain field is required." id="PercentageGain"
                        name="PercentageGain" value="{{ old('PercentageGain', $trader->profit_share) }}" />
                    @error('PercentageGain')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Currency Pairs</label>
                    <input type="text" class="form-control" id="CurrencyPair" name="CurrencyPair"
                        value="{{ old('CurrencyPair', $trader->currency_pairs) }}" />
                    @error('CurrencyPair')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Details</label>
                    <textarea class="form-control" rows="6" data-val="true"
                        data-val-required="The Details field is required." id="Details" name="Details">
                        {{ old('Details', $trader->details) }}
                    </textarea>
                    @error('Details')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Profile Pic</label>
                    @if($trader->picture_url)
                    <div class="mb-2">
                        <img src="{{ $trader->picture_url }}" style="width: 100px; height: 100px; object-fit: cover;"
                            class="img-thumbnail">
                    </div>
                    @endif
                    <input type="file" class="form-control" id="ProfilePic" name="ProfilePic" />
                    @error('ProfilePic')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <input id="submitbtn" type="submit" class="btn btn-primary" value="Update Trader">
                <input name="__RequestVerificationToken" type="hidden" value="{{ csrf_token() }}" />
            </form>

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

<!-- Rest of your existing scripts and styles -->
<script>
    // Display toast notifications
    @if(Session::has('success'))
        toastNotifySuccess("{{ Session::get('success') }}");
    @endif
    
    @if(Session::has('error'))
        toastNotifyError("{{ Session::get('error') }}");
    @endif
    
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastNotifyError("{{ $error }}");
        @endforeach
    @endif
</script>
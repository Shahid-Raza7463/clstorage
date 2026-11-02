{{-- search filter  --}}
<form action="/affiliate-networks" id="searchForm" method="get">
    <div class="filter">
        <div class="dropdown d-flex justify-content-between dropdown-grid">
            <h6 class="mt-1 f-text">Filters <i class="fa-solid fa-filter mx-2 filter-icon"></i></h6>
            <div class="btn-group btn-ligh border-0 shadow-sm">
                <select id="select-option-network"
                    class="hover:bg-blue-lightest hover:text-grey-darkest border-b border-dashed shadow-sm style"
                    style="width: 190px" name="vertical" onchange="redirectToURL(this.value)">
                    <option value=""selected>Networks Categories</option>
                    @foreach ($network_categories as $title)
                        <option value="{{ $title->title }}"
                            class="select-icon hover:bg-blue-lightest hover:text-grey-darkest option-style"
                            @if (request('vertical') === $title->title) selected @endif>
                            {{-- above if statment print url value in select box --}}
                            <i class="{{ $title->icon }}"></i>
                            <span>
                                {{ $title->title }}
                            </span>
                            <span>
                                ({{ $title->network_numbers }})
                            </span>
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="btn-group btn-ligh border-0 shadow-sm">
                <select id="select-option-software" name="software"
                    class="hover:bg-blue-lightest hover:text-grey-darkest shadow-sm style" style="width: 190px"
                    onchange="redirectToURL(this.value)">
                    <option value=""selected>Tracking Software</option>
                    @foreach ($software as $s)
                        <option value="{{ $s->name }}"
                            class="select-icon hover:bg-blue-lightest hover:text-grey-darkest border-b border-dashed option-style"
                            @if (request('software') === $s->name) selected @endif>
                            {{ $s->name }}
                            ({{ $s->network_numbers }})
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="btn-group btn-ligh border-0 shadow-sm">
                <select id="select-option-payment-frequency" name="payment_frequency"
                    class="hover:bg-blue-lightest hover:text-grey-darkest shadow-sm style" style="width: 190px"
                    onchange="redirectToURL(this.value)">
                    <option value=""selected>Payment Frequency</option>
                    @foreach ($payment_frequency as $name)
                        <option value="{{ $name->name }}"
                            class="select-icon hover:bg-blue-lightest hover:text-grey-darkest border-b border-dashed option-style"
                            @if (request('payment_frequency') === $name->name) selected @endif>
                            {{ $name->name }}
                            ({{ $name->network_numbers }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="btn-group btn-ligh border-0 shadow-sm">
                <select id="select-option-payment-method" name="payment_method"
                    class="hover:bg-blue-lightest hover:text-grey-darkest border-b border-dashed shadow-sm style"
                    style="width: 190px" onchange="redirectToURL(this.value)">
                    <option value=""selected>Payment Method</option>
                    @foreach ($payment_method as $payment)
                        <option value="{{ $payment->name }}"
                            class="select-icon hover:bg-blue-lightest hover:text-grey-darkest option-style"
                            @if (request('payment_method') === $payment->name) selected @endif>
                            {{ $payment->name }}
                            ({{ $payment->network_numbers }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</form>

                                <div class="form-group col-lg-4">
                                    <label>Invoice Number</label>
                                    @isset($invoice)
                                        <input type="text" id="" class="form-control" placeholder="Invoice Number" value="{{ $invoice->invoice_number }}" disabled>
                                    @else
                                        <input type="text" name="invoice_number" id="" class="form-control @error('invoice_number') is-invalid @enderror" placeholder="Invoice Number" value="{{ old('invoice_number') }}">
                                        @error('invoice_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    @endisset
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Invoice Date</label>
                                    <input type="text" name="invoice_date" id="" class="form-control fc-datepicker @error('invoice_date') is-invalid @enderror" placeholder="Invoice Date" value="{{ isset($invoice) ? $invoice->invoice_date : old('invoice_date') }}">
                                    @error('invoice_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Due Date</label>
                                    <input type="text" name="due_date" id="" class="form-control fc-datepicker @error('due_date') is-invalid @enderror" placeholder="Due Date" value="{{ isset($invoice) ? $invoice->due_date : old('due_date') }}">
                                    @error('due_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Section</label>
                                    <select name="section" id="section" class="form-control @error('section') is-invalid @enderror">
                                        @if(!isset($invoice))
                                            <option selected disabled>Select Section</option>
                                        @endif
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}" {{ isset($invoice) && $section->id == $invoice->section_id || $section->id == old('section') ? 'selected' : '' }}> {{ $section->section_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('section')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Product</label>
                                    <select name="product" id="product" class="form-control @error('product') is-invalid @enderror">
                                        @isset($invoice)
                                            <option value="{{ $product_id[0] }}"> {{ $invoice->product_name }}</option>
                                        @else
                                            <option selected disabled>Select Product</option>
                                        @endisset
                                    </select>
                                    @error('product')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Collection Amount</label>
                                    <input type="text" name="collection" id="collection" class="form-control @error('collection') is-invalid @enderror" placeholder="Collection Amount"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{ isset($invoice) ? $invoice->collection_amount : old('collection') }}">
                                    @error('amount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Commission Amount</label>
                                    <input type="text" name="commission" id="commission" class="form-control @error('commission') is-invalid @enderror" placeholder="Commission Amount"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{ isset($invoice) ? $invoice->commission_amount : old('commission') }}">
                                    @error('commission')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Discount</label>
                                    <input type="text" name="discount" id="discount" class="form-control @error('discount') is-invalid @enderror" placeholder="Discount"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{ isset($invoice) ? $invoice->discount : old('discount') }}">
                                    @error('discount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Vat Rate</label>
                                    <input type="number" name="vat_rate" id="vat_rate" class="form-control @error('vat_rate') is-invalid @enderror" placeholder="Vat Rate" min="0" step=".01" value="{{ isset($invoice) ? $invoice->vat_rate : old('vat_rate') }}">
                                    @error('vat_rate')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Vat Value</label>
                                    <input type="text" name="vat_value" id="vat_value" class="form-control @error('vat_value') is-invalid @enderror" placeholder="Vat Value" value="{{ isset($invoice) ? $invoice->vat_value : old('vat_value') }}" readonly>
                                    @error('vat_value')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Total (Inc Vat)</label>
                                    <input type="text" name="total" id="total" class="form-control @error('total') is-invalid @enderror" placeholder="Total (Inc Vat)" value="{{ isset($invoice) ? $invoice->total : old('total') }}" readonly>
                                    @error('total')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Notes</label>
                                    <textarea class="form-control @error('note') is-invalid @enderror" name="note" id="" placeholder="Notes" rows="3">{{ isset($invoice) ? $invoice->note : old('note') }}</textarea>
                                    @error('note')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                @if(Route::currentRouteName() == 'invoices.create')
                                    <div class="form-group col-lg-12">
                                        <label>Attachment - </label>
                                        <small class="text-danger font-weight-bold">
                                            Only PDF, JPG or PNG is accepted
                                        </small>
                                        <input class="dropify" type="file" name="attachment" accept=".pdf, .jpg, .png, jpeg" data-height="150">
                                        @error('attachment')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                @endif
                                <div class="form-group col-lg-12 text-right mt-2">
                                    <hr>
                                    <button type="submit" class="btn btn-lg btn-primary">{{ $submitText }}</button>
                                </div>

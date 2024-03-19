<div class="form-group col-12">
    <input type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" id="product_name" placeholder="Product Name" @isset($product) value="{{ $product->product_name }}" @else value="{{ old('product_name') }}" @endisset required>
    @error('section_name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="form-group col-12">
    <select class="form-control @error('section_name') is-invalid @enderror" name="section_name" style="width: 100% !important" id="section_name">
        <option disabled selected>Select Section</option>
        @foreach ($sections as $id => $sec)
            <option value="{{ $id }}" {{ old('section_name') == $id ? 'selected' : '' }}>
                {{$sec}}
            </option>
        @endforeach
    </select>
    @error('section_name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="form-group col-12">
    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Description" rows="3"  @isset($product) value="{{ $product->description }}" @else value="{{ old('description') }}" @endisset></textarea>
    @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>





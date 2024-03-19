<div class="form-group col-12">
    <input type="text" class="form-control @error('section_name') is-invalid @enderror" name="section_name" id="section_name" placeholder="Section Name" @isset($section) value="{{ $section->section_name }}" @else value="{{ old('section_name') }}" @endisset required>
    @error('section_name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="form-group col-12">
    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Description" rows="3"  @isset($section) value="{{ $section->description }}" @else value="{{ old('description') }}" @endisset></textarea>
    @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

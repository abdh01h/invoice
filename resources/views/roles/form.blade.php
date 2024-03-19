                                <div class="form-group col-lg-12">
                                    <label>Role Name</label>
                                    <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror" placeholder="Role Name" value="{{ isset($role) ? $role->name : old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Permissions</label>
                                    @error('permission')
                                        <br>
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <label class="d-flex align-items-center mb-0">
                                                <span class="check-box mb-0">
                                                    <span class="ckbox">
                                                        <input type="checkbox" onClick="toggle(this)">
                                                        <span></span>
                                                    </span>
                                                </span>
                                                <span class="ml-2 my-auto">Select All</span>
                                            </label>
                                        </li>
                                        @foreach($permissions as $value)
                                            <li class="list-group-item">
                                                <label class="d-flex align-items-center mb-0">
                                                    <span class="check-box mb-0">
                                                        <span class="ckbox">
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                                                            @isset($rolePermissions)
                                                                @foreach($rolePermissions as $check)
                                                                {{ isset($rolePermissions) && $value->id == $check ? 'checked' : '' }}
                                                                @endforeach
                                                            @endisset>
                                                            <span></span>
                                                        </span>
                                                    </span>
                                                    <span class="ml-2 my-auto">{{ $value->name }}</span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="form-group col-lg-12 text-right mt-2">
                                    <hr>
                                    <button type="submit" class="btn btn-lg btn-primary">{{ $submitText }}</button>
                                </div>

                                <div class="form-group col-lg-12">
                                    <label>Full Name</label>
                                    <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" value="{{ isset($user) ? $user->name : old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Email Address</label>
                                    <input type="email" name="email" id="" class="form-control @error('email') is-invalid @enderror" placeholder="example@example.com" value="{{ isset($user) ? $user->email : old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Password</label>
                                    <input type="password" name="password" id="" class="form-control @error('password') is-invalid @enderror" placeholder="Type a new password of at least 8 characters">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="" class="form-control" placeholder="Confirm password">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Role</label>
                                    <select name="roles[]" class="form-control @error('roles') is-invalid @enderror">
                                        @if(!isset($user) || !isset($userRole))
                                            <option selected disabled>Select Role</option>
                                        @endif
                                        @foreach($roles as $role)
                                            <option value="{{ $role }}" {{ isset($userRole) && $userRole == $role ? 'selected' : old('role') }}>{{ $role }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        @if(!isset($user))
                                            <option selected disabled>Select Role</option>
                                        @endif
                                        <option value="1" {{ isset($user) && $user->status == 1 ? 'selected' : old('status') }}>Active</option>
                                        <option value="0" {{ isset($user) && $user->status == 0 ? 'selected' : old('status') }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-12 text-right mt-2">
                                    <hr>
                                    <button type="submit" class="btn btn-lg btn-primary">{{ $submitText }}</button>
                                </div>

@extends('Admin.layouts.master')
@section('source', 'Users')
@section('page-title', 'Edit Password')
@section('title')
    {{ config('app.name') }} - Edit Password
@endsection

@section('content')
    <style>
        .is-valid {
            border-color: #28a745 !important;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.4);
        }

        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 5px rgba(220, 53, 69, 0.4);
        }
    </style>

    <div class="container-fluid py-4">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5>Edit User - {{ $user->fname }} {{ $user->lname }}</h5>
            </div>
            <div class="px-3 pt-0 pb-2">
                <div class="row">
                    <!-- Left Side: User Info -->
                    <div class="col-lg-7 ">
                        <div class="card px-3 pt-0 pb-2">
                        <h6 class="mb-3 text-secondary">Update User Information</h6>
                        <form id="userUpdateForm{{ $user->user_id }}"
                            action="{{ route('admin.users.update', $user->user_id ?? 0) }}" method="POST"
                            enctype="multipart/form-data" novalidate>
                            @csrf

                            <input type="hidden" name="user_id" value="{{ $user->user_id }}">

                            <div class="form-group ">
                                <label class="text-uppercase text-secondary">First Name</label>
                                <input type="text" name="fname" id="fname" value="{{ $user->fname }}"
                                    class="form-control" required>
                                <div class="invalid-feedback">First name cannot be blank!</div>
                                @error('fname')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="text-uppercase text-secondary">Last Name</label>
                                <input type="text" name="lname" id="lname" value="{{ $user->lname }}"
                                    class="form-control" required>
                                <div class="invalid-feedback">Last name cannot be blank!</div>
                                @error('lname')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="text-uppercase text-secondary">Email</label>
                                <input type="email" name="email" id="email" value="{{ $user->email }}"
                                    class="form-control" required>
                                <div class="invalid-feedback">Email cannot be blank!</div>
                                @error('email')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            
                                <div class="form-group mb-3">
                                    <label class="text-uppercase text-secondary">Image</label>
                                    <input type="file" name="image" accept=".jpg,.png,.jpeg" class="form-control">
                                    @error('image')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-uppercase text-secondary">Description</label>
                                    <textarea name="description" id="description" placeholder="Description" class="form-control">{{ $user->description }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>


                                <!-- Roles Section -->
                                <label class="mb-2 text-uppercase text-secondary">Assign
                                    Role</label>
                                <div class="row">
                                    @foreach ($roles as $permission)
                                        @php
                                            $rolePermissions = $user->roles->pluck('id')->toArray();
                                        @endphp
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    class="form-check-input" id="perm_{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                    {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                </div>

                            

                            <div class="text-end">
                                <a href="{{ route('admin.users.show') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                        </div>
                    </div>

                    <!-- Right Side: Password Update -->
                    <div class="col-lg-5">
                        <div class="card px-3 pt-0 pb-2">
                        <h6 class=" text-secondary">Update Password</h6>
                        <form id="passwordUpdateForm{{ $user->user_id }}"
                            action="{{ route('admin.users.update-password', $user->user_id) }}" method="POST"
                            enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="form-group  ">
                                <label class="text-uppercase text-secondary">Current Password</label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="currentPassword{{ $user->user_id }}"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        style="height:41px;"required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button"
                                        data-target="currentPassword{{ $user->user_id }}" style="height:41px;">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label class="text-uppercase text-secondary">New Password</label>
                                <div class="input-group">
                                    <input type="password" name="new_password" id="newPassword{{ $user->user_id }}"
                                        class="form-control @error('current_password') is-invalid @enderror" style="height:41px;" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button"
                                        data-target="newPassword{{ $user->user_id }}" style="height:41px;">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group  ">
                                <label class="text-uppercase text-secondary">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" name="new_password_confirmation"
                                        id="confirmPassword{{ $user->user_id }}" class="form-control"
                                        style="height:41px;" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button"
                                        data-target="confirmPassword{{ $user->user_id }}" style="height:41px;">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    
                                </div>
                                <div class="invalid-feedback d-block" id="passwordError{{ $user->user_id }}"
                                    style="display:none;"></div>
                                
                                @error('new_password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.users.show') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <script>
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ $user->user_id }};
        const newPassword = document.getElementById(`newPassword${userId}`);
        const confirmPassword = document.getElementById(`confirmPassword${userId}`);
        const errorDiv = document.getElementById(`passwordError${userId}`);
        const form = document.getElementById(`passwordUpdateForm${userId}`);

        function checkPasswords() {
            const newVal = newPassword.value.trim();
            const confirmVal = confirmPassword.value.trim();

            // Reset styles
            newPassword.classList.remove('is-valid', 'is-invalid');
            confirmPassword.classList.remove('is-valid', 'is-invalid');

            // Default: hide error
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';

            // If both empty — do nothing
            if (!newVal && !confirmVal) return true;

            // If both filled and don't match
            if (newVal && confirmVal && newVal !== confirmVal) {
                newPassword.classList.add('is-invalid');
                confirmPassword.classList.add('is-invalid');
                errorDiv.textContent = "Passwords do not match!";
                errorDiv.style.display = 'block';
                return false;
            }

            // If both filled and match
            if (newVal && confirmVal && newVal === confirmVal) {
                newPassword.classList.add('is-valid');
                confirmPassword.classList.add('is-valid');
                errorDiv.textContent = '';           // ✅ clear message
                errorDiv.style.display = 'none';     // ✅ hide error
                return true;
            }

            return true;
        }

        newPassword.addEventListener('input', checkPasswords);
        confirmPassword.addEventListener('input', checkPasswords);

        form.addEventListener('submit', function(e) {
            if (!checkPasswords()) e.preventDefault();
        });

        // 👁️ Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.dataset.target;
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });
    });
</script>

@endsection

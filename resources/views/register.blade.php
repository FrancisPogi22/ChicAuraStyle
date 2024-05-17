<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
</head>

<body>
    @include('partials.header')
    <section id="register">
        <div class="wrapper">
            <div class="register-con">
                <div class="register-details-con">
                    <h2>ChicAuraStyle</h2>
                    <p>Where elegance meets functionality. Explore our curated collection of chic dresses and stylish
                        bags. Elevate your wardrobe with timeless pieces designed to enhance your style effortlessly.
                    </p>
                </div>
                <form action="{{ route('register.user') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="field-con">
                        <i class="bi bi-person"></i>
                        <input type="text" name="username" class="form-control"
                            value="{{ !empty(old('username')) ? old('username') : null }}" placeholder="Username"
                            required>
                    </div>
                    <div class="field-con">
                        <i class="bi bi-envelope-at"></i>
                        <input type="email" name="email" class="form-control"
                            value="{{ !empty(old('email')) ? old('email') : null }}" placeholder="Email" required>
                    </div>
                    <div class="field-con">
                        <i class="bi bi-card-text"></i>
                        <input type="text" name="address" class="form-control"
                            value="{{ !empty(old('address')) ? old('address') : null }}" placeholder="Address">
                    </div>
                    <div class="field-con password-toggle">
                        <i class="bi bi-key"></i>
                        <input type="password" name="password" id="authPassword" class="form-control"
                            placeholder="Password">
                        <i class="bi bi-eye-slash" id="toggle-password"></i>
                    </div>
                    <div class="field-con Cpassword-toggle">
                        <i class="bi bi-shield-lock"></i>
                        <input type="password" name="Cpassword" id="authCPassword" class="form-control"
                            placeholder="Password">
                        <i class="bi bi-eye-slash" id="toggle-Cpassword"></i>
                    </div>
                    <div class="btn-con">
                        <button type="submit" class="dark">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @include('partials.plugins')
    @include('partials.script')
    @include('partials.toastr')
    <script>
        $(document).ready(() => {
            $(document).on('click', '#toggle-password', function() {
                const authPassword = $("#authPassword");
                authPassword.attr('type', authPassword.attr('type') == 'password' ? 'text' : 'password');
                $(this).toggleClass("bi-eye-slash bi-eye");
            });

            $(document).on('click', '#toggle-Cpassword', function() {
                const authPassword = $("#authCPassword");
                authPassword.attr('type', authPassword.attr('type') == 'password' ? 'text' : 'password');
                $(this).toggleClass("bi-eye-slash bi-eye");
            });
        });
    </script>
</body>

</html>

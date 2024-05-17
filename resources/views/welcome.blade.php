<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
</head>

<body>
    @include('partials.header')
    <section id="welcome">
        <div class="wrapper">
            <div class="welcome-con">
                <div class="welcome-details-con">
                    <h2>ChicAuraStyle</h2>
                    <p>Where elegance meets functionality. Explore our curated collection of chic dresses and stylish
                        bags. Elevate your wardrobe with timeless pieces designed to enhance your style effortlessly.
                    </p>
                </div>
                <div class="welcome-form-con">
                    <form action="{{ route('login.user') }}" method="POST">
                        @csrf
                        <div class="field-con">
                            <i class="bi bi-person"></i>
                            <input type="text" name="email"
                                value="{{ !empty(old('email')) ? old('email') : null }}" class="form-control"
                                placeholder="Username" required>
                        </div>
                        <div class="field-con password-toggle">
                            <i class="bi bi-key"></i>
                            <input type="password" name="password" id="authPassword" class="form-control"
                                placeholder="Password" required>
                            <i class="bi bi-eye-slash" id="toggle-password"></i>
                        </div>
                        <div class="btn-con">
                            <button type="submit" class="dark">Login</button>
                        </div>
                    </form>
                </div>
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
        });
    </script>
</body>

</html>

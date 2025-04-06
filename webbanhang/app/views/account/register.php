<?php include 'app/views/shares/header.php'; ?>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <form action="/webbanhang/account/save" method="post">
                            <!-- Tiêu đề và mô tả -->
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Sign Up</h2>
                                <p class="text-white-50 mb-5">Please enter your details to register!</p>
                                
                                <!-- Tên người dùng -->
                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="username" class="form-control form-control-lg" />
                                    <label class="form-label" for="username">UserName</label>
                                </div>
                                
                                <!-- Họ tên -->
                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="fullname" class="form-control form-control-lg" />
                                    <label class="form-label" for="fullname">Full Name</label>
                                </div>
                                
                                <!-- Mật khẩu -->
                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="password" class="form-control form-control-lg" />
                                    <label class="form-label" for="password">Password</label>
                                </div>

                                <!-- Xác nhận mật khẩu -->
                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="confirmpassword" class="form-control form-control-lg" />
                                    <label class="form-label" for="confirmpassword">Confirm Password</label>
                                </div>
                                
                                <!-- Nút đăng ký -->
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Register</button>

                                <!-- Liên kết đến login -->
                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <p class="mb-0 text-white-50">Already have an account? <a href="/webbanhang/account/login" class="text-white-50 fw-bold">Login</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>

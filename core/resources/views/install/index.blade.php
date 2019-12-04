<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>اسکریپت فرم پرداخت پِی</title>
    <link rel="stylesheet" href="{{ asset('assets/css/install.css') }}">
</head>
<body>
<div id="app">
    <div class="container">
        <header class="navbar">
            <section class="navbar-section">
                <a href="https://formpardakht.com" class="navbar-brand mr-2" target="_blank">اسکریپت فرم پرداخت پِی</a>
            </section>
            <section class="navbar-section">
                <a href="https://formpardakht.com/blog/help-v3" class="btn btn-link" target="_blank">راهنمای نصب</a>
            </section>
        </header>
    </div>
    <div class="container">
        <div class="columns">
            <div class="column col-3"></div>
            <div class="column col-6">
                <form method="post" id="form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title h5">نصب آسان</div>
                        </div>
                        <div class="card-body">
                            <div id="message">
                                @if (isset($errors) && count($errors) > 0)
                                    <div class="toast toast-error mb-2">
                                        {{ $errors->first() }}
                                    </div>
                                @endif
                            </div>
                            <div class="columns mt-2">
                                <div class="column col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="txt-url">آدرس سایت</label>
                                        <input class="form-input ltr" type="text" id="txt-url" placeholder="http://" name="site_url" value="{{ old('site_url') }}">
                                    </div>
                                </div>
                                <div class="column col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="txt-title">عنوان سایت</label>
                                        <input class="form-input" type="text" id="txt-title" name="site_title" value="{{ old('site_title') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="columns mt-2">
                                <div class="column col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="txt-db-host">آدرس دیتابیس</label>
                                        <input class="form-input ltr" type="text" id="txt-db-host" name="db_host" value="{{ old('db_host') }}">
                                    </div>
                                </div>
                                <div class="column col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="txt-db-name">نام دیتابیس</label>
                                        <input class="form-input ltr" type="text" id="txt-db-name" name="db_name" value="{{ old('db_name') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="columns mt-2">
                                <div class="column col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="txt-db-username">نام کاربری دیتابیس</label>
                                        <input class="form-input ltr" type="text" id="txt-db-username" name="db_username" value="{{ old('db_username') }}">
                                    </div>
                                </div>
                                <div class="column col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="txt-db-password">کلمه عبور دیتابیس</label>
                                        <input class="form-input ltr" type="text" id="txt-db-password" name="db_password" value="{{ old('db_password') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="txt-admin-email">آدرس ایمیل مدیر سایت</label>
                                        <input class="form-input ltr" type="text" id="txt-admin-email" name="admin_email" value="{{ old('admin_email') }}">
                                    </div>
                                </div>
                                <div class="column col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="txt-admin-password">کلمه عبور مدیر سایت</label>
                                        <input class="form-input ltr" type="password" id="txt-admin-password" name="admin_password" value="{{ old('admin_password') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button id="btn-submit" type="submit" class="btn btn-primary" name="install" onclick="submitForm()">شروع نصب</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="column col-3"></div>
        </div>
    </div>
</div>
<script>
    function submitForm() {
        document.getElementById('btn-submit').disabled = true;
        document.getElementById('btn-submit').innerText = 'لطفا صبر کنید...';
        document.getElementById('message').innerHTML = "<div class='toast toast-primary mb-2'>اسکریپت در حال نصب می باشد. عملیات نصب ممکن است چند دقیقه طول بکشد.</div>";
        document.getElementById('form').submit();
    }
</script>
</body>
</html>
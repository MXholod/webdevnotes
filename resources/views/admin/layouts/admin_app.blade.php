<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('admin.layouts.admin_app_head')
<body>
    <div class="wd-admin-wrapper" id="app_main_admin">
        <div class="container wd-admin-all_content">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 wd-admin-header">
                    @include('admin.layouts.admin_app_header')
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3 wd-admin-sidebar">
                    @include('admin.layouts.admin_app_sidebar')
                </div>
                <main class="col-12 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    @yield('content')
                </main>
            </div>
        </div>
        @include('admin.layouts.admin_app_footer')
    </div>
</body>
</html>

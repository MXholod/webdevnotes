<!-- Fonts -->
<link rel="dns-prefetch" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
<!-- Favicon favicon.ico -->
<!--<link rel="shortcut icon" type="image/x-icon" sizes="16x16" href="{{ asset('/admin/images/favicon.ico') }}">-->
<!-- Styles -->
<link href="{{ asset('css/admin/app_admin.css') }}" rel="stylesheet">
{{-- Blade directive, we may push some 'styles' from another template
    @push('webdev_styles')
        <link rel="stylesheet" href="/admin/css/lib/some.css" />
    @endpush
--}}
@stack("webdev_styles")
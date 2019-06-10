<!-- Fonts -->
<link rel="dns-prefetch" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
<!-- Favicons -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicons/favicon.ico') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/favicon180x180.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon16x16.png') }}">
<!-- Styles -->
<link href="{{ asset('css/admin/app_admin.css') }}" rel="stylesheet">
{{-- Blade directive, we may push some 'styles' from another template
    @push('webdev_styles')
        <link rel="stylesheet" href="/admin/css/lib/some.css" />
    @endpush
--}}
@stack("webdev_styles")
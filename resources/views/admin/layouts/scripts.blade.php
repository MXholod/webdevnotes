<!-- Scripts -->
<script src="{{ asset('js/app_main_admin.js') }}" defer></script>
<script src="{{ asset('js/admin/app_admin.js') }}" defer></script>
{{-- Blade directive, we may push some 'scripts' from another template
    @push('webdev_scripts')
        <script src="/admin/js/lib/some.js"></script>
    @endpush
--}}
@stack("webdev_scripts")

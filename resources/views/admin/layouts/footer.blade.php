
</div>


</div>
<!-- END Wrapper -->

<!-- Vendor Javascript (Require in all Page) -->
<script src="{{asset('assets/admin/js/vendor.js')}}"></script>

<!-- App Javascript (Require in all Page) -->
<script src="{{asset('assets/admin/js/app.js')}}"></script>

<!-- Vector Map Js -->
{{--<script src="{{asset('assets/admin/vendor/jsvectormap/js/jsvectormap.min.js')}}"></script>--}}
{{--<script src="{{asset('assets/admin/vendor/jsvectormap/maps/world-merc.js')}}"></script>--}}
{{--<script src="{{asset('assets/admin/vendor/jsvectormap/maps/world.js')}}"></script>--}}

<!-- Dashboard Js -->
<script src="{{asset('assets/admin/js/pages/dashboard.js')}}"></script>
@toastifyJs
<script src="https://unpkg.com/toastify-js@1.12.0/src/toastify.js"></script>
@yield('js')
</body>
</html>

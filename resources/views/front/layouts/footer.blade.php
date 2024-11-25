<!-----------/////////////// Start Footer  ////////////////////-------->

<footer class="main_footer">
    <div class="data">
        <div>
            <a href="{{url('user/dashboard')}}" class="{{ Request::is('user/dashboard') ? 'active_link' : '' }}">
                <i class="bi bi-house-door-fill"></i>
            </a>
        </div>
        <div>
            <a href="{{url('user/plans')}}"  class="{{ Request::is('user/plans') ? 'active_link' : '' }}">
                <i class="bi bi-file-spreadsheet-fill"></i>
            </a>
        </div>
        <div>
            <a href="{{url('user/user_plans')}}"  class="{{ Request::is('user/user_plans') ? 'active_link' : '' }}">
                <i class="bi bi-substack"></i>
            </a>
        </div>
        <div>
            <a href="{{url('user/details')}}"  class="{{ Request::is('user/details') ? 'active_link' : '' }}" >
                <i class="bi bi-person-circle"></i>
            </a>
        </div>
        <div>
            <a href="{{url('user/withdraws')}}" class="{{ Request::is('user/withdraws') ? 'active_link' : '' }}">
                <i class="bi bi-cash-coin"></i>
            </a>
        </div>
        <div>
            <a href="{{url('user/exchange')}}" class="{{ Request::is('user/exchange') ? 'active_link' : '' }}">
                <i class="bi bi-ticket-fill"></i>
            </a>
        </div>
        <div>
            <a href="{{url('user/storage')}}" class="{{ Request::is('user/exchange') ? 'active_link' : '' }}">
                <i class="bi bi-ticket-fill"></i>
                storage
            </a>
        </div>
    </div>
</footer>

<!-- ///////////////////////// End Footer ////////// -->
</div>
</div>
<!-- END Wrapper -->

<!-- Vendor Javascript (Require in all Page) -->
<script src="{{asset('assets/front/js/vendor.js')}}"></script>

<!-- App Javascript (Require in all Page) -->
<script src="{{asset('assets/front/js/app.js')}}"></script>

<!-- Vector Map Js -->
{{--<script src="{{asset('assets/admin/vendor/jsvectormap/js/jsvectormap.min.js')}}"></script>--}}
{{--<script src="{{asset('assets/admin/vendor/jsvectormap/maps/world-merc.js')}}"></script>--}}
{{--<script src="{{asset('assets/admin/vendor/jsvectormap/maps/world.js')}}"></script>--}}

<!-- Dashboard Js -->
<script src="{{asset('assets/front/js/pages/dashboard.js')}}"></script>
@toastifyJs
@yield('js')
</body>
</html>

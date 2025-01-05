<!-----------/////////////// Start Footer  ////////////////////-------->

<footer class="main_footer">
    <div class="data">
        <div>
            <a href="{{url('user/dashboard')}}" class="{{ Request::is('user/dashboard') ? 'active_link' : '' }}">
                {{-- <i class="bi bi-house-door-fill"></i> --}}
                <img src="{{ asset('assets/front/images/1.png') }}" alt="">
            </a>
        </div>
        {{-- <div>
            <a href="{{url('user/plans')}}"  class="{{ Request::is('user/plans') ? 'active_link' : '' }}">
                <img src="{{ asset('assets/front/images/2.png') }}" alt="">
            </a>
        </div> --}}
        <div>
            <a href="{{url('user/user_plans')}}"  class="{{ Request::is('user/user_plans') ? 'active_link' : '' }}">
                {{-- <i class="bi bi-substack"></i> --}}

                <img src="{{ asset('assets/front/images/5.png') }}" alt="">
            </a>
        </div>
        <div>
            <a href="{{url('user/profile')}}"  class="{{ Request::is('user/profile') ? 'active_link' : '' }}" >
                <i class="bi bi-person-circle"></i>
                {{-- <img src="{{ asset('assets/front/images/4.png') }}" alt=""> --}}
            </a>
        </div>
        <div>
            <a href="{{url('user/withdraws')}}" class="{{ Request::is('user/withdraws') ? 'active_link' : '' }}">
                {{-- <i class="bi bi-cash-coin"></i> --}}

                <img src="{{ asset('assets/front/images/3.png') }}" alt="">
            </a>
        </div>
        <div>
            <a href="{{url('user/exchange')}}" class="{{ Request::is('user/exchange') ? 'active_link' : '' }}">
                {{-- <i class="bi bi-ticket-fill"></i> --}}
                <img src="{{ asset('assets/front/images/4.png') }}" alt="">
            </a>
        </div>
        <div>
            <a href="{{url('user/storage')}}" class="{{ Request::is('user/storage') ? 'active_link' : '' }}">
                <i class="bi bi-ticket-fill"></i>
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
{!! NoCaptcha::renderJs() !!}
</body>
</html>

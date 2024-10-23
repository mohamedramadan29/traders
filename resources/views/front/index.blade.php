@extends('front.layouts.master')
@section('title')
    الرئيسية
@endsection

@section('content')
    <div class="plans">
        @if (Session::has('Success_message'))
            @php
                toastify()->success(\Illuminate\Support\Facades\Session::get('Success_message'));
            @endphp
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                @php
                    toastify()->error($error);
                @endphp
            @endforeach
        @endif
        <div class="container">
            <div class="row">
                @foreach($plans as $plan)
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h5> {{$plan['name']}} </h5>
                                <h5> {{$plan['current_price']}} $ </h5>
                                @if(\Illuminate\Support\Facades\Auth::check())
                                    <form method="post" action="{{url('user/invoice_create')}}">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{$plan['id']}}">
                                        <button class="btn btn-primary btn-sm" type="submit">  اشترك الان </button>
                                    </form>
                                @else
                                    <a class="btn btn-primary btn-sm" href="{{route('user_login')}}">  اشترك الان  </a>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

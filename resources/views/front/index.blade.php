@extends('front.layouts.master')
@section('title')
    الرئيسية
@endsection

@section('content')
    <div class="plans">
        <div class="container">
            <div class="row">
                @foreach($plans as $plan)
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h5> {{$plan['name']}} </h5>
                                <h5> {{$plan['current_price']}} $ </h5>
                                @if(\Illuminate\Support\Facades\Auth::check())
                                    <a class="btn btn-primary btn-sm" href="#">  اشترك الان  </a>
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

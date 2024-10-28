@extends('front.layouts.master')
@section('title')
    الرئيسية
@endsection

@section('content')
    <div class="page_content main_page">

        <div class="hero_section" style="background-image: url({{asset('assets/uploads/background.jpg')}})">
            <div class="container">
                <div class="data">
                    <div class="row">
                        <div class="col-lg-8 col-12">
                            <h4 class="hero_title1"> الاستثمار </h4>
                            <p class="hero_title2"> أصبح أفضل الآن </p>
                            <p class="hero_desc">
                                <span> Binveste </span>
                                فريق من الخبراء يتداولون نيابه عنك لتحقيق اقصى قدر من العائدات.
                                <br>
                                اصول , eo,ex,Qx,px.
                            </p>
                            <a class="btn btn-global_button" href="#"> تداول الان  </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="how_work">
            <div class="container">
                <div class="data">
                    <h2> كيف يعمل </h2>
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="info">
                                <div class="icon_head">
                                    <i class="bi bi-cash"></i>
                                    <h6> إيداع </h6>
                                </div>
                                <div class="desc">
                                    <p> أفتح حسابا حقيقا وأضف الامول وابدأ الاستثمار </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info">
                                <div class="icon_head">
                                    <i class="bi bi-check2-circle"></i>
                                    <h6> أختر خطه التداول </h6>
                                </div>
                                <div class="desc">
                                    <p> اختر خطك من بين أكثر من100+خطه التي تبدأ ب10دولار فقط . </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info">
                                <div class="icon_head">
                                    <i class="bi bi-graph-up"></i>
                                    <h6> مراقبه أداء استثمارك  </h6>
                                </div>
                                <div class="desc">
                                    <p> راقب الاداء من خلال لوحه التكم الخاصه بك  </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info">
                                <div class="icon_head">
                                    <i class="bi bi-currency-exchange"></i>
                                    <h6> سحب الارباح  </h6>
                                </div>
                                <div class="desc">
                                    <p>بشكل يومي يمكنك سحب ارباح استثماراتك دون قيود و دون حد للسحب اليومي .  </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="certificate">
            <div class="container">
               <div class="data">
                   <div class="row">
                       <div class="col-lg-6 col-12">
                           <div class="info">
                               <div class="icon_head">
                                   <i class="bi bi-patch-check-fill"></i>
                                   <h2> موثوق </h2>
                               </div>
                                <ul class="list-unstyled">
                                    <li> <i class="bi bi-check">  </i> ضمان سحب الارباح اليوميه  </li>
                                    <li> <i class="bi bi-check"></i>ضمان رأس المال    </li>
                                </ul>
                           </div>
                       </div>
                       <div class="col-lg-6 col-12">
                           <div class="info info2">
                               <div class="icon_head">
                                   <i class="bi bi-currency-exchange"></i>
                                   <h2> أفضل منصه أستثمار   </h2>
                               </div>
                               <div class="desc">
                                   <p> احترافيه عاليه  فريق من الخبراء يتداولون نيابه عنك لتحقيق اقصى قدر من العائدات
                                   </p>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

            </div>
        </div>

        <div class="how_work grantee">
            <div class="container">
                <div class="data">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="info">

                                <div class="desc">
                                    <p>  <span> 10 $ </span> الحد الادنى للايداع   </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info">
                                <div class="desc">
                                    <p>  <span> 0%   </span>  عموله  </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info">
                                <div class="desc">
                                    <p>  <span> 0% </span> رسوم  </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info">
                                <div class="desc">
                                    <p>  ضمان رأس المال  </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="last_footer">
            <div class="container">
                <div class="data">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="info">
                                <img style="width: 60px" src="https://ar.eobroker.com/img/logos/EOBroker/eo-logo.svg">
                                <p> ينطوي التداول والاستثمار على مستوى كبير من المخاطر وهو غير مناسب و/أو مناسب لجميع العملاء. يرجى التأكد من أنك تدرس بعناية أهدافك الاستثمارية ومستوى خبرتك ورغبتك في المخاطرة قبل الشراء أو البيع. ينطوي الشراء أو البيع على مخاطر مالية وقد يؤدي إلى خسارة جزئية أو كاملة لأموالك </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info">
                                <h4> منصات التداول  </h4>
                                <img src="{{asset('assets/uploads/partners.svg')}}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info">
                                <h4> طرق الايداع  </h4>
                                <img src="{{asset('assets/uploads/payments.svg')}}" alt="">
                            </div>

                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info">
                                <h4> طرق السحب  </h4>
                                <img src="{{asset('assets/uploads/payments.svg')}}" alt="">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="copy_right">
                <p>  جميع الحقوق محفوظة @ 2024 لدي <span> Binveste </span> </p>
            </div>
        </div>
    </div>
@endsection

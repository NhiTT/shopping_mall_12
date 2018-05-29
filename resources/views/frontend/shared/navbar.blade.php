<!--top-header-->
<div class="top-header">
    <div class="container">
        <div class="top-header-main">
            <div class="col-md-6 top-header-left">
                <div class="drop">
                    <div class="box">
                        <select tabindex="4" class="dropdown drop">
                            <option value="" class="label">Dollar :</option>
                            <option value="1">Dollar</option>
                            <option value="2">VND</option>
                        </select>
                    </div>
                    <div class="box1">
                        <select tabindex="4" class="dropdown">
                            <option value="" class="label">English :</option>
                            <option value="1">English</option>
                            <option value="2">VietNam</option>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-6 top-header-left">
                <ul class="top-headercart">
                    <li class="dropdown">
                        @guest
                        <li><a href="#">{{ __('Register') }}</a></li>
                        <li><a href="#">{{ __('Login') }}</a></li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                            <ul class="dropdown-menu">
                                @if (Auth::check()) @role('manager')
                                <li><a href="/admin">{{ __('Admin') }}</a></li>
                                @endrole

                                <li>
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                    <form id="logout-form" action="#" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                                @endif

                            </ul>
                        </li>
                        @endguest
                        <ul class="dropdown-menu" role="menu">
                            <!-- Authentication Links -->
                        </ul>
                    </li>

                    <li>
                        <div class="cart ">
                            <!-- box_1 -->
                            <a href="/checkout">
                                <div class="total">
                                    <span class="simpleCart_total"></span></div>
                                <img src="{{ asset('images/cart-1.png') }}" alt="" />
                            </a>
                            <p><a href="javascript:;" class="simpleCart_empty">{{ __('Empty Cart') }}</a></p>
                            <div class="clearfix"> </div>
                        </div>
                    </li>
                </ul>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--top-header-->
<!--start-logo-->
<div class="logo">
    <a href="/"><h1>{{ __('Luxury Furniture') }}</h1></a>

</div>
<!--start-logo-->
<!--bottom-header-->
<div class="header-bottom">
    <div class="container">
        <div class="header">
            <div class="col-md-9 header-left">
                <div class="top-nav">
                    <ul class="memenu skyblue">
                        <li class="active"><a href="/">{{ __('Home') }}</a></li>
                        <li class="grid"><a href="#">{{ __('Product Categories') }}</a>
                            <div class="mepanel">
                                <div class="row">
                                    <div class="col1 me-one">
                                        <h4>Noi that phong khach</h4>
                                        <ul>
                                            <li>
                                                <a href="#"></a>
                                            </li>
                                            <li>
                                                <a href="#"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col1 me-one">
                                        <h4>Noi that phong an</h4>
                                        <ul>
                                            <li>
                                                <a href="#"></a>
                                            </li>
                                            <li>
                                                <a href="#"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col1 me-one">
                                        <h4>Noi that phong ngu</h4>
                                        <ul>
                                            <li>
                                                <a href="#"></a>
                                            </li>
                                            <li>
                                                <a href="#"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="grid"><a href="#">{{ __('Promotions') }}</a>
                            <div class="mepanel">
                                <div class="row">
                                    <div class="col1 me-one">
                                        <h4>Voucher</h4>
                                        <ul>
                                            <li>
                                                <a href="#"></a>
                                            </li>
                                            <li>
                                                <a href="#"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col1 me-one">
                                        <h4>Sale</h4>
                                        <ul>
                                            <li>
                                                <a href="#"></a>
                                            </li>
                                            <li>
                                                <a href="#"></a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </li>
                        <li class="grid"><a href="/post">{{ __('Blog') }}</a>
                        </li>
                        <li class="grid"><a href="/contact">{{ __('Contact') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"> </div>
            </div>
            <div class="col-md-3 header-right">
                <div class="search-bar">
                    <input type="text" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}">
                    <input type="submit" value="">
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
</div>
<!--bottom-header-->

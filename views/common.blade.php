<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('pagetitle')</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css" type="text/css">
    
    {!! Html::style('/css/styles.css') !!}
    @yield('css')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
     <nav class="navbar navbar-default navbar-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="/">@yield('pagename')</a>
        
        {{-- login/register dropdown --}}
          @guest
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                  <li class="{{ Request::is('products') || Request::is('product') ? "active" : "" }}"><a href="/products">Products</a></li>
                  <li class="{{ Request::is('cart/*') || Request::is('cart') ? "active" : "" }}"><a href="/cart">Cart</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <button class="btn hello-btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Hello! <span class="caret">
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          @else
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                      <li class="{{ Request::is('products') || Request::is('products') ? "active" : "" }}"><a href="/products">Products</a></li>
                      <li class="{{ Request::is('categories/*') || Request::is('categories') ? "active" : "" }}"><a href="/categories">Categories</a></li>
                      <li class="{{ Request::is('items/*') || Request::is('items') ? "active" : "" }}"><a href="/items">Items</a></li>
                      <li class="{{ Request::is('cart') || Request::is('cart') ? "active" : "" }}"><a href="/cart">Cart</a></li>
                      <li class="{{ Request::is('orders/*') || Request::is('orders') ? "active" : "" }}"><a href="/orders">Orders</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                      <button class="btn hello-btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </li>
                      </ul>
                    </li>
                  </ul>
              </div><!-- /.navbar-collapse -->
          @endguest
        
      </div><!-- /.container-fluid -->
    </nav> 
    <div class="row" id='main'>
      <div class="container">
          @include('partials._messages')

          @yield('content')
      </div> <!-- .container -->
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script> 

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    @yield('scripts')
  </body>
</html>
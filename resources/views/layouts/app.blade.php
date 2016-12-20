<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <script src="/js/app.js"></script><!--spostato da giù-->

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li>&nbsp;</li>
                        <li></li>
                        <li></li> 
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    
                                    @if (Auth::user()->isAdmin())
                                        <?php $ruolo = 'Amministratore' ?>
                                    @else
                                        <?php $ruolo = 'Autore' ?> 
                                    @endif

                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} ( {{ $ruolo }} ) <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('backend/myprofile') }}">
                                            Profilo
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>


        {{-- messaggi passati dal relativo controller --}}
        @if(Session::has('error_message'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <center>{!! Session::get('error_message') !!}</center>
            </div>
        @endif

        @if(Session::has('success_message'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <center>{!! Session::get('success_message') !!}</center>
            </div>
        @endif


        @yield('content')

    </div>

    <!-- Scripts -->
    <!--<script src="/js/app.js"></script>-->


    <!-- librerie css/js/jQuery tinymce e select2 (jQuery plugin) per text editor e categories multiple select-->
    <!--<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="http://cdn.tinymce.com/4/tinymce.min.js"></script> 

    <script> 
        // tinymce per user friendly text editor - backend -
        tinymce.init({  selector:'textarea#body', 
                        plugins: [], 
                        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image" 
                        // not works link image icon
                    }); 

        // select2 per selez multipla categorie - backend -
        $(document).ready(function(){ 
            $("select#categories").select2({
                placeholder: "Clicca per selezionare una o più categorie",
            }); 
        }); 

    </script>-->



</body>
</html>

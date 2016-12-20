	 
<!DOCTYPE html>

<html lang="en"> 

<head> 
	<meta charset="utf-8" /> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<meta name="description" content="" /> 
	<meta name="author" content="" /> 
	<title>@yield('title') - Larablog</title> 
	<link href="{{ url('assets/frontend/css/bootstrap.min.css') }}" rel="stylesheet" /> 
	<link href="{{ url('assets/frontend/css/clean-blog.min.css') }}" rel="stylesheet" /> 
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> 
	<link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css' /> 
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' /> 
	<!--[if lt IE 9]>  
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"> 
	</script> 
	 
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"> 
	</script>  
	<![endif]--> 
</head> 

<body> 
	<nav class="navbar navbar-default navbar-custom navbar-fixed-top"> 
		<div class="container-fluid">  
			<div class="navbar-header page-scroll"> 
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">  
					<span class="sr-only">Toggle navigation</span>  
					<span class="icon-bar"></span>  
					<span class="icon-bar"></span>  
					<span class="icon-bar"></span>  
				</button> 

				<a class="navbar-brand" href="{{ url('/') }}">Larablog</a>  
			</div> 

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">  
				<ul class="nav navbar-nav navbar-right">  
					<li>  
						<a href="{{ url('/') }}">Home</a>  
					</li> 

					@foreach($categories as $category) 

					<li>  
						<a href="{{ url('categoria/' . $category->slug) }}">{{ $category->name }}</a>
					</li> 

					@endforeach 

					@if (Auth::check()) 

						<li>
							<a style="color:red;" href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                            	{{ Auth::user()->first_name }}, Logout
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
						</li>
						<br>
						<li style="position: absolute; right: 0; margin: 15px;" >
							<a style="color: red; padding: 5px;" href="{{ url('/backend') }}">Backend</a>
						</li>

					@else 

						<li>
							<a href="{{ url('/login') }}">Login</a>
						</li>

						<li>
							<a href="{{ url('register') }}">Registrati</a>
						</li>

					@endif
				</ul>  
			</div>

		</div> 

	</nav> 

	<header class="intro-header" style="background-image: url('{{ url('assets/frontend/background-image/home-bg.jpg') }}')"> 
		<div class="container"> 

			<div class="row"> 

				<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1"> 

					<div class="site-heading"> 

						<h1>Larablog</h1> 

						<hr class="small"> 

						<span class="subheading">@yield('subheading')</span> 

					</div> 

				</div> 

			</div> 

		</div> 

	</header> 


	<div class="container">  

		<div class="row">  

			<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1"> @yield('content') </div>  
		</div>  
	</div>  
	<hr />  
	<footer>  

		<div class="container">  

			<div class="row">  

				<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">  
					<ul class="list-inline text-center">  
						<li>  
							<a href="#">  
								<span class="fa-stack fa-lg">  
									<i class="fa fa-circle fa-stack-2x"> 
									</i>  
									<i class="fa fa-twitter fa-stack-1x fa-inverse"> 
									</i>  
								</span>  
							</a>  
						</li>  
						<li>  
							<a href="#">

								<span class="fa-stack fa-lg">  
									<i class="fa fa-circle fa-stack-2x"> 
									</i>  
									<i class="fa fa-facebook fa-stack-1x fa-inverse"> 
									</i>  
								</span>  
							</a>  
						</li>  
						<li>  
							<a href="#">  
								<span class="fa-stack fa-lg">  
									<i class="fa fa-circle fa-stack-2x"></i>  
									<i class="fa fa-github fa-stack-1x fa-inverse"></i>  
								</span>  
							</a>  
						</li>  
					</ul>  
					<p class="copyright text-muted">Right to Copy ©</p>  
				</div>  
			</div>  
		</div>  
	</footer>
	{{-- <script src="{{ url('assets/frontend/js/jquery.js') }}"></script> --}}
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>  
	<script src="{{ url('assets/frontend/js/bootstrap.min.js') }}"></script>  
	<script src="{{ url('assets/frontend/js/clean-blog.min.js') }}"></script> 
</body>  
</html>
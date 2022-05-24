<!-- autor: Nikola Mitic -->
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

        <title>MovieLibrary</title>
		<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('css/library_style.css') }}">
		
	</head>
	<body>
		<div class="container">
			<div class="row">
				<nav id='menu'>
					<a class="logo" href="/index">𝑀𝑜𝓋𝒾𝑒𝐿𝒾𝒷𝓇𝒶𝓇𝓎</a>
					<form id="search" action="/search">
						<input type="text" class="search" placeholder="Pretraga.." name="naziv">
						<button type="submit" class="search"><i class="fa fa-search"></i></button>
					</form>
					<ul>
						@guest
							<li class="account"><a href="{{route('register')}}">Registruj se</a></li>
							<li class="account"><a href="{{route('login')}}">Prijavi se</a></li>
						@endguest
						@auth
							<li class="account"><a href={{route('profile', ['id' => auth()->user()->idKorisnik])}}>&#91;{{auth()->user()->Ime}}&#93;</a></li>
							<li class="account"><a href="{{route('logout')}}">Odjavi se</a></li>
						@endauth
					</ul>
				</nav>
			</div>
	
			@yield('content')
		</div>
	</body>
</html>

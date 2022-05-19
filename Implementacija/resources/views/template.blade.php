<!-- autor: Nikola Mitic -->
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>MovieLibrary</title>
		<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
	</head>
	<body>
		<nav id='menu'>
			<a class="logo" href="index">𝑀𝑜𝓋𝒾𝑒𝐿𝒾𝒷𝓇𝒶𝓇𝓎</a>
			<form id="search" action="search">
				<input type="text" class="search" placeholder="Pretraga.." name="naziv">
				<button type="submit" class="search"><i class="fa fa-search"></i></button>
			</form>
			<ul>
				<li class="account"><a href="register">Registruj se</a></li>
				<li class="account"><a href="login">Prijavi se</a></li>
			</ul>
		</nav>
		<br>
		@yield('content')

	</body>
</html>

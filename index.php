<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	$is_katemiz = false;

	$params = array('MHA-L29','Linux x86_64');

	foreach ($params as $param) {
		if ( strpos($_SERVER['HTTP_USER_AGENT'], $param) ) {
			$is_katemiz = true;
		}
	}

	if ( !$is_katemiz ) {
		echo 'Oops ...';
		return true;
	}
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<link rel="icon" type="image/svg+xml" href="/Auth/img/favicon.svg" />

		<title>Films</title>
		<meta name="keywords" content="Personal Db">
		<meta name="description" content="Nothing is free">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Cache-control" content="public">

		<link rel="stylesheet" href="/Common/css/bulma.min.css">
		<script src="/Common/libs/sweetalert2.all.min.js"></script>
		<script src="/Films/js/appicons.js"></script>
		<script type="module" src="/Films/js/films.js"></script>

		<style>
			.hero.has-background {
				position: relative;
				overflow: hidden;
			}
			.hero-background {
				position: absolute;
				object-fit: cover;
				object-position: center center;
				width: 100%;
				height: 100%;
			}
			.hero-background.is-transparent {
				opacity: 0.3;
			}
		</style>

		<script>

			let is_active = false

			function BurgerMenu () {

				is_active = !is_active

				if (is_active) {
					document.getElementById("nav-toggle").classList.add("is-active")
				} else {
					document.getElementById("nav-toggle").classList.remove("is-active")
				}
			}

		</script>
	</head>


	<body>

		<section class="hero is-medium is-dark has-background">

			<img alt="Elisabeth Trissenaar" class="hero-background is-transparent" src="./img/AnnaKarina.jpg">

			<nav class="navbar is-transparent">

				<div class="navbar-brand">
					<a class="navbar-item has-text-white" href="/">
						<img src="/Auth/img/favicon.svg" alt="Portakal Baykus" height="64">
					</a>

					<a role="button" class="navbar-burger" data-target="navbar_ana" aria-label="menu" aria-expanded="false" id="nav-toggle">
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
					</a>
				</div>

				<div id="navbar_ana" class="navbar-menu">
					<div class="navbar-end" id="navbarend">
						<div class="navbar-item">
							<a class="navbar-item has-text-weight-light" id="topLink1">${Icon("movie","S","light")} All Movies</a>
							<a class="navbar-item has-text-weight-light" id="topLink2">${Icon("refresh","S","light")} Refresh</a>
							<a class="navbar-item has-text-weight-light" id="topLink3">${Icon("add","S","light")} Add</a>
						</div>
					</div>
				</div>

			</nav>

			<div class="hero-body">
				<p class="title">Films</p>
				<p class="subtitle has-text-weight-light">a personal list</p>
			</div>

		</section>

		<section class="section default">

			<div class="columns is-mobile">
				<div class="column is-half is-offset-one-quarter">
					<div class="field has-addons">
						<div class="control is-right is-expanded">
							<input id="query" class="input is-fullwidth has-text-weight-light" type="text" placeholder="Keyword ...">
						</div>
						<div class="control">
							<a class="button is-info" id="search_button"></a>
						</div>
					</div>
				</div>
			</div>
			
		</section>

		<section class="section default" id="arena"></section>













		<div class="modal" id="addmodal">
			<div class="modal-background" id="mod111"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">New Movie to Add</p>
					<button class="delete" aria-label="close" id="mod112"></button>
				</header>
				<section class="modal-card-body">
					<h2 class="title" id="newfilename"></h2>
					<div class="field">
						<label class="label">Imdb No</label>
						<div class="control">
							<input class="input" type="text" placeholder="Text input" id="imdbNo">
						</div>
					</div>
				</section>
				<footer class="modal-card-foot">
					<button class="button is-success" id="continueButton">Continue</button>
					<button class="button" id="mod113">Cancel</button>
				</footer>
			</div>
		</div>











        <footer class="footer" id="footer">
            <div class="container">
                <div class="columns">
                    <div class="column is-4 has-text-weight-light is-full-mobile has-text-centered-mobile is-size-7-mobile">kapkara<br>Terms and Conditions</div>
                    <div class="column is-4 has-text-centered is-full-mobile has-text-weight-bold is-size-6-mobile">My Personal Films</div>
                    <div class="column is-4 has-text-right has-text-centered-mobile is-full-mobile is-size-7-mobile">
                        V2021.4
                        <div class="has-text-weight-light is-full-mobile is-size-7-mobile has-text-success-dark">© 2021 All Rights Reserved</div>
                    </div>
                </div>
                <div class="column is-2 is-offset-5 is-offset-2-mobile is-8-mobile">
                    <figure class="image pt-2">
                        <img src="/Films/img/kapkara_safe.svg" alt="logo">
                    </figure>
                </div>
            </div>
        </footer>

	</body>
</html>
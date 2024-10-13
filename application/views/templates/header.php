<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=$page_title?></title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

		<!-- google font -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+KR:wght@300;400;500;600;700&display=swap" rel="stylesheet">
		<!-- font awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

		<!-- bootstrap for monthpicker, datepicker -->
		<link rel="stylesheet" href="/include/bootstrap/bootstrap-datepicker.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-D5/oUZrMTZE/y4ldsD6UOeuPR4lwjLnfNMWkjC0pffPTCVlqzcHTNvkn3dhL7C0gYifHQJAIrRTASbMvLmpEug==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker3.min.css" integrity="sha512-aQb0/doxDGrw/OC7drNaJQkIKFu6eSWnVMAwPN64p6sZKeJ4QCDYL42Rumw2ZtL8DB9f66q4CnLIUnAw28dEbg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<script src="/include/bootstrap/bootstrap.min.js"></script>
		<script src="/include/bootstrap/bootstrap-datepicker.js"></script>
		<script src="/include/bootstrap/bootstrap-datepicker.ko.js"></script>		

		<style>
			html, body {font-family:'Noto Sans KR', sans-serif;height:100%;}
			body.has-navbar-fixed-top, html.has-navbar-fixed-top {padding-top:5.25rem;}
			body.dashboard {background-color:rgb(45, 45, 45);}

			header {}
			.navbar {}
			.navbar-brand .navbar-item b {font-family:'Archivo Black';font-weight:900;color:rgb(0, 113, 193);}
			.navbar-menu .navbar-item,
			.navbar-menu .navbar-link {font-weight:500;color:rgb(64, 84, 84);}
			.navbar-link:not(.is-arrowless)::after {
				width:8px;
				height:8px;
				border-left:4px solid rgb(64, 84, 84);;
				border-bottom:4px solid rgb(64, 84, 84);;
				border-right:4px solid transparent;
				border-top:4px solid transparent;
			}
			.navbar-end .navbar-item a.button.login {background-color:rgb(0, 113, 193);color:#ffffff;}
			.navbar-end .navbar-item a.button.logout {background-color:rgb(0, 113, 193);color:#ffffff;}

			.navbar.dashboard {background-color:rgb(45, 45, 45);}
			.navbar.dashboard .navbar-brand .navbar-item b {font-family:'Archivo Black';font-weight:900;color:rgb(255, 192, 50);}
			.navbar.dashboard .navbar-menu .navbar-item,
			.navbar.dashboard .navbar-menu .navbar-link {font-weight:500;color:#888888;}

			.navbar.dashboard .navbar-end .navbar-item a.button.login {background-color:rgb(255, 192, 50);color:#ffffff;}
			.navbar.dashboard .navbar-end .navbar-item a.button.logout {background-color:rgb(255, 192, 50);color:#ffffff;}
		</style>
	</head>
	<body class="has-navbar-fixed-top <?=(isset($page_name) && $page_name == 'dashboard') ? 'dashboard' : ''?>">
		<header>
			<nav class="navbar box is-fixed-top py-2 <?=(isset($page_name) && $page_name == 'dashboard') ? 'dashboard' : ''?>">
				<div class="container">
					<div class="navbar-brand">
						<a class="navbar-item" href="/">
							<b class="is-size-3-desktop is-size-5-tablet is-size-6-mobile">ePunch</b>
						</a>
						<a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar">
							<span aria-hidden="true"></span>
							<span aria-hidden="true"></span>
							<span aria-hidden="true"></span>
						</a>
					</div>

					<?php if ($this->login): ?>
						<?php $this->load->view('templates/nav.php'); ?>
						<div class="navbar-end">
							<div class="navbar-item">
								<div class="buttons">
									<a class="button logout" href="/auth/logout">로그아웃</a>
								</div>
							</div>
						</div>
					<?php else: ?>
						<?php $this->load->view('templates/nav_home.php'); ?>
						<div class="navbar-end">
							<div class="navbar-item">
								<div class="buttons">
									<a class="button login" onclick="openModal('modal-LOGIN');">로그인</a>
								</div>
							</div>
						</div>
					<?php endif ?>

					
				</div>
			</nav>
		</header>
		<script>
			document.addEventListener('DOMContentLoaded', () => {
				// Get all "navbar-burger" elements
				const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
				// Add a click event on each of them
				$navbarBurgers.forEach( el => {
					el.addEventListener('click', () => {
						// Get the target from the "data-target" attribute
						const target = el.dataset.target;
						const $target = document.getElementById(target);
						// Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
						el.classList.toggle('is-active');
						$target.classList.toggle('is-active');
					});
				});

			});
		</script>

		<style>
			.modal .field-label {flex-grow:2;}
		</style>
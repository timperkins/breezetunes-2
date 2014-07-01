<?php
/**
 * The Header for our theme
 */
 
	// if IE<=7
	if(!is_page('browser-not-supported') && preg_match('/(?i)msie [5-7]/',$_SERVER['HTTP_USER_AGENT'])) {
		wp_redirect(get_page_by_path('browser-not-supported')->guid);
	}
?>

<!DOCTYPE html>
<!--[if IE 7 ]>    <html lang="en" class="ie ie7" lang="en-US"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie ie8" lang="en-US"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie ie9" lang="en-US"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="<?php language_attributes(); ?>"> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php wp_title(); ?></title>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body data-page="<?php echo get_queried_object()->post_name; ?>" class="<?php echo 'page-' . get_queried_object()->post_name; ?><?php echo is_mobile() ? "mobile" : "";?>">

	<header>
		<input type="hidden" class="d" value="<?php echo isset($_GET['d']) ? '1' : '0'; ?>" />
		<div class="menu-wrap dark wrap-border">
			<div class="menu hide">
				<div class="menu-inner">
					<a href="#" class="menu-close-btn"><span>CLOSE</span><i class="fa fa-times"></i></a>
					<ul>
						<li class="first">
							<h2>Music</h2>
							<ul>
								<li><a href="/show-choir-arrangements">Show Choir Arrangements</a></li>
								<li><a href="/media-composition">Media Composition</a></li>
								<li><a href="/sacred-music">Sacred Music</a></li>
								<li><a href="https://soundcloud.com/breeze-tunes-productions">Demo Reel</a></li>
							</ul>
						</li>
						<li>
							<h2>Portfolio</h2>
							<ul>
								<li><a href="/discography">Discography</a></li>
								<li><a href="/filmography">Filmography</a></li>
								<li><a href="/show-choir-clients">Show Choir Clients</a></li>
								<li><a href="/stage-productions">Stage Productions</a></li>
								<li><a href="/concert-works">Concert Works</a></li>
								<li><a href="/corporate-media">Corporate Media</a></li>
							</ul>
						</li>
						<li>
							<h2>About</h2>
							<ul>
								<li><a href="/biography">Biography</a></li>
								<li><a href="http://musicarranging.net/">Blog</a></li>
								<li><a href="/contact">Contact Me</a></li>
							</ul>
						</li>
					</ul>
				</div>		
			</div>
		</div>
		<div class="header-wrap dark wrap-border">
			<div class="header">
		
					<a href="/" class="logo"></a>
					<a href="#" class="menu-btn"><span>MENU</span><i class="fa fa-bars fa-lg"></i></a>
			
			</div>
		</div>
	</header>
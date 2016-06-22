<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till #main div
 *
 * @package Odin
 * @since 2.2.0
 */
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( ! get_option( 'site_icon' ) ) : ?>
		<link href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico" rel="shortcut icon" />
	<?php endif; ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php if ( $value = get_theme_mod( 'code_open_body', false ) ) : ?>
		<?php echo html_entity_decode( $value );?>
	<?php endif;?>
	<a id="skippy" class="sr-only sr-only-focusable" href="#content">
		<div class="container">
			<span class="skiplink-text"><?php _e( 'Skip to content', 'odin' ); ?></span>
		</div>
	</a>
	<div class="col-md-12 prices-warn">
		<div class="container">
			<div class="row">
				<div class="col-md-7 pull-left text">
					<?php if ( is_user_logged_in() ) : ?>
						<?php echo get_theme_mod( 'header_warn_logged', '' );?>
					<?php else : ?>
						<?php echo get_theme_mod( 'header_warn_unlogged', '' );?>
					<?php endif;?>
				</div><!-- .col-md-6 pull-left -->
				<div class="col-md-4 pull-right text">
					<?php if ( $value = get_theme_mod( 'phone', false ) ) : ?>
						<i class="fa fa-phone"></i>
						<a class="phone icon"><?php echo apply_filters( 'the_title', $value );?></a>
					<?php endif; ?>
					<?php if ( $value = get_theme_mod( 'whatsapp', false ) ) : ?>
						<i class="fa fa-whatsapp"></i>
						<a class="whatsapp icon"><?php echo apply_filters( 'the_title', $value );?></a>
					<?php endif; ?>
				</div><!-- .col-md-4 pull-right text -->
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .col-md-12 prices-warn -->
	<header id="header" role="banner">
		<div class="container">
			<div class="header-image col-md-4 col-xs-12">
				<?php
					$header_image = get_header_image();
					if ( ! empty( $header_image ) ) :
				?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php echo esc_url( $header_image ); ?>" height="<?php esc_attr_e( $header_image->height ); ?>" width="<?php esc_attr_e( $header_image->width ); ?>" alt="" />
					</a>
				<?php endif; ?>
			</div><!-- .site-header-->
			<div class="col-md-7 col-xs-12 pull-right">
				<div class="col-md-8 col-xs-12 pull-left search-form">
					<?php get_search_form( true );?>
				</div><!-- .col-md-7 pull-left search-form -->
				<div class="col-md-4 col-xs-12 pull-right woocommerce-infos">
					<?php $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );?>
					<?php if ( $myaccount_page ) : ?>
						<a href="<?php echo get_permalink( $myaccount_page );?>" class="myacc"><?php _e( 'minha conta', 'odin');?></a>
						<span class="separator">|</span>
					<?php endif;?>
					<?php if ( function_exists( 'WC' ) ) : ?>
						<a  class="myacc" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-shopping-cart"></i>
							<span class="cart-infos">[<?php echo WC()->cart->get_cart_contents_count();?>]</span>
						</a>
						<?php if ( ! WC()->cart->is_empty() ) : ?>
						<ul class="dropdown-menu cart-dropdown" aria-labelledby="dLabel">
							<div class="col-md-12">
								<div class="col-md-12 title"><?php _e( 'Carrinho', 'odin');?></div><!-- .col-md-12 -->
								<div class="separator"></div><!-- .separator -->
								<?php foreach( WC()->cart->get_cart() as $cart_item ) : ?>
									<?php if ( isset( $cart_item['bundled_by'] ) ) : ?>
										<?php continue;?>
									<?php endif;?>

									<div class="col-md-4 pull-left img">
										<?php if ( has_post_thumbnail( $cart_item['product_id'] ) ) : ?>
											<?php echo get_the_post_thumbnail( $cart_item['product_id'], 'thumbnail', null );?>
										<?php endif;?>
									</div><!-- .col-md-6 pull-left img -->
									<div class="col-md-7 pull-right">
										<div class="post-title">
											<?php echo apply_filters( 'the_title', $cart_item['data']->post->post_title );?>
										</div><!-- .col-md-12 post-title -->
										<div class="qty-infos">
											<?php printf( '%s x %s %s', $cart_item['quantity'], get_woocommerce_currency_symbol(), $cart_item['line_total'] );?>
										</div><!-- .col-md-12 qty-infos -->
									</div><!-- .col-md-6 pull-right -->
									<div class="separator"></div><!-- .separator -->
								<?php endforeach;?>
								<div class="post-title"><?php printf( __( 'Total de itens adicionados: <span>%s</span>', 'odin'), WC()->cart->get_cart_contents_count() );?></div><!-- .post-title -->
								<div class="post-title"><?php printf( __( 'SUBTOTAL: <span>%s</span>', 'odin'), WC()->cart->get_cart_subtotal() );?></div><!-- .post-title -->
								<div class="separator"></div><!-- .separator -->
								<div class="post-title"><?php printf( __( 'TOTAL: <span class="big">%s</span>', 'odin'), WC()->cart->get_cart_total() );?></div><!-- .post-title -->
								<div class="col-md-12 text-center">
									<a href="<?php echo WC()->cart->get_cart_url();?>" class="btn btn-primary btn-large btn-buy"><?php _e( 'Comprar', 'odin' );?></a>
								</div><!-- .col-md-12 text-center -->
							</div><!-- .col-md-12 -->
  						</ul>
  						<?php endif;?>
					<?php endif;?>
				</div><!-- .col-md-4 pull-right -->
			</div><!-- .col-md-6 pull-right -->
			<div class="col-md-6 col-xs-12 pull-right menu-institucional">
				<?php echo wp_nav_menu(
						array(
							'theme_location' => 'institucional',
							'depth'          => 2,
							'container'      => false,
							'menu_class'     => 'nav navbar-nav',
							'fallback_cb'    => 'Odin_Bootstrap_Nav_Walker::fallback',
							'walker'         => new Odin_Bootstrap_Nav_Walker()
						)
					);
				?>
			</div><!-- .col-md-6 pull-right menu-institucional -->

			<div id="main-navigation" class="navbar navbar-default">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-navigation">
					<span class="sr-only"><?php _e( 'Toggle navigation', 'odin' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand visible-xs-block" href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				</div>
				<nav class="collapse navbar-collapse navbar-main-navigation" role="navigation">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'main-menu',
								'depth'          => 2,
								'container'      => false,
								'menu_class'     => 'nav navbar-nav',
								'fallback_cb'    => 'Odin_Bootstrap_Boaterra_Nav_Walker::fallback',
								'walker'         => new Odin_Bootstrap_Boaterra_Nav_Walker()
							)
						);
					?>
				</nav><!-- .navbar-collapse -->
			</div><!-- #main-navigation-->

		</div><!-- .container-->
	</header><!-- #header -->

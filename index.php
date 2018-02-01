<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- start of wp_head() -->
	<?php wp_head(); ?>
	<!-- end of wp_head() -->

</head>
<body <?php body_class(); ?>>

<header class="jumbotron">
	<img src="<?php echo get_template_directory_uri() ?>/assets/img/logo-grey.png" alt="Auth0" width="500">
	<h1>A WordPress theme for testing.</h1>
</header>

<?php
$opts = WP_Auth0_Options::Instance();
?>
<article>
	<h2>Current user</h2>

	<?php if ( get_current_user_id() ) : ?>
		<h3>WP user</h3>
		<pre><?php var_dump( get_user_by( 'id', get_current_user_id() )->data ); ?></pre>
		<?php if ( $auth0_user = get_auth0userinfo( get_current_user_id() ) ) : ?>
			<h3>Auth0 user</h3>
			<pre><?php var_dump( $auth0_user ); ?></pre>
		<?php else : ?>
			<div class="alert alert-warning"><strong>No Auth0 user</strong></div>
		<?php endif; ?>
	<?php else : ?>
		<div class="alert alert-warning"><strong>No current WP session</strong></div>
	<?php endif; ?>

	<h2>Current Auth0 settings</h2>
	<?php if ( ! class_exists( 'WP_Auth0_Options' ) ) : ?>
		<div class="alert alert-warning"><strong>Auth0 is not installed</strong></div>
	<?php else : ?>
		<pre><?php var_dump( $opts->get_options() ); ?></pre>
	<?php endif; ?>

	<h2>Auth0 Client settings</h2>

	<p><strong>Note:</strong> If you're seeing a client ID below but no client information, go to APIs in your <a
			href="https://manage.auth0.com/#/apis" target="_blank">Auth0 dashboard</a>, edit the <strong>Auth0 Management API</strong>, click the <strong>Non Interactive Clients</strong> tab, expand the row for <strong><?php echo get_auth0_curatedBlogName() ?></strong>, and add the <code>read:clients</code> scope. This is not required for the plugin to operate properly, only for the display below.</p>

	<?php if ( ! class_exists( 'WP_Auth0_Api_Client' ) ) : ?>
		<div class="alert alert-warning"><strong>Auth0 is not installed</strong></div>
	<?php elseif ( ! $opts->get( 'client_id' ) ) : ?>
		<div class="alert alert-warning"><strong>Client ID is not saved</strong></div>
	<?php else : ?>
		<h3><strong>Client ID:</strong> <?php echo $opts->get( 'client_id' ) ?></h3>
		<pre><?php
			var_dump( WP_Auth0_Api_Client::get_client(
				WP_Auth0_Api_Client::get_client_token(),
				$opts->get( 'client_id' )
			) );
			?></pre>
	<?php endif; ?>
</article>

<?php get_template_part( 'template-parts/block', 'footer' ) ?>

<!-- START of wp_footer() -->
<?php wp_footer(); ?>
<!-- END of wp_footer() -->
</body>
</html>
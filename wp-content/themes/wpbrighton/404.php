<?php

    @header("HTTP/1.1 404 Not found", true, 404);

    // calling the header.php
    get_header();

	?>

		<div id="container">

			<?php thematic_abovecontent(); ?>

			<div id="content">
	
				<?php thematic_abovepost(); ?>

				<div id="error">
					<h2>Oops! We couldn't find this page for you.</h2>

					<h3>You should try <a href="<?php echo get_option('home'); ?>">our homepage</a> instead.<br/><br />
						You could go back to <a href="javascript:history.go(-1)">where you were</a> or use your back button.</h3>

					<h3>What you were looking for is not here. Might be our fault, too.<br /><br />
						Did you spell the file name correctly?</h3>

					<h3>Feel free to <a href="mailto:<?php echo get_bloginfo('admin_email') ?>">ask the webmasters</a>.</h3>
				</div><!-- #error -->

			</div><!-- #content -->
	
			<?php thematic_belowcontent(); ?> 
	
		</div><!-- #container -->
    
	<?php

    // calling footer.php
    get_footer();

?>
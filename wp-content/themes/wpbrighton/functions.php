<?php
// Custom Child Theme Functions //

// Include Custom Loops & SEO files
include 'customloops.php';

// Set some thematic options
define('THEMATIC_COMPATIBLE_BODY_CLASS', true);
define('THEMATIC_COMPATIBLE_POST_CLASS', true);

// Load Child Theme js file, Google Analytics
function load_childtheme_js() {?>
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/childtheme.js"></script>                
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/deliberate.js"></script>                
<?php }
add_action('thematic_after','load_childtheme_js');

// Add extra scripts, links and styles to head
function childtheme_head() { ?>
	<!-- Favicons -->
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.png" />
<?php }
add_action('wp_head', 'childtheme_head');

// Remove unused widget areas
function remove_unused_childtheme_widget_areas() {
	unregister_sidebar('primary-aside');
	unregister_sidebar('secondary-aside');
	unregister_sidebar('1st-subsidiary-aside');
	unregister_sidebar('2nd-subsidiary-aside');
	unregister_sidebar('3rd-subsidiary-aside');
	unregister_sidebar('index-top');
	unregister_sidebar('index-insert');
	unregister_sidebar('index-bottom');
	unregister_sidebar('single-top');
	unregister_sidebar('single-insert');
	unregister_sidebar('single-bottom');
	unregister_sidebar('page-top');
	unregister_sidebar('page-bottom');					
}
//add_action( 'admin_init', 'remove_unused_childtheme_widget_areas');

//
//	Debugging
//
ini_set('display_errors', 'On');
error_reporting(E_ERROR);

include('functions-logging.php');

//
// Remove some default Thematic actions
//
function remove_thematic_actions() {

	remove_action('thematic_header','thematic_blogtitle',3);
	remove_action('thematic_header','thematic_blogdescription',5);

}
add_action('init','remove_thematic_actions');

//
//	Shortcodes
//
function deliberate_blog_home() {

	return '<a href="' . get_option('home') . '" title="' . get_bloginfo('name') . '">' . get_bloginfo('name') . '</a>';
}
add_shortcode('blog-home', 'deliberate_blog_home');

function deliberate_year() {   
    return '<span class="the-year">' . date('Y') . '</span>';
}
add_shortcode('the-year', 'deliberate_year');

//
// Alter the Thematic blog title
//

function wpbrightonTheme_blog_title() { ?>

	<div id="blog-title"><span><a href="<?php bloginfo('url') ?>/" title="<?php bloginfo('name') ?>" rel="home"><img src="<?php bloginfo('stylesheet_directory') ?>/images/logo.jpg" width="312"></a></span></div>
<?php
}


add_action('thematic_header','wpbrightonTheme_blog_title','3');

function childtheme_override_access() {

	$blogdesc = '"blog-description">' . get_bloginfo('description');
	$blogdesc = str_replace( ' - ', '<br />', $blogdesc);

	if (is_home() || is_front_page()) { 
    	#echo "\t\t<h1 id=$blogdesc</h1>\n\n";
    } else {	
    	#echo "\t\t<div id=$blogdesc</div>\n\n";
    }
}
add_action('thematic_header','childtheme_override_access','5');

function wpbrightonTheme_thematic_access() { ?>
	    
	    <div id="access">
	    		
	    	<div class="skip-link"><a href="#content" title="<?php _e('Skip navigation to the content', 'thematic'); ?>"><?php _e('Skip to content', 'thematic'); ?></a></div><!-- .skip-link -->
	    		
	    	<?php 
	    		
	    	if ((function_exists("has_nav_menu")) && (has_nav_menu(apply_filters('thematic_primary_menu_id', 'primary-menu')))) {
	    		echo  wp_nav_menu(thematic_nav_menu_args());
    		} else {
    			echo  thematic_add_menuclass(wp_page_menu(thematic_page_menu_args()));	
    		}
    		
	    	?>
			<div id="search">
			<form id="noresults-searchform" method="get" action="<?php bloginfo('url') ?>/">
						
							<input id="noresults-s" name="s" type="text" value="<?php echo esc_html(stripslashes($_GET['s'])) ?>" size="40" />
							<input id="noresults-searchsubmit" name="searchsubmit" type="image" src="<?php bloginfo('stylesheet_directory') ?>/images/search.jpg" value="<?php _e('SEARCH', 'thematic') ?>" />
						
					</form>
	        </div>
		</div><!-- #access -->
		
		<?php 
		}

 add_action('thematic_header','wpbrightonTheme_thematic_access',9);

//
// Remove page comments
//
function remove_comments_admin(){
	remove_post_type_support( 'page', 'comments' );
}
add_action('init','remove_comments_admin');

function remove_comments_template(){
	if(is_page()){
		remove_action('thematic_comments_template','thematic_include_comments',5);
	}
}
add_action('template_redirect','remove_comments_template');

//
// Alter the Thematic blog title
//
function wpbrightonTheme_before_widget_area( $content) {

	//
	//	Add sponsors
	//
	if(strpos($content, 'id="secondary"') !== false) {
		
		$link_categories = get_terms('link_category');

		//sponsors categories
		$sponsors_cat = get_term_by('slug', 'sponsors', 'link_category');
		foreach($link_categories as $link_cat){
			 if ($link_cat->parent == $sponsors_cat->term_id) {
				$sponsorts_cat_children[] = $link_cat->term_id;
			}
		}
		$sponsorts_cat_children = implode(',', $sponsorts_cat_children);
		
		$args = array(
			'category' => $sponsorts_cat_children,
			'echo'     => false,
			'category_orderby'  => 'order',
			'orderby' => 'order'
		);

		//relies on the my-link-order plugin
		$bookmarks = mylinkorder_list_bookmarks($args);
		$bookmarks = str_replace('src=', 'width="100%" src=', $bookmarks);
		$bookmarks = str_replace('h2>', 'h4>', $bookmarks);
		
		$content .= '<li id="sponsors" class="widgetcontainer widget_search">'.
					''.
					'<ul class="sponsors">';
		$content .= $bookmarks;
		$content .= '</ul>'.
					'</li>';
	}

	return $content;
}
add_action('thematic_before_widget_area','wpbrightonTheme_before_widget_area');

//
//	Alter the search form
//
function wpbrightonTheme_search_form( $content) {

	$content = str_replace( 'tabindex="1"', 'tabindex="4"', $content);
	return $content;
	
}
add_filter( 'thematic_search_form', 'wpbrightonTheme_search_form');

function wpbrightonTheme_childtheme_override_siteinfo() { ?>
<div id="footernav" class="sf-menu">

<?php
if ((function_exists("has_nav_menu")) && (has_nav_menu(apply_filters('thematic_primary_menu_id', 'primary-menu')))) {
	    		echo  wp_nav_menu(thematic_nav_menu_args());
    		} else {
    			echo  thematic_add_menuclass(wp_page_menu(thematic_page_menu_args()));	
    		}
?>
</div>
<?php
}
add_action('thematic_footer', 'childtheme_override_siteinfo', 1);
?>
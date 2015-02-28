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
	<!-- Favicons
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/images/sample_favicon_16.png" />
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/images/sample_favicon_32.png" />
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/images/sample_favicon_64.png" /> -->
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
// ini_set('display_errors', 'On');
// error_reporting(E_ERROR);

include('functions-logging.php');

//
// Remove some default Thematic actions
//
function remove_thematic_actions() {

	remove_action('thematic_header','thematic_blogtitle',3);

}
add_action('init','remove_thematic_actions');

//
// Alter the Thematic blog title
//
function wpbrightonTheme_blog_title() { ?>

	<div id="blog-title"><span><a href="<?php bloginfo('url') ?>/" title="<?php bloginfo('name') ?>" rel="home"><img src="<?php bloginfo('stylesheet_directory') ?>/images/logo.png" width="300"></a></span></div>

<?php
}
add_action('thematic_header','wpbrightonTheme_blog_title','3');

// Prints the names of sub-categories for the "Links" functionality
// @param    string        $parent     ID of parent link cat
// @return     echo                    Prints output via wp_list_bookmarks function
function wpbrightonTheme_list_hierarchical_bookmarks($parent) {
    $linkCats = get_terms('link_category');
    //$catsToList = $parent;

    foreach ($linkCats as $linkCat) {
        if ($linkCat->parent == $parent) {
            $catsToList .= ", " . $linkCat->term_id;
        }
    }

    $subCats = array(
        'category' => $catsToList,
    );
    wp_list_bookmarks($subCats);
}
//add_action('widget_area_primary_aside', wpbrightonTheme_list_hierarchical_bookmarks(6));

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
<<<<<<< HEAD
		$bookmarks = str_replace('h2>', 'h4>', $bookmarks);
		dlog($bookmarks);
		
		$content .= '<li id="sponsors" class="widgetcontainer widget_search">'.
					'<h3 class="widgettitle">Sponsors</h3><ul class="sponsors">';
=======
		
		$content .= '<li id="sponsors" class="widgetcontainer widget_search">'.
					'<h3 class="widgettitle">Sponsors</h3>'.
					'<ul>';
>>>>>>> 7fef86f2aa2a5bee54b3bfc344c59bd6224d5c5c
		$content .= $bookmarks;
		$content .= '</ul>'.
					'</li>';
	}

	return $content;
}
add_action('thematic_before_widget_area','wpbrightonTheme_before_widget_area');

?>
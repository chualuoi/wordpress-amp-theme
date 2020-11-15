<?php
require_once __DIR__ . '/../inc/class-Walker-AMP-Category.php';

$r = array(
	'child_of'            => 0,
	'current_category'    => 0,
	'depth'               => 0,
	'echo'                => 1,
	'exclude'             => '',
	'exclude_tree'        => '',
	'feed'                => '',
	'feed_image'          => '',
	'feed_type'           => '',
	'hide_empty'          => 1,
	'hide_title_if_empty' => false,
	'hierarchical'        => true,
	'order'               => 'ASC',
	'orderby'             => 'name',
	'separator'           => '<br />',
	'show_count'          => 0,
	'show_option_all'     => '',
	'show_option_none'    => __( 'No categories' ),
	'style'               => 'list',
	'taxonomy'            => 'category',
	'title_li'            => __( 'Categories' ),
	'use_desc_for_title'  => 1,
	'walker'              => new Walker_AMP_Category()
);
$categories = get_categories( $r );
$output = '';
$output .= walk_category_tree( $categories, 0, $r );
?>
<ul class="list-reset m0 p0 ampstart-label">
	<?php echo $output; ?>
</ul>

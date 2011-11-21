<?php
/*
Template Name: Faculty Archive Page
* Unfortunately this is rather more complex than it needs to be because of the
* atahualpa theme.  We need to replace the "content_inside_loop with custom code that 
* uses the summarize_posts updated queries.  This is somewhat difficult becaue it's a little hard to see exactly 
* what bfa://content_inside_loop is.  
* 
* Basically what this template does is to fetch a set of posts & represent them
*  on the page in a rational way. I've tried two methods -- the first uses 
* Everett's summarize_posts methods, the second uses the builtin get_posts. 
* Neither is exactly beautiful.
*/
?>
<?php  error_reporting(1);
list($bfa_ata, $cols, $left_col, $left_col2, $right_col, $right_col2, $bfa_ata['h_blogtitle'], $bfa_ata['h_posttitle']) = bfa_get_options();
get_header(); 
extract($bfa_ata); 

?>

<?php /* Method 1: use a summarize-posts query */
/* was trying to figure out a hack to 
 * limit the results to the taxonomic grouping I wanted
 * but this is not working for me.  
 * presumably if taxonomy & CCT archive pages worked I wouldn't need to do this at all.
 * in any case the trick here is to give the page a slug that corresponds directly to a 
 * taxonomy term.  It's a cheat, and even so it doesn't work.
$slug = basename(get_permalink());
if ($slug == 'faculty') then :
	$slug = 'faculty*';
*/
$Q = new GetPostsQuery();
$args = array();
$args['post_type'] = 'people';
$args['orderby'] = 'name_last';
$args['post_status'] = 'publish';
/* note this next line is important -- it WOULD make sure we got the right people  if 
 * it brought in childdren for hierarchical taxonomic terms.*/
/*
$args['taxonomy_slug'] = $slug;
*/
$results = $Q->get_posts($args);
?>

<?php /* If there are any posts: */
if (have_posts()) : $bfa_ata['postcount'] = 0; /* Postcount needed for option "XX first posts full posts, rest excerpts" */ ?>

	<?php include 'bfa://content_above_loop'; ?>

	<?php while (have_posts()) : the_post(); $bfa_ata['postcount']++; ?>
	
	<?php /* For SINGLE post pages if activated at ATO -> Next/Previous Navigation: */
	bfa_next_previous_post_links('Top'); ?>

	<?php /* Post Container starts here/  For now just the standard content...  */
	if ( function_exists('post_class') ) { ?>
	<div <?php if ( is_page() ) { post_class('post'); } else { post_class(); } ?> id="post-<?php the_ID(); ?>">
	<?php } else { ?>
	<div class="<?php echo ( is_page() ? 'page ' : '' ) . 'post" id="post-'; the_ID(); ?>">
	<?php } ?>

	<?php bfa_post_kicker('<div class="post-kicker">','</div>'); ?>

	<?php bfa_post_headline('<div class="post-headline">','</div>'); ?>

	<?php bfa_post_byline('<div class="post-byline">','</div>'); ?>


	<?php /*this is where we deviate from the standard template.  ONLY in this section, before bfa_post+pagination*/ ?>
	<div class="post-bodycopy clearfix">
	
	<?php /*
	* Method 1 Continued. 
	* this is an awkward workaround as the tools for retrieving images are not very 
	* flexible (arg!).  I miss the print_custom_field function!
	*/ ?>	

	<table cellpadding=0 cellspacing=0> 
	<?php foreach ($results as $r): ?>
	<tr>      
	<td>
		<p>	
		<div class="alignleft">
			<a href="<?php print $r->permalink; ?>">
				<?php print  wp_get_attachment_image($r->photo, array(75,100)); ?>
			</a>
		</div> 
		<a href="<?php print $r->permalink; ?>"><?php print $r->name_first . " " . $r->name_last . ". "; ?></a>
		<?php print $r->post_content;  ?>
		<a href="mailto:<?php print $r->email ?>">(email)</a></p>

	</td>
	</tr>		
	<?php endforeach ?>
	</table>
<!-- <?php 
/* a second solution that uses the native wordpress 'get_posts'.  advantages & disadvantages... */
global $post;
$args = array( 'post_type' => "people", 'numberposts' => 300, 'orderby' => "meta_value", 'meta_key' => 'name_last', 'order' => "ASC" );
$myposts = get_posts( $args ); ?>
<table cellpadding=0 cellspacing=0 >
	<h2> Second Iteration</h2>
<?php foreach( $myposts as $post ) :	setup_postdata($post); ?>
	<tr><td><br>
	<div class="alignleft"><a href="<?php the_permalink(); ?>"><?php print_custom_field("photo", array(75,100)); ?></a></div><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <?php the_content() ?></li>
	</td></tr>
<?php endforeach; ?>
</table> -->
	</div>

	<?php bfa_post_pagination('<p class="post-pagination"><strong>'.__('Pages:','atahualpa').'</strong>','</p>'); ?>

	<?php bfa_post_footer('<div class="post-footer">','</div>'); ?>						
		<?php endwhile; ?>

	<?php include 'bfa://content_below_loop'; ?>

<?php /* END of: If there are any posts */
else : /* If there are no posts: */ ?>

<?php include 'bfa://content_not_found'; ?>

<?php endif; /* END of: If there are no posts */ ?>

<?php # center_content_bottom does not exist
# if ( $bfa_ata['center_content_bottom'] != '' ) include 'bfa://center_content_bottom'; ?>

<?php get_footer(); ?>

<?php
/*
Template Name: Project Archive Page
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

<?php /* Method: use a summarize-posts query */
/* was trying to figure out a hack to 
 * limit the results to the taxonomic grouping I wanted
 * but this is not working for me.  
 * presumably if taxonomy & CCT archive pages worked I wouldn't need to do this at all.
 * in any case the trick here is to give the page a slug that corresponds directly to a 
 * taxonomy term.  It's a cheat, and even so it doesn't work.

*/
$Q = new GetPostsQuery();
$args = array();
$args['post_type'] = 'project';
$args['orderby'] = 'title';
$args['post_status'] = 'publish';
/* note this next line is important -- it WOULD make sure we got the right people  if 
 * it brought in childdren for hierarchical taxonomic terms.*/
/*
$args['taxonomy_slug'] = $slug;
*/
$results = $Q->get_posts($args);
  //  print_r($results);
?>

<?php /* If there are any posts: */
if (have_posts()) : $bfa_ata['postcount'] = 0; /* Postcount needed for option "XX first posts full posts, rest excerpts" */ ?>

	<?php include 'bfa://content_above_loop'; ?>

	
	
	<?php /*
	* Post Query method Continued. 
	* this is an awkward workaround as the tools for retrieving images are not very 
	* flexible (arg!).  I miss the print_custom_field function!
	*/ ?>	

	<table cellpadding=0 cellspacing=0> 
	<?php foreach ($results as $r):
        //print_r($r);

    ?>
	<tr>      
	<td>
     <?php 
      /*   if ($r['thumbnail_id']) {
      *      print  '<div class="alignleft">';
      *      print get_the_post_thumbnail($r['post_id'], array(75,100));
      *      print '</div> ';
      * } */
    ?> 
		<a href="<?php print $r['permalink']; ?>"><?php print $r['post_title'] . ". "; ?></a>

		<?php 
            $belongs =  get_instructor_list(CCTM::filter($r['belongs_to']), 'raw');
          if( ! empty ($belongs) ) {
            print "(" . $belongs . ")";
          }
          print '<p>';
          print $r['post_content'];  
          if ( $r['book_url'] ) {
            print '<a href="' . $r['book_url'] . '">Visit the site</a></p>';
          }
        ?>
		

	</td>
	</tr>		
	<?php endforeach ?>
	</table>
	</div>


	<?php bfa_post_footer('<div class="post-footer">','</div>'); ?>						


	<?php include 'bfa://content_below_loop'; ?>

<?php else : /* If there are no posts: */ ?>

<?php include 'bfa://content_not_found'; ?>

<?php endif; /* END of: If there are no posts */ ?>

<?php # center_content_bottom does not exist
# if ( $bfa_ata['center_content_bottom'] != '' ) include 'bfa://center_content_bottom'; ?>

<?php get_footer(); ?>

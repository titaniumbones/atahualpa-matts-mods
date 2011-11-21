<?php
/*
Template Name: Faculty Individual Page
* Unfortunately this is rather more complex than it needs to be because of 
* atahualpa.  We need to replace the "content_inside_loop with custom code that 
* uses the summarize_posts updated queries.  This is somewhat difficult becaue it's a little hard to see exactly 
* content_inside_loop is.  
*/
?><?php # error_reporting(-1);
list($bfa_ata, $cols, $left_col, $left_col2, $right_col, $right_col2, $bfa_ata['h_blogtitle'], $bfa_ata['h_posttitle']) = bfa_get_options();
get_header(); 
extract($bfa_ata); 

?>
<?php /* If there are any posts: */
if (have_posts()) : $bfa_ata['postcount'] = 0; /* Postcount needed for option "XX first posts full posts, rest excerpts" */ ?>
<?php include 'bfa://content_above_loop'; ?>
<?php while (have_posts()) : the_post(); $bfa_ata['postcount']++; ?>
<?php /* For SINGLE post pages if activated at ATO -> Next/Previous Navigation: */
bfa_next_previous_post_links('Top'); ?>

<!-- This section displays the headline.  Consider changing to first name/last name;
     but to do tht I would need to unpack bfa_post_headline -->
<?php /* Post Container starts here */
if ( function_exists('post_class') ) { ?>
  <div <?php if ( is_page() ) { post_class('post'); } else { post_class(); } ?> id="post-<?php the_ID(); ?>">
  <?php } else { ?>
  <div class="<?php echo ( is_page() ? 'page ' : '' ) . 'post" id="post-'; the_ID(); ?>">
    <?php } ?>

<?php /* bfa_post_kicker('<div class="post-kicker">','</div>');
 * 
 *      bfa_post_headline('<div class="post-headline">','</div>');
 * 
 * bfa_post_byline('<div class="post-byline">','</div>'); */ ?> 
<!-- Book Cover Image -->
<table>
<tr>
<td width="130">
   <?php  if((get_post_meta($post->ID, "book_cover_image", true))) { ?>
     <div id=book_cover_image>
     <?php print_custom_field('book_cover_image:to_image_tag', 'thumbnail'); 
      ?>
       </div>
           <?php }?>
</td>
<!-- THis contains the main info -->
<td valign=top>
     <div id="pub-info">
     <?php the_title('<b>', '</b>'); ?>
     <?php print_custom_field('authors:wrapper', ', <i>[+content+]</i>. '); ?>
     <?php  if((get_post_meta($post->ID, "book_city", true)) or (get_post_meta($post->ID, "book_publisher", true)) or (get_post_meta($post->ID, "book_year", true))) { ?>
(<?php print_custom_field('book_city:wrapper', '[+content+]: '); ?>
<?php print_custom_field('book_publisher:wrapper', '[+content+]'); ?>
   <?php print_custom_field('book_year:wrapper', ', [+content+]'); ?>)
  <?php } ?>
                                                                                                                                   </div>
     <div id="blurb">
     <?php print_custom_field('large_blurb:wrapper', '<p> [+content+]</p>'); ?>
                                                                                                                                                                       <?php print_custom_field('belongs_to:wrapper:to_link_href', '<p>More about [+content+]</p>');?>
</div>
</td>
</tr>
</table>

<!-- Body of Post -->
     <?php bfa_post_bodycopy('<div class="post-bodycopy clearfix">','</div>'); ?>

<!-- Taxonomic Terms -->
     <?php /* more custom fields, this time going under the 'body' -- publications and tags, this time */ ?>
     <?php echo get_the_term_list( get_the_ID(), 'geographical-areas', "<p><strong>Geographical Areas of Interest: </strong>", ", ", "</p>" ) ;?>
     <?php echo get_the_term_list( get_the_ID(), 'thematic-areas'    , "<p><strong>Thematic Areas of Interest: </strong>"    , ", ", "</p>" ) ;?>
     <?php if((get_post_meta($post->ID, "publications", true))) { ?>
     <div id=person-publications>
       <strong>Selected Publications:</strong><br />
       <?php print_custom_field('publications'); ?>
    <?php } ?>
     </div>

     <?php bfa_post_pagination('<p class="post-pagination"><strong>'.__('Pages:','atahualpa').'</strong>','</p>'); ?>

     <?php bfa_post_footer('<div class="post-footer">','</div>'); ?>

</div><!-- / Post -->
						
     <?php endwhile; ?>

     <?php include 'bfa://content_below_loop'; ?>

     <?php /* END of: If there are any posts */
     else : /* If there are no posts: */ ?>

       <?php include 'bfa://content_not_found'; ?>

     <?php endif; /* END of: If there are no posts */ ?>

     <?php # center_content_bottom does not exist
     # if ( $bfa_ata['center_content_bottom'] != '' ) include 'bfa://center_content_bottom'; ?>

     <?php get_footer(); ?>

dfd
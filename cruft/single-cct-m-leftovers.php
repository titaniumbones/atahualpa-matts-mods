     <td>
   <?php  if((get_post_meta($post->ID, "twitter", true))) { ?>
   <div id=twitter>
      <strong>Twitter Username:</strong> <?php print_custom_field('twitter'); ?><br />
   </div>
   ?>
   <?php  if((get_post_meta($post->ID, "facebook", true))) { ?>
   <div id=facebook>
      <strong>Facebook Username:</strong> <?php print_custom_field('facebook'); ?><br />
   </div>
   ?>
    <?php  if((get_post_meta($post->ID, "academia", true))) { ?>
   <div id=academia>
      <strong>Academia Username:</strong> <?php print_custom_field('academia'); ?><br />
   </div>
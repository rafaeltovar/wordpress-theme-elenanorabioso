Widget Title:<br />
<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo stripslashes($instance['title']); ?>" />
<br /><br />

Days of interval (default: 7, one week):<br />
<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'days-interval' ); ?>" value="<?php echo stripslashes($instance['days-interval']); ?>" />
<br /><br />

Number of posts:<br />
<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'num-tags' ); ?>" value="<?php echo stripslashes($instance['num-tags']); ?>" />
<br /><br />

<input type="hidden" name="submitted" value="1" />
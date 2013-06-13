Widget Title:<br />
<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo stripslashes($instance['title']); ?>" />
<br /><br />

Number of posts: <br />
<small>(0 is infinite)</small><br/>
<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'num-posts' ); ?>" value="<?php echo stripslashes($instance['num-posts']); ?>" />

<input type="hidden" name="submitted" value="1" />
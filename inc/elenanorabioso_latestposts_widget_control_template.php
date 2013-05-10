Widget Title:<br />
<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo stripslashes($instance['title']); ?>" />
<br /><br />

Categorie:<br />
<select name="<?php echo $this->get_field_name( 'category' ); ?>" class="widefat">
  <option value="-1" <?php echo ($instance['category']==-1? 'selected="selected"':'') ?>>Actual</option>
  <option value="0" <?php echo ($instance['category']==0? 'selected="selected"':'') ?>>Todas</option>
<?php foreach($categories as $cat): ?>
  <option value="<?php echo $cat->cat_ID; ?>" <?php echo ($cat->cat_ID==$instance['category']? 'selected="selected"':'') ?>><?php echo $cat->name; ?></option>
<?php endforeach; ?>
</select>
<br /><br />

Image size:<br />
<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'image-size' ); ?>" value="<?php echo stripslashes($instance['image-size']); ?>" />
<br /><br />

Number of posts:<br />
<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'num-posts' ); ?>" value="<?php echo stripslashes($instance['num-posts']); ?>" />
<br /><br />

Template file:<br />
<select name="<?php echo $this->get_field_name( 'template-file' ); ?>" class="widefat">
<?php foreach($templates as $template): ?>
  <option value="<?php echo $template['file']; ?>" <?php echo ($template['file']==$instance['template-file']? 'selected="selected"':'') ?>><?php echo $template['name']; ?></option>
<?php endforeach; ?>
</select>
<br /><br />

<input type="hidden" name="submitted" value="1" />
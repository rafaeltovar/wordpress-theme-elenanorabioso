<?php
/*
Template Name: Custom Feed for IFTTT & Tumblr

This file is a custom feed template. Change author by categories, for IFTTT ingredient for Tumblr tags recipe.
*/

$numposts = 10;

function yoast_rss_date( $timestamp = null ) {
 	$timestamp = ($timestamp==null) ? time() : $timestamp;
 	echo date(DATE_RSS, $timestamp);
}

function yoast_rss_text_limit($string, $length, $replacer = '...') { 
	$string = strip_tags($string);
	if(strlen($string) > $length) 
    	return (preg_match('/^(.*)\W.*$/', substr($string, 0, $length+1), $matches) ? $matches[1] : substr($string, 0, $length)) .$replacer;   
  
    return $string; 
}

$posts = query_posts('showposts='.$numposts);

$lastpost = $numposts - 1;

header("Content-Type: application/rss+xml; charset=UTF-8");
echo '<?xml version="1.0"?>';
?>
<rss version="2.0">
<channel>
  <title><?php  bloginfo( 'name' ); ?></title>
  <link><?php  bloginfo( 'siteurl' ); ?></link>
  <description><?php  bloginfo( 'description' ); ?></description>
  <language>es-es</language>
  <pubDate><?php yoast_rss_date( strtotime($ps[$lastpost]->post_date_gmt) ); ?></pubDate>
  <lastBuildDate><?php yoast_rss_date( strtotime($ps[$lastpost]->post_date_gmt) ); ?></lastBuildDate>
  <?php foreach ($posts as $post): ?>
  <?php
  	$posttags = get_the_tags($post->ID);
  	$tags = '';
  	if ($posttags) {
	  	foreach($posttags as $tag) $tags = $tags.$tag->name . ', '; 
	}
	
	$content = yoast_rss_text_limit($post->post_content, 500).'<br/><a href="'.get_permalink($post->ID).'">Seguir leyendo...</a>';
	if (has_post_thumbnail( $post->ID ) ){
		$content = get_the_post_thumbnail( $post->ID, 'full', array('style'=>"width: 500px;") ) . ' ' . $content;
	}
	?>
  	<item>
    	<title><?php echo get_the_title($post->ID); ?></title>
    	<link><?php echo get_permalink($post->ID); ?></link>
    	<description><?php echo '<![CDATA['.$content.']]>';  ?></description>
    	<pubDate><?php yoast_rss_date( strtotime($post->post_date_gmt) ); ?></pubDate>
    	<guid><?php echo get_permalink($post->ID); ?></guid>
    	<dc:creator><?php echo $tags; ?></dc:creator>
    </item>
<?php endforeach; ?>
</channel>
</rss>
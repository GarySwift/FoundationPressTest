<?php
function wp_swift_the_post_hook( $post_object ) {    
	$html='';
	if (is_single()) {	
		ob_start();
		?><div class="callout secondary">
			<h3>the_post Single Post</h3>
			<p>Nemo unde magnam aspernatur ipsa, corporis eos minus, dolores quaerat quia voluptas placeat fugit quibusdam soluta quo officiis molestias eligendi vitae debitis.</p>
		</div><?php

		$html = ob_get_contents();
		ob_end_clean();
	}
	else {
		ob_start();
		?><div class="callout primary">
			<h3>the_post Posts News</h3>
			<p>Nemo unde magnam aspernatur ipsa, corporis eos minus, dolores quaerat quia voluptas placeat fugit quibusdam soluta quo officiis molestias eligendi vitae debitis.</p>
		</div><?php
		$html = ob_get_contents();
		ob_end_clean();		
	}
    echo $html;
}


function wp_swift_add_after_content( $content ) {   
	$acf_content = the_acf_content();
    return $content.$acf_content;
}
add_filter( 'the_content', 'wp_swift_add_after_content' );


/** Custom Functions */
function the_acf_content($image_size='', $row_class='') {
	if( have_rows('modules') ):
	    while ( have_rows('modules') ) : the_row();

	        if( get_row_layout() == 'video' ):

	        	$acf_content = get_acf_video();//get_sub_field('video');

	        elseif( get_row_layout() == 'gallery' ): 
	        	if( get_sub_field('images') ) {
	        	    $acf_content = get_acf_gallery( get_sub_field('images'), $row_class );
	        	}
	        endif;

	    endwhile;
	endif;
	return $acf_content;	
}

function get_acf_video($row_class='') {
	$acf_content = '';
	if(is_single()) :
		$iframe = get_sub_field('video');
		ob_start();
		?>
		<div class="row">
			<div class="embed-container">
				<?php echo $iframe ?>
			</div>
		</div>
		<?php
		
		$acf_content = ob_get_contents();
		ob_end_clean();
	else:

		$url = get_sub_field('video', false, false);
		$url = urldecode(rawurldecode($url));
	    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
		if (isset($matches[1])):
			ob_start();
			?>
			<div class="row">
				<div class="embed-container">
					<div class="youtube-player" data-id="<?php echo $matches[1] ?>"></div>
				</div>
			</div>
			<?php
			$acf_content = ob_get_contents();
			ob_end_clean();
		endif;//@end isset($matches[1])
	endif;//@end is_single

return $acf_content;
}
function get_acf_gallery($images, $row_class='') {
	$acf_content = '';
	$diff= false;
	$count = 0;	
	$limit = count($images);

	// Limit the amount of images shown if shown in blog view to save loading time
	if(!is_single()) {
		$limit=4;
		$totalImgs = count($images);
		if($totalImgs>$limit) {
			$diff = $totalImgs - $limit;
		}	
	} 

	$thumbnail_size = 'thumbnail_large';
	if (!$row_class) {
		$row_class= 'small-up-2 medium-up-3 large-up-2';
	}
	
	if (!$single_post) {
	 	$thumbnail_size = 'thumbnail';
	 	$row_class= 'small-up-2 medium-up-4 large-up-4';
	}
	ob_start();
	?>
	<div class="row <?php echo $row_class ?> lightbox-gallery">
		<?php 
		foreach( $images as $image ): 
            $defaultImgCaption = '';
            $defaultImgTitle = '';
	    	?>
			<div class="column">                 
			    <a href="<?php echo $image['sizes']['fp-large']; ?>" class="lightbox" title="<?php echo ($image['caption'] ? $image['caption']  : $defaultImgCaption ); ?>">
					<img class="thumbnail" src="<?php echo $image['sizes'][$thumbnail_size]; ?>" alt="<?php echo ($image['alt'] ? $image['alt']  : 'Image'); ?>" title="<?php echo ($image['title'] ? $image['title']  : $defaultImgTitle); ?>" />
				</a>
			</div>
			<?php
			if (++$count == $limit) {
				break;
			}		
		endforeach; ?>

		<?php if($diff): ?>
			<div class="text-right">
				<i class="fa fa-plus"></i>
				<span class=" badge "><?php echo $diff; ?></span>
			</div>
		<?php endif; ?>	
	</div>
	<?php
	
	$acf_content = ob_get_contents();
	ob_end_clean();
	return $acf_content;
}
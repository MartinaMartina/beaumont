<?php
/**
 * Custom template tags for Simple & Elegant
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 */

/* Display Social Icons
-------------------------------------------------------------------------------------- */
if ( !function_exists('withemes_social_array') ):
function withemes_social_array() {
    return array(
        'facebook-official' => esc_html__('Facebook', 'simple-elegant'),
        'twitter' => esc_html__('Twitter', 'simple-elegant'),
        'pinterest-p' => esc_html__('Pinterest', 'simple-elegant'),
        'instagram' => esc_html__('Instagram', 'simple-elegant'),
        'google-plus' => esc_html__('Google+', 'simple-elegant'),
        'linkedin' => esc_html__('LinkedIn', 'simple-elegant'),
        'tumblr' => esc_html__('Tumblr', 'simple-elegant'),
        'youtube' => esc_html__('YouTube', 'simple-elegant'),
        'skype' => esc_html__('Skype', 'simple-elegant'),
        'delicious' => esc_html__('Delicious', 'simple-elegant'),
        'digg' => esc_html__('Digg', 'simple-elegant'),
        'reddit' => esc_html__('Reddit', 'simple-elegant'),
        'stumbleupon' => esc_html__('StumbleUpon', 'simple-elegant'),
        'medium' => esc_html__('Medium', 'simple-elegant'),
        'vimeo-square' => esc_html__('Vimeo', 'simple-elegant'),
        'yahoo' => esc_html__('Yahoo!', 'simple-elegant'),
        'flickr' => esc_html__('Flickr', 'simple-elegant'),
        'deviantart' => esc_html__('DeviantArt', 'simple-elegant'),
        'github' => esc_html__('GitHub', 'simple-elegant'),
        'stack-overflow' => esc_html__('StackOverFlow', 'simple-elegant'),
        'stack-exchange' => esc_html__('Stack Exchange', 'simple-elegant'),
        'bitbucket' => esc_html__('Bitbucket', 'simple-elegant'),
        'xing' => esc_html__('Xing', 'simple-elegant'),
        'foursquare' => esc_html__('Foursquare', 'simple-elegant'),
        'paypal' => esc_html__('Paypal', 'simple-elegant'),
        'yelp' => esc_html__('Yelp', 'simple-elegant'),
        'soundcloud' => esc_html__('SoundCloud', 'simple-elegant'),
        'lastfm' => esc_html__('Last.fm', 'simple-elegant'),
        'spotify' => esc_html__('Spotify', 'simple-elegant'),
        'slideshare' => esc_html__('Slideshare', 'simple-elegant'),
        'dribbble' => esc_html__('Dribbble', 'simple-elegant'),
        'steam' => esc_html__('Steam', 'simple-elegant'),
        'behance' => esc_html__('Behance', 'simple-elegant'),
        'heart' => esc_html__('Bloglovin\'', 'simple-elegant'),
        'weibo' => esc_html__('Weibo', 'simple-elegant'),
        'trello' => esc_html__('Trello', 'simple-elegant'),
        'vk' => esc_html__('VKontakte', 'simple-elegant'),
        'home' => esc_html__('Homepage', 'simple-elegant'),
        'envelope-o' => esc_html__('Email', 'simple-elegant'),
        'rss' => esc_html__('Feed', 'simple-elegant'),
	);
}
endif;

if ( !function_exists('withemes_social_corresponding') ) :
/**
 * Converts from an option to an icon
 *
 * @since 1.3
 *
 * @param $k is the icon option
 */
function withemes_social_corresponding( $k ) {
    $modifies = array(
        'facebook-official' => 'facebook',
        'pinterest-p' => 'pinterest',
        'youtube' => 'youtube-play',
        'vimeo-square' => 'vimeo',
    );
    
    if ( isset( $modifies[ $k ] ) ) return $modifies[ $k ];
    else return $k;
    
}
endif;

if ( !function_exists('withemes_display_social') ) :
/**
 * Displays social icons on the topbar or in footer
 *
 * @since 1.0
 *
 * @modified since 1.3
 */
function withemes_display_social(){
    $social_array = withemes_social_array();
    $return = '';
    foreach ( $social_array as $k => $v) :
        if ( get_option('withemes_social_'.$k) ) :
    
            $icon = withemes_social_corresponding( $k );
    
            $return .= '<li class="li-' . esc_attr($k) . '"><a href="' . esc_url(get_option('withemes_social_'.$k)) . '" target="_blank" title="' . esc_attr($v) . '"><i class="fa fa-' . esc_attr( $icon ) . '"></i></a></li>';
        endif;
    endforeach;

    if ( $return != '' ) $return = '<div class="social-list"><ul>' . $return . '</ul></div>';
    return $return;

}
endif;

if ( ! function_exists( 'withemes_contactmethods' ) ) :
/**
 * Author contact methods
 *
 * @since 1.0
 */
function withemes_contactmethods ( $contactmethods ) {
    
    $methods = array( 'twitter', 'facebook', 'linkedin', 'pinterest', 'googleplus', 'tumblr', 'instagram', 'vk', 'flickr', 'medium', 'youtube', 'soundcloud' );
    
    $social_arr = withemes_social_array();
    
    foreach ( $methods as $icon ) {
        $contactmethods[ $icon ] = isset( $social_arr[ $icon ] ) ? $social_arr[ $icon ] : ucfirst( $icon );
    }

    return $contactmethods;

}
endif;
add_filter( 'user_contactmethods', 'withemes_contactmethods' );

if ( ! function_exists( 'withemes_get_user_contact_methods' ) ) :
/**
 * Get an array of contact methods for a user
 * 
 * @since 1.0
 *
 * @return array( 'twitter' => 'http://...', 'facebook' => 'http://fac...' );
 */
function withemes_get_user_contact_methods( $userid = null ) {
    $return = array();
    
    // author of a post
    if ( !$userid ) {
        $userid = get_the_author_meta( 'ID' );
    }

    $methods = array( 'twitter', 'facebook', 'linkedin', 'pinterest', 'googleplus', 'tumblr', 'instagram', 'vk', 'flickr', 'medium', 'youtube', 'soundcloud' );
    
    foreach ( $methods as $method ) {
        if ( get_the_author_meta( $method, $userid ) ) {
            
            $return[ $method ] = get_the_author_meta( $method, $userid );
            
        }
    }

    return $return;

}
endif;

if ( !function_exists( 'withemes_author_social' ) ) :
/**
 * Displays author icons from their profile
 *
 * @since 2.0
 *
 * @return void
 */
function withemes_author_social( $userid = null ) {
    
    if ( $profile = withemes_get_user_contact_methods( $userid ) ) :
            
    $social_arr = withemes_social_array(); ?>

    <nav class="author-social-list social-list">
        <ul>
            <?php foreach ( $profile as $method => $url ) : ?>

            <?php 
                $icon = withemes_social_corresponding( $method );
                $title = isset( $social_arr[ $icon ] ) ? $social_arr[ $icon ] : ucfirst( $icon );
            ?>

            <li class="<?php echo esc_attr( "li-{$method}" ); ?>"><a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $title ); ?>"><i class="<?php echo esc_attr( "fa fa-{$icon}" );?>"></i></a></li>

            <?php endforeach ; ?>
        </ul>
    </nav><!-- .author-social-list -->

    <?php endif; // if user contact methods exist
}
endif;

/* Comment Nav
-------------------------------------------------------------------------------------- */
if ( ! function_exists( 'withemes_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since Simple & Elegant 1.0
 */
function withemes_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'simple-elegant' ); ?></h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'simple-elegant' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'simple-elegant' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}
endif;

/* Entry Meta
-------------------------------------------------------------------------------------- */
if ( ! function_exists( 'withemes_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, author...
 *
 * @since Simple & Elegant 1.0
 */
function withemes_entry_meta() {
    
    echo '<div class="entry-meta">';
    
	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date(),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			_x( 'Posted on', 'Used before publish date.', 'simple-elegant' ),
			esc_url( get_permalink() ),
			$time_string
		);
	}

	if ( 'post' == get_post_type() ) {
		if ( is_singular() || is_multi_author() ) {
			printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
				_x( 'Author', 'Used before post author name.', 'simple-elegant' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author()
			);
		}

		$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'simple-elegant' ) );
		if ( $categories_list ) {
			printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Categories', 'Used before category names.', 'simple-elegant' ),
				$categories_list
			);
		}
		
	}

	if ( is_attachment() && wp_attachment_is_image() ) {
		// Retrieve attachment metadata.
		$metadata = wp_get_attachment_metadata();

		printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
			_x( 'Full size', 'Used before full size attachment link.', 'simple-elegant' ),
			esc_url( wp_get_attachment_url() ),
			$metadata['width'],
			$metadata['height']
		);
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( esc_html__( 'Leave a comment', 'simple-elegant' ) );
		echo '</span>';
	}
    
    echo '</div>';
    
}
endif;


if ( ! function_exists( 'withemes_grid_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, author...
 *
 * @since 2.0
 */
function withemes_grid_meta() {
    
    echo '<div class="entry-meta grid-meta">';
    
	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date(),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			_x( 'Posted on', 'Used before publish date.', 'simple-elegant' ),
			esc_url( get_permalink() ),
			$time_string
		);
	}
    
    $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'simple-elegant' ) );
    if ( $categories_list ) {
        printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
            _x( 'Categories', 'Used before category names.', 'simple-elegant' ),
            $categories_list
        );
    }
    
    echo '</div>';
    
}
endif;

/* Media Result
-------------------------------------------------------------------------------------- */
if ( !function_exists('withemes_media') ) :
/**
 * Display video or audio result from backend options
 *
 * @since Simple & Elegant 1.0
 */    
    
function withemes_media(){
    
    global $content_width;
    
    // get data
	$type = get_post_format();	
	if ($type=='audio') $media_code = trim( get_post_meta( get_the_ID(), '_format_audio_embed' , true ) );
	elseif ($type=='video') $media_code = trim( get_post_meta( get_the_ID(), '_format_video_embed' , true ) );
	else $media_code = '';
	
	// return none
	if (!$media_code) return;
	
	// iframe
	if ( stripos($media_code,'<iframe') > -1) return '<figure class="post-thumbnail thumbnail-video"><div class="media-container">' . $media_code . '</div></figure>';

	// case url	
	// detect if self-hosted
	$url = $media_code;
	$parse = parse_url(home_url());
	$host = preg_replace('#^www\.(.+\.)#i', '$1', $parse['host']);
	$media_result = '';
	
	// not self-hosted
	if (strpos($url,$host)===false) {
		global $wp_embed;
		return '<figure class="post-thumbnail thumbnail-media"><div class="media-container">' . $wp_embed->run_shortcode('[embed]' . $media_code . '[/embed]') . '</div></figure>';
	
	// self-hosted	
	} else {
		if ($type=='video') {
			$args = array('src' => esc_url($url), 'width' => $content_width );
			if ( has_post_thumbnail() ) {
				$full_src = wp_get_attachment_image_src( get_post_thumbnail_id() , 'full' );
				$args['poster'] = $full_src[0];
			}
			$media_result = '<figure class="post-thumbnail withemes_self-hosted-sc">'.wp_video_shortcode($args).'</figure>';
		} elseif ($type=='audio') {
            
            if ( has_post_thumbnail() ) {
				$full_src = wp_get_attachment_image_src( get_post_thumbnail_id() , 'full' );
                $media_result = '<figure class="post-thumbnail withemes_self-hosted-audio-poster"><img src="'.esc_url($full_src[0]).'" width="'.$full_src[1].'" height="'.$full_src[2].'" alt="'.esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) .'" />' . wp_audio_shortcode(array('src' => esc_url($url))) . '</figure>';
            } else {
                $media_result = '<figure class="post-thumbnail self-hosted-audio">' . wp_audio_shortcode(array('src' => esc_url($url))) . '</figure>';
            }
		}
	}
	
	return $media_result;
}
endif;

/* Display Post Slider
-------------------------------------------------------------------------------------- */
if ( ! function_exists( 'withemes_slider' ) ) :
/**
 * Display flexslider from photos in backend
 *
 * @since Simple & Elegant 1.0
 */
function withemes_slider( $size = 'full' ) {
    
    $images = get_post_meta( get_the_ID() , '_format_gallery_images', true );
    if (  !$images || !is_array($images) )	// nothing at all
        return;
    
    $attachments = get_posts( array(
        'posts_per_page' => -1,
        'orderby' => 'post__in',
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'post__in' => $images,
    ) );
    
    if ( ! count( $attachments ) ) return;
    
    ?>
<div class="wi-flexslider">
    <div class="flexslider">
        <ul class="slides">
            
            <?php
            foreach ( $attachments as $attachment) : ?>
            
            <li>
                <?php echo wp_get_attachment_image( $attachment->ID, $size ); ?>
            </li>
          
            <?php endforeach; ?>
            
        </ul>
    </div><!-- .flexslider -->
</div><!-- .wi-flexslider -->
    <?php
}
endif;

if ( ! function_exists( 'withemes_image_stack' ) ) :
/**
 * Image Stack
 *
 * @since 2.0
 */
function withemes_image_stack() {
    
    $images = get_post_meta( get_the_ID() , '_format_gallery_images', true );
    if (  !$images || !is_array($images) )	// nothing at all
        return;
    
    $attachments = get_posts( array(
        'posts_per_page' => -1,
        'orderby' => 'post__in',
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'post__in' => $images,
    ) );
    
    if ( ! count( $attachments ) ) return;
    
    ?>

<div class="gallery-stack">

    <?php foreach ( $attachments as $attachment) : ?>
    
    <figure class="single-image">
        
        <?php echo wp_get_attachment_image( $attachment->ID, 'full' ); ?>
    
    </figure><!-- .single-image -->
    
    <?php endforeach; ?>

</div><!-- .gallery-stack -->

<?php

}
endif;

if ( ! function_exists( 'withemes_page_title' ) ) :
/**
 * Display page title
 *
 * @since Simple & Elegant 2.0
 */
function withemes_page_title() {

    if ( !is_front_page() && 'true' !== get_post_meta( get_the_ID(), '_withemes_disable_title', true ) ) :

        the_title( '<h1 id="page-title" class="page-title">', '</h1>' );

    endif;
    
}
endif;

/* Display Post Thumbnail
-------------------------------------------------------------------------------------- */
if ( ! function_exists( 'withemes_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @since Simple & Elegant 1.0
 */
function withemes_post_thumbnail() {
	if ( post_password_required() || is_attachment() ) :
		return;
	endif;
    
    $format = get_post_format();
    
    if ( $format == 'video' || $format == 'audio' ) :
    
        echo withemes_media();
    
    elseif ( $format == 'gallery' ) :
    
        $display = get_post_meta( get_the_ID(), '_withemes_gallery_display', true );
    
        if ( 'stack' == $display ) {

            withemes_image_stack();

        } else {

            withemes_slider();

        }
    
    elseif ( !has_post_thumbnail() ) :
        return;
    else :
        if ( is_singular() ) :
        ?>
        <figure class="post-thumbnail">
            <?php the_post_thumbnail(); ?>
        </figure><!-- .post-thumbnail -->
        
        <?php else: ?>

        <figure class="post-thumbnail">
            <a class="permalink" href="<?php the_permalink(); ?>">
                <?php
                    the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
                ?>
            </a>
        </figure>

        <?php endif; // End is_singular()
    endif; // End post format
}
endif;

/* Replace Excerpt "[...]" by ...
-------------------------------------------------------------------------------------- */
if ( ! function_exists( 'withemes_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 *
 * @since Simple & Elegant 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function withemes_excerpt_more( $more ) {
	$link = sprintf( '<a href="%1$s" class="readmore">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( esc_html__( 'More %s &raquo;', 'simple-elegant' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
		);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'withemes_excerpt_more' );
endif;

/* Pagination
-------------------------------------------------------------------------------------- */
if ( ! function_exists( 'withemes_pagination' ) ) :

function withemes_pagination( $custom_query = false ){
	global $wp_query;
	
	if ( !$custom_query ) $custom_query = $wp_query;

	$big = 999999999; // need an unlikely integer
	$pagination = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => is_front_page() ? max( 1, get_query_var('page') ) : max( 1, get_query_var('paged') ),
		'total' => $custom_query->max_num_pages,
		'type'			=> 'plain',
		'before_page_number'	=>	'<span>',
		'after_page_number'	=>	'</span>',
		'prev_text'    => '<span>' . esc_html__('&laquo; Previous','simple-elegant') . '</span>',
		'next_text'    => '<span>' . esc_html__('Next &raquo;','simple-elegant') . '</span>',
	) );
	
	if ( $pagination ) {
		echo '<div class="pagination navigation"><div class="nav-links">';	
		echo $pagination;
		echo '</div></div>';
	}
}

endif;
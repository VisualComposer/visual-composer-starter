<?php

if ( ! function_exists( 'visualcomposerstarter_post_thumbnail' ) ) :
    function visualcomposerstarter_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }
            ?>
            <div class="featured-content">
                <div class="fade-in-img">
                    <img src="<?php the_post_thumbnail_url(); ?>" data-src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title() ?>">
                    <noscript>
                        <?php the_post_thumbnail(); ?>
                    </noscript>
                </div>
            </div><!-- .post-thumbnail -->
        <?php
    }
endif;

if ( ! function_exists( 'visualcomposerstarter_header_featured_content' ) ) :
    function visualcomposerstarter_header_featured_content() {
        if( get_post_format() == 'video' ) {
            $post = get_post( get_the_ID() );
            remove_filter( 'the_content', 'wpautop' );
           ?>
                <div class="video-wrapper">
                    <?php echo apply_filters( 'the_content', $post->post_content ); ?>
                </div>
            <?php
        }
        elseif( get_post_format() == 'gallery' ) {
            ?>
            <div class="gallery-slider">
                <?php
                $gallery = get_post_gallery_images( get_the_ID() );

                foreach ( $gallery as $key => $src ):
                    ?>
                    <div class="gallery-item">
                        <div class="fade-in-img">
                            <img src="<?php echo $src;?>" data-src="<?php echo $src;?>" alt="">
                            <noscript>
                                <img src="<?php echo $src;?>" alt="">
                            </noscript>
                        </div><!--.fade-in-img-->
                    </div><!--.gallery-item-->
                    <?php
                endforeach;
                ?>
            </div><!--.gallery-slider-->
            <?php
        }
        elseif( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }
        else {
            ?>
            <div class="fade-in-img">
                <img src="<?php the_post_thumbnail_url(); ?>" data-src="<?php the_post_thumbnail_url() ?>"
                     alt="<?php the_title() ?>">
                <noscript>
                    <?php the_post_thumbnail(); ?>
                </noscript>
            </div>

            <?php
        }
    }
endif;

if ( ! function_exists( 'visualcomposerstarter_entry_date' ) ) :
    function visualcomposerstarter_entry_date() {

        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = get_the_modified_date();
        }
        else {
            $time_string = get_the_date();
        }

         printf( '<a href="%1$s">%2$s</a>',
            esc_url( get_permalink() ),
            $time_string
        );
    }
endif;

if ( ! function_exists( 'visualcomposerstarter_entry_meta' ) ) :
    function visualcomposerstarter_entry_meta() {
        ?>
        <ul class="entry-meta">
            <?php if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ): ?>
                <li class="entry-meta-date">
                    <?php visualcomposerstarter_entry_date(); ?>
                </li>
            <?php endif;?>
            <?php if ( 'post' === get_post_type() ): ?>
                <li class="entry-meta-author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a></li>
            <?php endif; ?>

            <li class="entry-meta-category"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'visual-composer-starter' ) ); ?></li>

            <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
                <li class="entry-meta-comments"><?php comments_popup_link( __( 'Leave a comment', 'visual-composer-starter' ), __( '1 Comment', 'visual-composer-starter' ), __( '% Comments', 'visual-composer-starter' ) ); ?>
            <?php endif; ?>

            </li>
        </ul>
        <?
    }
endif;

if ( ! function_exists( 'visualcomposerstarter_single_meta' ) ) :
    function visualcomposerstarter_single_meta() {
        ?>
        <div class="entry-meta">
            <?php echo _x( 'On', 'Post meta' ); ?>
            <?php if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ): ?>
                <?php visualcomposerstarter_entry_date(); ?>
            <?php endif;?>
            <?php echo _x( 'by', 'Post meta' ); ?>
            <?php if ( 'post' === get_post_type() ): ?>
                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a>
            <?php endif; ?>
            <?php echo _x( 'to', 'Post meta' ); ?>
            <?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'visual-composer-starter' ) ); ?>
        </div>
        <?
    }
endif;

if ( ! function_exists( 'visualcomposerstarter_entry_tags' ) ) :

    function visualcomposerstarter_entry_tags() {
        $tags_list = get_the_tag_list( '', _x( '', 'Used between list items, there is a space after the comma.', 'visual-composer-starter' ) );
        if ( $tags_list ) {
            printf( '<div class="entry-tags"><span class="screen-reader-text">%1$s </span>%2$s</div>',
                _x( 'Tags', 'Used before tag names.', 'visual-composer-starter' ),
                $tags_list
            );
        }
    }
endif;

if ( ! function_exists( 'visualcomposerstarter_comment' ) ) :

    function visualcomposerstarter_comment($comment, $args, $depth) {
        if ( 'div' === $args['style'] ) {
            $tag       = 'div';
            $add_below = 'comment';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
        <?php if ( 'div' != $args['style'] ) : ?>
            <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
        <?php endif; ?>
        <div class="author-avatar">
            <div class="fade-in-image">
                <?php if ( $args['avatar_size'] != 0 ): ?>
                    <img src="<?php echo get_avatar_url( $comment, array( 'size' => $args['avatar_size'] ) ); ?>"
                         data-src="<?php echo get_avatar_url( $comment, array( 'size' => $args['avatar_size'] ) ); ?>">
                    <noscript>
                        <img src="<?php echo get_avatar_url( $comment, array( 'size' => $args['avatar_size'] ) ); ?>">
                    </noscript>
                <?php endif; ?>
            </div>
        </div>
        <div class="comment-wrapper">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php printf( __( '%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ); ?>
                </div>
                <div class="comment-metadata">
                    <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                        <?php
                        /* translators: 1: date, 2: time */
                        printf( __('On %1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?>
                    </a>
                    <?php edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
                    <?php if ( $comment->comment_approved == '0' ) : ?>
                        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
                    <?php endif; ?>
                </div>
            </footer>
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div>
        </div>


        <?php if ( 'div' != $args['style'] ) : ?>
            </div>
        <?php endif; ?>
        <?php
    }

endif;
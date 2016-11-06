<?php

if ( ! function_exists( 'visualcomposertheme_post_thumbnail' ) ) :
    function visualcomposertheme_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }
            ?>
            <div class="featured-content">
                <div class="fade-in-img">
                    <?php the_post_thumbnail(); ?>
                    <noscript>
                        <?php the_post_thumbnail(); ?>
                    </noscript>
                </div>
            </div><!-- .post-thumbnail -->
        <?php
    }
endif;

if ( ! function_exists( 'visualcomposertheme_entry_date' ) ) :
    function visualcomposertheme_entry_date() {

        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = get_the_modified_date();
        }
        else {
            $time_string = get_the_date();
        }

         printf( '<li class="entry-meta-date"><a href="%1$s">%2$s</a></li>',
            esc_url( get_permalink() ),
            $time_string
        );
    }
endif;

if ( ! function_exists( 'visualcomposertheme_entry_meta' ) ) :
    function visualcomposertheme_entry_meta() {
        ?>
        <ul class="entry-meta">
            <?php if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ): ?>
                <?php visualcomposertheme_entry_date(); ?>
            <?php endif;?>
            <?php if ( 'post' === get_post_type() ): ?>
                <li class="entry-meta-author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a></li>
            <?php endif; ?>

            <li class="entry-meta-category"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'visual-composer-theme' ) ); ?></li>

            <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
                <li class="entry-meta-comments"><?php comments_popup_link( __( 'Leave a comment', 'visual-composer-theme' ), __( '1 Comment', 'visual-composer-theme' ), __( '% Comments', 'visual-composer-theme' ) ); ?>
            <?php endif; ?>

            </li>
        </ul>
        <?
    }
endif;
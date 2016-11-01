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


if ( ! function_exists( 'visualcomposertheme_entry_meta' ) ) :
    function visualcomposertheme_entry_meta() {
        ?>
        <ul class="entry-meta">
            <li class="entry-meta-date"><a href="#">October 20, 2016</a></li>
            <li class="entry-meta-author"><a href="#">Rice Kellogg</a></li>
            <li class="entry-meta-category"><a href="#">Food</a></li>
            <li class="entry-meta-comments"><a href="#">8 Comments</a></li>
        </ul>
        <?
    }
endif;
<?php

/**
 * Extension Solutions CPT
 * Description: Display the 'Solutions' Custom Post Type
 */

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_action( 'genesis_entry_content', 'agrilife_child_page_list' );

function agrilife_child_page_list() {


    if ( get_field( 'solution-featured-image' ) ) {
        $image = get_field( 'solution-featured-image' );
        $image_src = $image['sizes']['thumbnail'];
        $image_alt = the_title( '', '', false );
    }


    if(get_field('solution-featured-image')) {
        ?> <img src="<?php echo $image_src; ?>" alt="<?php echo $image_alt; ?>" /> <?php
    }
    ?>

    <?php the_field( 'solution-description' ); ?>


    <?php if( have_rows('solution-links') ): ?>
        <h3>Links</h3>
        <ul>
            <?php while( have_rows('solution-links') ): the_row(); ?>
                <li><a href="<?php the_sub_field('url'); ?>" title="<?php the_sub_field('title'); ?>"><?php the_sub_field('title'); ?></a></li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>

    <?php if( have_rows('solution-featured-sites') ): ?>
        <h3>Featured Sites</h3>
        <ul>
            <?php while( have_rows('solution-featured-sites') ): the_row(); ?>
                <li><a href="<?php the_sub_field('url'); ?>" title="<?php the_sub_field('title'); ?>"><?php the_sub_field('title'); ?></a></li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>

    <?php the_field( 'solution-contact-blurb' ); ?>


<?php
}

genesis();
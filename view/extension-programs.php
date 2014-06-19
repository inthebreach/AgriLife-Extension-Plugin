<?php

/**
 * Extension Programs CPT
 * Description: Display the 'Programs' Custom Post Type
 */

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_action( 'genesis_entry_content', 'agrilife_child_page_list' );

function agrilife_child_page_list() {


    if ( get_field( 'program-featured-image' ) ) {
        $image = get_field( 'program-featured-image' );
        $image_src = $image['sizes']['thumbnail'];
        $image_alt = the_title( '', '', false );
    }


    if(get_field('program-featured-image')) {
        ?> <img src="<?php echo $image_src; ?>" alt="<?php echo $image_alt; ?>" /> <?php
    }
    ?>

    <?php the_field( 'program-description' ); ?>


    <?php if( have_rows('program-quick-links') ): ?>
        <h3>Quick Links</h3>
        <ul>
            <?php while( have_rows('program-quick-links') ): the_row(); ?>
                <li><a href="<?php the_sub_field('url'); ?>" title="<?php the_sub_field('title'); ?>"><?php the_sub_field('title'); ?></a></li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>

    <?php if( have_rows('program-featured-sites') ): ?>
        <h3>Featured Sites</h3>
        <ul>
            <?php while( have_rows('program-featured-sites') ): the_row(); ?>
                <li><a href="<?php the_sub_field('url'); ?>" title="<?php the_sub_field('title'); ?>"><?php the_sub_field('title'); ?></a></li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>

    <?php the_field( 'program-contact-blurb' ); ?>

    <?php if( have_rows('program-did-you-know') ): ?>
        <h3>Did you know?</h3>
        <ul>
            <?php while( have_rows('program-did-you-know') ): the_row(); ?>
                <li><?php the_sub_field('fact'); ?></li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>

<?php
}

genesis();
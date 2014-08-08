<?php

/**
 * Extension Solutions CPT
 * Description: Display the 'Solutions' Custom Post Type
 */

remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_entry_footer', 'genesis_post_meta');
remove_action('genesis_entry_header', 'genesis_post_info', 12);


if (is_singular('extension-solutions')) {

    // Left Column
    // Remove the Secondary (left) Sidebar from the Secondary Sidebar area.
    remove_action('genesis_sidebar_alt', 'genesis_do_sidebar_alt');
    // Place the Secondary Sidebar into the Primary Sidebar area.
    add_action('genesis_sidebar_alt', 'ext_do_menu_sidebar');


    // Right Column
    // Remove the default (right) genesis sidebar
    remove_action('genesis_sidebar', 'genesis_do_sidebar');
    // Add the sidebar content
    add_action('genesis_sidebar', 'ext_do_right_sidebar');
    add_action('genesis_sidebar', 'ext_did_you_know');

}



// Breadcrumbs
add_action('genesis_entry_header', 'genesis_do_breadcrumbs');

add_action('genesis_entry_content', 'agrilife_ext_solution_content');


function ext_do_menu_sidebar()
{

    if (is_active_sidebar('solutions-menu-column')) :
        dynamic_sidebar('solutions-menu-column');
    endif;

}


function agrilife_ext_solution_content()
{


    if (get_field('solution-featured-image')) {
        $image = get_field('solution-featured-image');
        $image_src = $image['sizes']['program-solution_single'];
        $image_alt = the_title('', '', false);
    }


    if (get_field('solution-featured-image')) {
        ?> <img src="<?php echo $image_src; ?>" class="solution-featured-image" alt="<?php echo $image_alt; ?>"/> <?php
    }
    ?>

    <?php the_field('solution-description'); ?>


    <?php if (have_rows('solution-links')): ?>
    <!-- <h3>Link Title Blurb</h3> -->
    <div class="solution-links">
        <ul>
            <?php while (have_rows('solution-links')): the_row(); ?>
                <li><a href="<?php the_sub_field('url'); ?>"
                       title="<?php the_sub_field('title'); ?>"><?php the_sub_field('title'); ?></a></li>
            <?php endwhile; ?>
        </ul>
    </div>
<?php endif;


}


// For the Right Sidebar
function ext_do_right_sidebar()
{

    if( $contact_blurb = get_field('solution-contact-blurb') )
    {
        echo '<h4 class="widget-title widgettitle contact-blurb">' . $contact_blurb . '</h4>';
    }

    if (have_rows('solution-featured-sites')):
        echo '<div id="featured-1" class="widget widget_nav_menu"><div class="widget-wrap">';
        echo '<h4 class="widget-title widgettitle">Featured Sites</h4>';
        echo '<div class="menu-container">';
        echo '<ul>';
        while (have_rows('solution-featured-sites')) {
            the_row();
            echo "<li><a href=\"" . get_sub_field('url') . "\" title=\"" . get_sub_field('title') . "\">" . get_sub_field('title') . "</a></li>";
        }
        echo '</ul>';
        echo '</div>';
        echo '</div></div>';
    endif;

}

function ext_did_you_know()
{
    // Did you know
    $args = array(
        'p' => get_field('solution-parent-program'),
        'post_type' => 'extension-programs'
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) {

        while ($query->have_posts()) {

            $query->the_post();
            if ($rows = get_field('program-did-you-know')){
                // Get a random 'fact'
                $row_count = count($rows);
                $i = rand(0, $row_count - 1);
                echo '<div id="text-4" class="widget widget_text">';
                echo '  <div class="widget-wrap">';
                echo '  <h4 class="widget-title widgettitle">Did you know?</h4>';
                echo $rows[$i]['fact'];
                echo '  </div>';
                echo '</div>';
            }
        }

    }
    /* Restore original Post Data */
    wp_reset_postdata();
}


genesis();
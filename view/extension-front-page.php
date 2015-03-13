<?php

/**
 * Extension Solutions CPT
 * Description: Display the 'Solutions' Custom Post Type
 */

remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_entry_footer', 'genesis_post_meta');
remove_action('genesis_entry_header', 'genesis_post_info', 12);


// Left Column
// Remove the Secondary (left) Sidebar from the Secondary Sidebar area.
remove_action('genesis_sidebar_alt', 'genesis_do_sidebar_alt');

// Right Column
// Remove the default (right) genesis sidebar
remove_action('genesis_sidebar', 'genesis_do_sidebar');
// Add the sidebar content
add_action('genesis_sidebar', 'home_right_sidebar');

// Main Content
add_action('genesis_after_header', 'agrilife_ext_home_top', 11);
add_action('genesis_after_header', 'genesis_do_post_content', 12);

add_action('genesis_after_entry', 'agrilife_ext_solution_content');
add_action('genesis_after_entry', 'agrilife_ext_home_program_areas');
// Remove Title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// Add Background Image CSS
add_action('wp_head', 'agrilife_ext_home_background', 99);

/*
 *
 * Replace loop?
 remove_action( 'genesis_loop', 'genesis_do_loop' );
 add_action( 'genesis_loop', 'new_loop_function?' );
 */

function agrilife_ext_home_top()
{
    if ( get_field( 'home-hero-image' ) ) {
        $image = get_field( 'home-hero-image' );
        $image_src = $image['sizes']['home-hero'];
        $image_alt = the_title( '', '', false );
    }

    echo '<div class="home-feature-container">';

    echo '<div class="home-featured-image-container">';
        if(get_field('home-hero-image'))
        {
            ?> <img src="<?php echo $image_src; ?>" class="home-featured-image"  alt="<?php echo $image_alt; ?>" /> <?php
        }
    echo '</div>';

    if(get_field('home-hero-content-area'))
    {
        echo '<div class="home-featured-content">' . get_field('home-hero-content-area') . '</div>';
    }

    echo '</div>';
}

function agrilife_ext_solution_content()
{
    $menu = wp_nav_menu( array('menu' => 'Home Featured Solutions', 'echo' => false ));
    echo '<div class="home-featured-solutions">';
    echo '  <h4><a href="/browse/featured-solutions/" >Browse Featured Solutions</a></h4>';
    echo $menu;

    echo '  ';
    echo '  <div class="request">
                <h5 class="what">Got a Question?</h5>
                <a href="https://ask.extension.org/ask" class="button home-request">Ask an Expert!</a>
            </div>';
    echo '</div>';

}

function agrilife_ext_home_background()
{
    if ( get_field( 'home-background-image' ) ) {
        $image = get_field( 'home-background-image' );
        $image_src = $image['url'];

        echo'
        <style type="text/css" media="screen">
            @media only screen and (min-width: 880px) {
                .home .site-container {
                    background-image: url('.$image_src.') !important;
                }
            }
        </style>';
    }
}

function agrilife_ext_home_program_areas()
{

    echo'

    <div class="programs">

	    <h4 class="program-header">Program Areas</h4>

	    <div class="program-list">

		<div class="single-program">
			<a href="/programs/volunteer-programs/">
				<img src="http://extension.agrilife.org/wp-content/uploads/2014/06/youth.jpg" alt="" class="program-image">
				<h3 class="program-name">Volunteer Programs &gt;</h3>
			</a>
		</div>

		<div class="single-program">
			<a href="/browse/program-areas/">
				<img src="http://extension.agrilife.org/wp-content/uploads/2014/06/anr.jpg" alt="" class="program-image">
				<h3 class="program-name">Agriculture and Natural Resources &gt;</h3>
			</a>
			<p class="program-desc"></p>
		</div>

		<div class="single-program">
			<a href="/programs/community-economic-development/">
				<img src="http://extension.agrilife.org/wp-content/uploads/2014/06/youth2.jpg" alt="" class="program-image">
				<h3 class="program-name">Community Economic Development &gt;</h3>
			</a>
			<p class="program-desc"></p>
		</div>

		<div class="single-program">
			<a href="/programs/family-consumer-sciences/">
				<img src="http://extension.agrilife.org/wp-content/uploads/2014/06/youth4.jpg" alt="" class="program-image">
				<h3 class="program-name">Family and Consumer Sciences &gt;</h3>
			</a>
			<p class="program-desc"></p>
		</div>

	</div>
</div>';


}


// For the Right Sidebar
function home_right_sidebar()
{
    // Home Sidebar Widget Area
    if (is_active_sidebar('home-sidebar')) :
        echo '<div class="home-sidebar">';
        dynamic_sidebar('home-sidebar');
        echo '</div>';
    endif;


}

genesis();
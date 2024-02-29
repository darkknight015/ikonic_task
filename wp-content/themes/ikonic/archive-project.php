<?php
/**
 * Template Name: Project Archive
 * Description: I took the default template and changed the query vars
 * @package Astra
 * @since 1.0.0
 */

get_header();
?>

<div id="primary" <?php astra_primary_class(); ?>>

    <?php astra_primary_content_top(); ?>

    <header class="page-header">
        <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
    </header><!-- .page-header -->

    <div class="project-archive">

        <?php
        // Custom query arguments
        $args = array(
            'post_type'      => 'project',
            'posts_per_page' => 6,
            'paged'          => max( 1, get_query_var('paged') ),
        );

        // Custom query
        $wp_query = new WP_Query( $args );
        if ( $wp_query->have_posts() ) :
            while ( $wp_query->have_posts() ) :
                $wp_query->the_post();
                ?>
                <article <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div><!-- .entry-content -->
                </article><!-- #post-<?php the_ID(); ?> -->
                <?php
            endwhile;

            // Pagination
            $big = 999999999; // need an unlikely integer
            echo paginate_links( array(
                'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'    => '?paged=%#%',
                'current'   => max( 1, get_query_var('paged') ),
                'total'     => $wp_query->max_num_pages,
                'prev_text' => __( 'Previous', 'astra' ),
                'next_text' => __( 'Next', 'astra' ),
            ) );
        else :
            // If no posts are found
            get_template_part( 'template-parts/content', 'none' );
        endif;

        // Reset post data
        wp_reset_postdata();
        ?>

    </div>


    <?php astra_primary_content_bottom(); ?>

</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>
    <?php get_sidebar(); ?>
<?php endif ?>

<?php get_footer(); ?>

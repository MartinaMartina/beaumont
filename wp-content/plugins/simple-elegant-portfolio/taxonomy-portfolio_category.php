<?php get_header(); ?>

<div id="page-wrapper">
    <div class="container">
	
        <?php if(have_posts()): ?>
        
        <?php 
            $current_tax = get_query_var($wp_query->query_vars['taxonomy']);
            $current_tax = get_term_by('slug', $current_tax ,$wp_query->query_vars['taxonomy']);

            $portfolio_classs = array( 'wi-portfolio' );

            // Column
            $column = get_option( 'withemes_portfolio_column' );
            if ( '2' != $column && '4' != $column ) $column = '3';
            $portfolio_classs[] = 'column-' . $column;

            // Style
            $style = get_option( 'withemes_portfolio_item_style' );
            if ( '2' != $style && '3' != $style ) $style = '1';
            $portfolio_classs[] = 'portfolio-style-' . $style;

            // Join
            $portfolio_classs = join( ' ', $portfolio_classs );
        ?>
        
        <div class="catlist-wrapper">
            <div class="row">
                <div class="col col-1-2 content-along">
                    
                    <h1 id="portfolio-category-title"><?php single_term_title(); ?></h1>
                    <?php if ( $current_tax->description ) : ?>
                    <p class="portfolio-category-desc"><?php echo $current_tax->description; ?></p>
                    <?php endif; ?>
                    
                </div><!-- .contennt-along -->
                <div class="col col-1-2 col-cats">
                    <div class="portfolio-catlist">
                        <ul>
                            <?php wp_list_categories('taxonomy=portfolio_category&depth=1&hierarchical=0&title_li=');; ?>
                        </ul>
                    </div>
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .catlist -->
        
        <div class="<?php echo esc_attr( $portfolio_classs ); ?>">
            
            <?php while(have_posts()):the_post();?>
            
                <?php include SIMPLE_ELEGANT_PORTFOLIO_PATH . 'templates/content.php'; ?>
            
            <?php endwhile;//have_posts?>
            
        </div><!-- .wi-portfolio -->
        
        <?php if ( function_exists('withemes_pagination') ) withemes_pagination(); ?>
        
        <?php endif; //have_posts ?>
    
    </div><!-- .container -->
</div><!-- #page-wrapper -->

<?php get_footer(); ?>
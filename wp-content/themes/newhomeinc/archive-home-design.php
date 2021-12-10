<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package New_Home_Inc
 */

get_header();
?>

	<main id="primary" class="site-main">
		    <?php  get_template_part( 'template-parts/components/global/banner/listing/communities/communities');  ?>
		    <?php get_template_part( 'template-parts/components/navigations/search-page-menu');  ?>
		    <?php get_template_part( 'template-parts/components/communities/mobile-filter');  ?>
		    <?php get_template_part( 'template-parts/components/communities/desktop-filter');  ?>
		    <?php get_template_part( 'template-parts/components/communities/filter_results');  ?>

        <div class="container pt-3">
            <div class="row" data-aos="fade-up" data-aos-anchor-placement="top-center" data-aos-offset=600" >
                <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                               <?php get_template_part( 'template-parts/content', 'home_design'); ?>
                       <?php  endwhile; ?>
               <?php  endif;  ?>
            </div>
        </div>
        <?php
            $community_search_page_content_title = get_field('qmi_search_page_content_title_copy2', 'option');
            $community_search_page_content = get_field('qmi_search_page_content', 'option');
        ?>
        <?php if($community_search_page_content && $community_search_page_content_title) : ?>
            <div class="container pt-3 pb-5">
                <section id="search-page-footer-content" data-aos="fade-up">
                    <div class="pattern-bg">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="400" height="400" viewBox="0 0 830 616"><defs><pattern id="a" width="1" height="1" patternTransform="translate(1660 1232) rotate(-180)" viewBox="0 0 830 616"><image preserveAspectRatio="none" width="830" height="616" xlink:href="data:image/png;base64,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ztkGVVvRjvG613ufGh8zXVvRjm7r2Bi9TxgOwQeAd7EXf66226BiL/5czjaoaZNtULEXf66226BiL/5c+0L/seAbw3bGptqG/tp2xmXfz6TxaU/ovz717KPQtzO2cU7oRzgeunfvHpcDwCCqxuXXve5173/++ed/Wbb2qCj+9qkXOXacjz/++D979tln/wcZt4ri7xDZslit5pgf+IEf+PjXv/71fypBb66h+DvE6dm46X0qiuJmRSvP862m4m8fGfu8Cv1FUdysYMrYH/i+BPfiz1RbuV3vGftcVrSD3tbVRe2B0isZ+zTP82X9+xLf6I5zD+Gp7m+vfe1r53/5l38Z3e6F1BB8AAxGCuGPOH/+M1L0q94m4KzqPFX7V+9KYOwXEnDrY/+AxgLI5ZxQNnn3u9+9+9KXvnT1hS98Ya61+HO5of/tb3/7//Ktb33rkS984Qsz2c6ovhCsQv+b3/zmzatf/eoXP/e5z/17UhSrb4qvwu2b3/zm9Q//8A9fPv300xMZu/oHgsrYf6P22+rvdTEj+Hgms4A3J/jYGaGkBp+woijuz/zleZ7MDVG2gbgF8AtlWV6M+JK8kb3g73a/XlmWD+ke9cv2BN5kxm598IMffOfV1dX/9uijj/7r7//+75/92q/92jMBvCwv7Ni/8pWv/DP7td74xje+I6Wxf+hDH3ryy1/+8mftP7/hDW/4hV//9V//w/FflR927F/72tf+xYsvvvj45eXlT6U09izL6oX0R1n1CdfDyyXXxge7BHz37l1bCH3KGPOPjTG/cvfu3fndu3c/e+fOHY5IVKooisndu3c/box5SWaC7ftgcffu3f/rzp07X1E+9su//uu/Xjz33HP3g87jjz/+4je+8Y3P3blzR/W+aDv273znO//hV77ylceq33vsscde/Ku/+qt/lcDYLx566KF/9Oyzz/6d6vde85rXvPTtb3/7/71z5466LW4uO/a7d+/+4yeeeOJ9u93uf33961//mXe84x3/1d27d19KZOy/8sQTT7zn2Wef/cRrX/vaz73jHe/4T+/evXt5584d9ZN8dlLziSee+OWvf/3r/9PDDz/86Xe+85328/3v3r17d3fnzp2XAniJg7ETe0888cTHvva1rxVf//rXv/SzP/uz77PXPZWx/+mf/unPfPvb377fM59l2fc8++yzv6t97LFixWdg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"/></pattern></defs><rect width="830" height="616" fill="url(#a)"/></svg>
                    </div>
                    <div class="container">
                        <div class="footer-content-area">
                            <span class="intro-search-page-sub-title">Discover</span>
                            <h3><?php echo $community_search_page_content_title; ?></h3>
                            <div class="content-area">
					            <?php echo $community_search_page_content; ?>
                            </div>
                        </div>
                    </div>
                </section
            </div>
        <?php endif; ?>
	</main><!-- #main -->

<?php
get_footer();

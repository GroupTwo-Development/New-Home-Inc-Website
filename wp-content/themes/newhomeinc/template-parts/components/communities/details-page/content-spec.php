<?php

    //    $post_community_data = get_post_communities_type('communities', -1);
    global  $count; //Hey WP, refer to that global var in functions!
    $min_array_sqft = [];
    $max_array_sqft = [];
    $array_beds_min = [];
    $array_beds_max= [];
    $array_baths_min = [];
    $array_baths_max = [];
    $array_price = [];
    $array_garage_min = [];
    $array_garage_max = [];

    $coming_soon_community = get_field('coming_soon_community');
    $coming_soon_class = ($coming_soon_community == 'yes') ? ''.'coming_soon_community':'';
    $community_gallery = get_field('gallery');
    $featured_image = get_field('featured_image');
    $call_for_pricing_phone = get_field('phone_number', 'option');
    $comm_banner_announcement = get_field('comm_banner_announcement');

    $community_floorplans = get_field('community_floorplans');
    if($community_floorplans) :
        foreach ($community_floorplans as $plans) :
            $min_bedrooms = get_field('min_bedrooms', $plans->ID);
            array_push($array_beds_min, $min_bedrooms);

            $max_bedrooms = get_field('max_bedrooms', $plans->ID);
            array_push($array_beds_max, $max_bedrooms);

	        $bathroom_group = get_field('bathrooms', $plans->ID);

	        $min_baths = $bathroom_group['min_baths'];
	        array_push($array_baths_min, $min_baths);

	        $max_baths = $bathroom_group['max_baths'];
	        array_push($array_baths_max, $max_baths);


	        $min_half_baths = $bathroom_group['min_half_baths'];
	        $max_half_baths = $bathroom_group['max_half_baths'];

            $base_price = get_field('base_price', $plans->ID);
            array_push($array_price, $base_price);


	        $base_sqft_group = get_field('base_sqft_group', $plans->ID);

	        $min_base_sqft = $base_sqft_group['min_sqft'];
	        array_push($min_array_sqft, $min_base_sqft);

	        $max_base_sqft = $base_sqft_group['max_sqft'];
	        array_push($max_array_sqft, $max_base_sqft);


            $min_garage_data = get_field('min_garage', $plans->ID);
            array_push($array_garage_min, $min_garage_data);

	        $max_garage_data = get_field('max_garage', $plans->ID);
            array_push($array_garage_max, $max_garage_data);
        endforeach;
    endif;

    //TODO Get the average price
    $array_price = array_unique($array_price);
    sort($array_price);
    if(!empty(floatval($array_price))){
        $min_price = min($array_price);
        $average_price = $min_price;
        $max_price = max($array_price);
    }

    $display_average_price = ($min_price) ? '' . esc_html('$') . number_format($average_price):
        '' . '<span class="call-for-pricing">Coming Soon</span>';

    //TODO  Get the min bedrooms
    $array_beds_min = array_unique($array_beds_min);
    sort($array_beds_min);
    if(!empty($array_beds_min)){
        $min_bed = min($array_beds_min);
    }

    $display_min_beds = ($min_bed) ? '' . $min_bed . esc_html('-') : esc_html('-');



    //TODO  Get the max bedrooms
    $array_beds_max = array_unique($array_beds_max);
    sort($array_beds_max);
    if(!empty($array_beds_max)){
        $max_bed = max($array_beds_max);
    }

    $display_max_beds = ($max_bed) ? '' . $max_bed : '';


    //TODO GET MIN BATHS
    $array_baths_min = array_unique($array_baths_min);
    sort($array_baths_min);
    if(!empty($array_baths_min)){
        $min_baths = min($array_baths_min);

    }

    $display_min_baths = (!empty($min_half_baths)) ? '' . $min_baths . esc_html('.5') . esc_html('-') :  $min_baths . esc_html('-');
    $display_only_min_full_half_baths = (!empty($min_half_baths)) ? '' . $min_baths . esc_html('.5') :  $min_baths;


    //TODO GET MAX BATHS
    $array_baths_max = array_unique($array_baths_max);
    sort($array_baths_max);
    if(!empty($array_baths_max)){
        $max_baths = max($array_baths_max);
    }
    $display_max_baths = (!empty($max_half_baths)) ? '' . $max_baths . esc_html('.5') : $max_baths;

    if($min_baths && $max_baths){
        $display_bath = $min_baths . esc_html('-') . $max_baths;
        if($min_half_baths && $max_half_baths){
            $display_bath = $min_baths .  esc_html('.5') . esc_html('-') . $max_baths . esc_html('.5');
        } elseif ($min_half_baths && empty($max_half_baths)){
            $display_bath = $min_baths .  esc_html('.5') . esc_html('-') . $max_baths;
        } elseif ($max_half_baths && empty($min_half_baths)){
            $display_bath = $min_baths . esc_html('-') . $max_baths . esc_html('.5');
        }
    }elseif ($min_baths && empty($max_baths)){
        $display_bath = $min_baths;
        if($min_half_baths){
            $display_bath = $min_baths . esc_html('.5');
        }
    } elseif ($max_baths && empty($min_baths)){
        $display_bath = $max_baths;
        if($max_half_baths) {
            $display_bath = $max_baths . esc_html('.5');
        }
    } else{
        $display_bath = esc_html('-');
    }


    //TODO GET MIN Garage from array
    $array_garage_min = array_unique($array_garage_min);
    sort($array_garage_min);
    if(!empty($array_garage_min)){
        $min_garage = min($array_garage_min);
    }
    $display_min_garage = ($min_garage) ? '' . $min_garage . esc_html('-') : '';

    //TODO GET MAX Garage from array
    $array_garage_max = array_unique($array_garage_max);
    sort($array_garage_max);
    if(!empty($array_garage_max)){
        $max_garage = max($array_garage_max);
    }

    $display_max_garage = ($max_garage) ? '' . $max_garage  : esc_html('-');


    $google_map = get_field( 'subdivision_google_map' );
    if ( $google_map ) :

        $address = '';
        foreach ( array('street_number', 'street_name', 'city', 'state', 'post_code' ) as $i => $k ) {
            $state_name = $google_map['state'];

            if ( isset( $google_map[ $k ] ) ) {
                $address = $google_map['street_number'];
                $address .= ' '.$google_map['street_name'];
                $address .= ', '. $google_map['city'];
                $address .= ', '. convertState($state_name);
                $address .= ' '. $google_map['post_code'];
            }
        }
        $address = trim( $address, ', ' );
    endif;

    $subdescription = get_field('subdescription');

    $community_qmi = get_field('community_homes');

    $community_floorplans = get_field('community_floorplans');


    //TODO GET MIN  sqft
    $min_array_sqft = array_unique($min_array_sqft);
    sort($min_array_sqft);
    if(!empty($min_array_sqft)){
        $min_sqft = min($min_array_sqft);
    }


    //TODO GET MAX  sqft
    $max_array_sqft = array_unique($max_array_sqft);
    sort($max_array_sqft);
    if(!empty($max_array_sqft)){
        $max_sqft = max($max_array_sqft);
    }

    if($min_sqft && $max_sqft){
        $display_sqft = number_format($min_sqft) . esc_html('-') . number_format($max_sqft);
    }elseif (!empty($min_sqft) && empty($max_sqft)){
        $display_sqft = number_format(floatval($min_sqft));
    } elseif ($max_sqft && empty($min_sqft)){
        $display_sqft = number_format($max_sqft);
    } else {
        $display_sqft = esc_html('-');
    }


?>
<?php require_once ('content-coming-soon.php'); ?>
<?php require_once ('main-detail-content.php'); ?>


<div id="main-detail-content-area" data-bs-offset="-500"  data-aos="fade-up" data-aos-duration="900" data-spy="scroll" data-target="#info-links" data-offset="0">
    <div class="container">
        <div class="accordion accordion-flush" id="mainDetailAccordionComponent">
            <?php if($subdescription) : ?>
                <div class="ScrollTarget" id="about-content-area"></div>
                <div class="accordion-item about-content-area" id="">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button btn-text" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                           <span class="accordion-title">About</span>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#mainDetailAccordionComponent">
                        <div class="accordion-body">
                              <section class="about-inner-content">
                                  <header class="accord-header-area">
                                      <h1><?php echo esc_html('About'); ?> <?php the_title(); ?></h1>
                                  </header>
                                  <?php echo $subdescription; ?>
                              </section>
                        </div>
                        <?php
                            $smart_features = get_field('com_smart_features');
                            $new_features = get_field('com_new_features');
                            $healthy_features = get_field('com_healthy_features');

                            if($smart_features && $new_features && $healthy_features )   :
                        ?>
                        <div class="smart-features-accordion pt-4 pb-5">
                            <div class="accordion-body">
                                <header class="accord-header-area-smart">
                                    <h2>Smart. Healthy. New.</h2>
                                </header>
                                <section class="smart-healthy-new-component">
                                    <div class="smart-healthy-new-component-content">
                                        <div class="smart-healthy-new-component-left">
                                            <img src="/wp-content/uploads/2021/11/banner-logo.png" alt="" class="mart-healthy-new-component-logo img-fluid">
                                        </div>
                                        <div class="smart-healthy-new-component-right">
                                            <div class="smart-healthy-new-component-right-content-left">
                                                <div class="smart-healthy-new-component-right-content-top smart-features-items">
                                                    <h6>Smart Features</h6>
								                    <?php

								                    if( $smart_features ): ?>
                                                        <ul>
										                    <?php foreach( $smart_features as $term ): ?>
                                                                <li><?php echo esc_html( $term->name ); ?></li>
										                    <?php endforeach; ?>
                                                        </ul>
								                    <?php endif; ?>
                                                </div>
                                                <div class="smart-healthy-new-component-right-content-bottom smart-features-items">
                                                    <h6>New Features</h6>
								                    <?php

								                    if( $new_features ): ?>
                                                        <ul>
										                    <?php foreach( $new_features as $term ): ?>
                                                                <li><?php echo esc_html( $term->name ); ?></li>
										                    <?php endforeach; ?>
                                                        </ul>
								                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="smart-healthy-new-component-right-content-right">
                                                <div class="smart-healthy-new-component-right-content smart-features-items">
                                                    <h6>Healthy Features</h6>
								                    <?php

								                    if( $healthy_features ): ?>
                                                        <ul>
										                    <?php foreach( $healthy_features as $term ): ?>
                                                                <li><?php echo esc_html( $term->name ); ?></li>
										                    <?php endforeach; ?>
                                                        </ul>
								                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="learn-more-cta">
                                        <a href="/smart-home-tech/">Learn More</a>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($community_qmi) : ?>

                <div class="accordion-item available-homes" id="">
                    <div class="ScrollTarget" id="community_homes"></div>
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed btn-text" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <span class="accordion-title">Available Homes</span>
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse " aria-labelledby="headingThree" data-bs-parent="#mainDetailAccordionComponent">
                    <div class="accordion-body">
                        <header class="accord-header-area">
                            <h2> Available Homes</h2>
                        </header>
	                    <?php

	                    if( $community_qmi ): ?>
                            <div id="card-slider-qmi" class="splide">
                                <div class="splide__track">
                                    <ul class="splide__list">
	                                    <?php foreach ($community_qmi as $post) :  setup_postdata($post); ?>
						                    <?php $spec_data = get_featured_homes_spec();
                                            ?>
                                            <li class="splide__slide">
                                                <div class="card">
                                                    <a href="<?php the_permalink(); ?>">
		                                                <?php if($spec_data['announcement']) : ?>
                                                            <div class="featured-home-announcement-card-banner">
                                                                <span class="banner-announcement"><?php echo $spec_data['announcement'] ?></span>
                                                            </div>
		                                                <?php endif; ?>
                                                        <div class="card-container">
                                                            <div class="featured-home-card-header">
                                                                <div class="card-img">
                                                                    <img  class="img-fluid" src="<?php echo $spec_data['featured_image']['url']; ?>" alt="<?php echo $spec_data['featured_image']['alt']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="card-body-title-price-area">
                                                                    <div class="card-title-area">
                                                                        <h6><?php the_title(); ?></h6>
                                                                        <span class="featured-home-address">
                                                                        <?php echo ($spec_data['spec_city']) ? '' . $spec_data['spec_city'] : '' ?>
                                                                        <?php echo ($spec_data['spec_state']['SubState'] ) ? '' . $spec_data['spec_state']['SubState'] . esc_html(', ') : '' ?>
                                                                        <?php echo ($spec_data['spec_zip']) ? '' . $spec_data['spec_zip'] : '' ?>
                                                                    </span>
                                                                    </div>
                                                                    <div class="featured-home-price">
						                                                <?php
						                                                $price = $spec_data['price'];
						                                                if(empty($price)) :
							                                                $price_empty = 'call-for-pricing';
						                                                endif;
						                                                ?>
                                                                        <span class="price <?php echo $price_empty; ?>"><?php echo (!empty($spec_data['price'])) ? '' . esc_html('$').number_format($spec_data['price'] ) : ' Coming Soon'?></span>

                                                                    </div>
                                                                </div>
                                                                <hr class="featured-homes-hr">
                                                                <div class="card-body-homes-spec">
                                                                    <ul class="card-body-homes-spec-elements">
                                                                        <li>
                                                                            <span class="spec-name">BEDS</span>
                                                                            <span class="spec-data"><?php echo $spec_data['bedrooms'] ?></span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="spec-name">BATHS</span>
							                                                <?php $half_bath = $spec_data['half_bath']; ?>
                                                                            <span class="spec-data"><?php echo $spec_data['baths'] ?><?php echo ($half_bath == 1) ? ''.esc_html('.5') : '' ?></span>
                                                                        </li>
                                                                        <li>
                                                                            <span class="spec-name">SQ FT</span>
                                                                            <span class="spec-data"><?php echo number_format($spec_data['sqft']) ?></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
					                    <?php endforeach; wp_reset_postdata(); ?>
                                    </ul>
                                </div>
                            </div>
	                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

	        <?php if($community_floorplans) : ?>
                <div class="ScrollTarget-2" id="community_floorplans"></div>
                <div class="accordion-item available-floorplans">
                    <h2 class="accordion-header" id="headingfour">
                        <button class="accordion-button collapsed btn-text" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                            <span class="accordion-title">Floorplans</span>
                        </button>
                    </h2>
                    <div id="collapsefour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-bs-parent="#mainDetailAccordionComponent">
                        <div class="accordion-body">
                            <?php require_once ('content-plans.php'); ?>
                        </div>
                    </div>
                </div>
	        <?php endif; ?>

	        <?php
                $video_community = get_field('video_community');
                if($video_community):
            ?>
                <div id="community_video" class="accordion-item community-video">
                    <h2 class="accordion-header" id="headingfive">
                        <button class="accordion-button collapsed btn-text" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
                            <span class="accordion-title">Video</span>
                        </button>
                    </h2>
                    <div id="collapsefive" class="accordion-collapse collapse" aria-labelledby="headingfive" data-bs-parent="#mainDetailAccordionComponent">
                        <div class="accordion-body">
                            <header class="accord-header-area">
                                <h2> Video</h2>
                            </header>
	                        <?php

                                preg_match('/src="(.+?)"/', $video_community, $matches_url );
                                $src = $matches_url[1];

                                preg_match('/embed(.*?)?feature/', $src, $matches_id );
                                $id = $matches_id[1];
                                $id = str_replace( str_split( '?/' ), '', $id );
	                        ?>
                            <section class="video-component">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="community_video-component">
                                                <a
                                                        href="#"
                                                        data-lg-size="1280-720"
                                                        data-src="//www.youtube.com/watch?v=<?php echo $id; ?>"
                                                        data-poster="https://img.youtube.com/vi/<?php echo $id; ?>/maxresdefault.jpg"
                                                        data-sub-html="<h4>New Home Inc. - Video Gallery  |  Welcome to New Home Inc.</p>"
                                                >
                                                    <img
                                                            class="img-fluid"
                                                            src="https://img.youtube.com/vi/<?php echo $id; ?>/maxresdefault.jpg"
                                                            alt=""
                                                    />
                                                    <div class="overlay-area">
                                                        <span class="overlay-title"><i class="far fa-play-circle"></i></span>
                                                    </div>
                                                </a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
	        <?php endif; ?>


            <?php
                $community_lot_map_group = get_field('community_lot_map');
                $community_lot_map_image = $community_lot_map_group['community_lot_map_image'];
                $community_lot_map_url = $community_lot_map_group['community_lot_map_url'];
            ?>
            <?php if($community_lot_map_image && $community_lot_map_url) : ?>
                <div id="community-lot" class="accordion-item community-lot">
                    <h2 class="accordion-header" id="headingsix">
                        <button class="accordion-button collapsed btn-text" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix">
                            <span class="accordion-title">Community Map</span>
                        </button>
                    </h2>
                    <div id="collapsesix" class="accordion-collapse collapse" aria-labelledby="headingsix" data-bs-parent="#mainDetailAccordionComponent">
                        <div class="accordion-body">
                            <header class="accord-header-area">
                                <h2> Community Map</h2>
                            </header>
                            <div class="community_map-component">

                                <a
                                    href="<?php echo $community_lot_map_url?>"
                                    target="_blank"
                                >
                                    <img
                                            class="img-fluid"
                                            src="<?php echo $community_lot_map_image['url']; ?>"
                                            alt="<?php echo $community_lot_map_image['alt']; ?>"
                                    />
                                    <div class="overlay-area">
                                        <span class="overlay-title">Click to view current site availability.</span>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


	        <?php $location = get_field('subdivision_google_map'); ?>
	        <?php if($location) : ?>
                <?php require_once ('content-map.php'); ?>
	        <?php endif; ?>
        </div>
    </div>
</div>


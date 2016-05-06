<?php
	function get_subscription_details() {
		$sweepstakes_trial_key = esc_attr( get_post_meta( $_POST[ 'postId' ], 'sweepstakes_trial_key', true ) ) 
			? : 'two-week-free-trial'; 
		$subscription_trial = null;
		
		if ( function_exists( 'load_slp_by_trial' ) ) {
			$subscription_trial = load_slp_by_trial( $sweepstakes_trial_key );
		}

		$trial_period = 14;

		require_once 'cls/common.php';
		$services = new Services( $GLOBALS[ 'serverUrl' ] );
		
		$country = esc_attr( get_post_meta( $_POST[ 'postId' ], 'sweepstakes_country', true ) ) 
			? : 'usa'; 

		if ( '' == $country ) {
			$geoLocation = new Common( $services );
			$geoLocation->init( [ 'srv' => 'common', 'act' => 'getCountry' ] );
			$country = $geoLocation->execPost();
		}

		if ( function_exists( 'load_promotion' ) ) {
			$promotion          = load_promotion();
			$subscription_price = $promotion[ 'promo_get_price_with_coupon' ];
		} else {
			$promotion = null;
			$subscription_price = 'price_' . strtolower( $country );
			$subscription_price = $subscription_trial[ 'subscription_details' ][ $subscription_price ];
		}

		$kaltura_id = 'kaltura_id_' . strtolower( $country );
		$kaltura_id = $subscription_trial[ 'subscription_details' ][ $kaltura_id ];

		$promo_details = [
			'kalturaId'	        => $kaltura_id,
			'country'           => $country,
			'coupon'            => $promotion[ 'promotion_code' ],
			'subscriptionPrice' => $subscription_price
		];

		echo json_encode( $promo_details );
		die();
	}

	add_action( 'wp_ajax_get_subscription_details', 'get_subscription_details' );
	add_action( 'wp_ajax_nopriv_get_subscription_details', 'get_subscription_details' );

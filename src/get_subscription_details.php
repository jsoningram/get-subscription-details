<?php
	function get_subscription_details() {
		$product_id = esc_attr( get_post_meta( 
			$_POST[ 'postId' ], 'product_id', true ) ) 
			? : 'Fallback'; 

		$product_rate_plan_id = esc_attr( get_post_meta( 
			$_POST[ 'postId' ], 'product_rate_plan_id', true ) ) 
			? : 'Fallback'; 

		$product_rate_plan_charge_id = esc_attr( get_post_meta( 
			$_POST[ 'postId' ], 'product_rate_plan_charge_id', true ) ) 
			? : 'Fallback'; 

		$coupon = esc_attr( get_post_meta( 
			$_POST[ 'postId' ], 'coupon', true ) ) 
			? : 'Fallback'; 

		$promo_details = [
			'productId'	              => $product_id,
			'productRatePlanId'       => $product_rate_plan_id,
			'productRatePlanChargeId' => $product_rate_plan_charge_id,
			'sweepstakesCoupon'       => $coupon
		];

		echo json_encode( $promo_details );
		die();
	}

	add_action( 'wp_ajax_get_subscription_details', 'get_subscription_details' );
	add_action( 'wp_ajax_nopriv_get_subscription_details', 'get_subscription_details' );

<?php
/**
 * Restaurant menu widget template.
 *
 * @package WPRestaurantMenu
 *
 * @var array $settings Widget settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$menu_items     = ! empty( $settings['menu_items'] ) && is_array( $settings['menu_items'] ) ? $settings['menu_items'] : array();
$image_position = ! empty( $settings['image_position'] ) && 'right' === $settings['image_position'] ? 'right' : 'left';
?>
<div class="wprm-menu wprm-menu--image-<?php echo esc_attr( $image_position ); ?>">
	<?php foreach ( $menu_items as $index => $item ) : ?>
		<?php
		$title        = isset( $item['title'] ) ? sanitize_text_field( $item['title'] ) : '';
		$description  = isset( $item['description'] ) ? wp_kses_post( $item['description'] ) : '';
		$price        = isset( $item['price'] ) ? wp_kses_post( $item['price'] ) : '';
		$product_id   = ! empty( $item['product_id'] ) ? absint( $item['product_id'] ) : 0;
		$is_sold_out  = false;

		if ( $product_id && function_exists( 'wc_get_product' ) ) {
			$product = wc_get_product( $product_id );
			if ( $product ) {
				$is_sold_out = ! $product->is_in_stock();
			}
		}

		if ( ! $product_id ) {
			$is_sold_out = ! empty( $item['inventory_status'] ) && 'sold_out' === $item['inventory_status'];
		}

		$image_id     = ! empty( $item['image']['id'] ) ? absint( $item['image']['id'] ) : 0;
		$image_url    = ! empty( $item['image']['url'] ) ? esc_url( $item['image']['url'] ) : '';
		$item_url     = ! empty( $item['link']['url'] ) ? esc_url( $item['link']['url'] ) : '';
		$item_classes = array( 'wprm-menu__item' );

		if ( $is_sold_out ) {
			$item_classes[] = 'is-sold-out';
		}

		$item_label = $title ? $title : sprintf(
			/* translators: %d: menu item number. */
			esc_html__( 'Menu item %d', 'wp-restaurant-menu' ),
			absint( $index + 1 )
		);
		?>
		<article class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>" <?php echo $is_sold_out ? 'aria-disabled="true"' : ''; ?>>
			<?php if ( $image_id || $image_url ) : ?>
				<figure class="wprm-menu__image">
					<?php if ( $item_url && ! $is_sold_out ) : ?>
						<a href="<?php echo esc_url( $item_url ); ?>" <?php echo ! empty( $item['link']['is_external'] ) ? 'target="_blank"' : ''; ?> <?php echo ! empty( $item['link']['nofollow'] ) ? 'rel="nofollow noopener"' : 'rel="noopener"'; ?> aria-label="<?php echo esc_attr( sprintf( __( 'View %s', 'wp-restaurant-menu' ), $item_label ) ); ?>">
					<?php endif; ?>
						<?php
						if ( $image_id ) {
							echo wp_get_attachment_image(
								$image_id,
								'medium',
								false,
								array(
									'alt'     => esc_attr( $item_label ),
									'loading' => 'lazy',
								)
							);
						} elseif ( $image_url ) {
							?>
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $item_label ); ?>" loading="lazy">
							<?php
						}
						?>
					<?php if ( $item_url && ! $is_sold_out ) : ?>
						</a>
					<?php endif; ?>
				</figure>
			<?php endif; ?>

			<div class="wprm-menu__content">
				<header class="wprm-menu__header">
					<h3 class="wprm-menu__title">
						<?php if ( $item_url && ! $is_sold_out ) : ?>
							<a href="<?php echo esc_url( $item_url ); ?>" <?php echo ! empty( $item['link']['is_external'] ) ? 'target="_blank"' : ''; ?> <?php echo ! empty( $item['link']['nofollow'] ) ? 'rel="nofollow noopener"' : 'rel="noopener"'; ?>><?php echo esc_html( $title ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $title ); ?>
						<?php endif; ?>
					</h3>
					<span class="wprm-menu__separator" aria-hidden="true"></span>
					<?php if ( $price ) : ?>
						<span class="wprm-menu__price"><?php echo wp_kses_post( $price ); ?></span>
					<?php endif; ?>
				</header>

				<?php if ( $is_sold_out ) : ?>
					<span class="wprm-menu__sold-out-badge"><?php echo esc_html__( 'Sold Out', 'wp-restaurant-menu' ); ?></span>
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<div class="wprm-menu__description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
				<?php endif; ?>
			</div>
		</article>
	<?php endforeach; ?>
</div>

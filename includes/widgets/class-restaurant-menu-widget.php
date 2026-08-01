<?php
/**
 * Restaurant Menu Elementor widget.
 *
 * @package WPRestaurantMenu
 */

namespace WPRestaurantMenu\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Restaurant menu widget.
 */
class Restaurant_Menu_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'wprm_restaurant_menu';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Restaurant Menu', 'wp-restaurant-menu' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-menu-card';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array
	 */
	public function get_categories() {
		return array( 'wp-restaurant-menu' );
	}

	/**
	 * Get style dependencies.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'wprm-restaurant-menu' );
	}

	/**
	 * Get script dependencies.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'wprm-restaurant-menu' );
	}

	/**
	 * Register widget controls.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	/**
	 * Register content controls.
	 *
	 * @return void
	 */
	private function register_content_controls() {
		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'Content', 'wp-restaurant-menu' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'image_position',
			array(
				'label'   => esc_html__( 'Image Position', 'wp-restaurant-menu' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => esc_html__( 'Left', 'wp-restaurant-menu' ),
					'right' => esc_html__( 'Right', 'wp-restaurant-menu' ),
				),
			)
		);

		$this->end_controls_section();

		$repeater = new Repeater();

		$repeater->add_control(
			'price',
			array(
				'label'       => esc_html__( 'Price', 'wp-restaurant-menu' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '$20', 'wp-restaurant-menu' ),
				'label_block' => false,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'wp-restaurant-menu' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'First item on the list', 'wp-restaurant-menu' ),
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'wp-restaurant-menu' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'wp-restaurant-menu' ),
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Image', 'wp-restaurant-menu' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'wp-restaurant-menu' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => '#',
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'product_id',
			array(
				'label'       => esc_html__( 'Inventory Product', 'wp-restaurant-menu' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'options'     => $this->get_product_options(),
				'description' => esc_html__( 'Select the WooCommerce product used to check stock status.', 'wp-restaurant-menu' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->start_controls_section(
			'section_list',
			array(
				'label' => esc_html__( 'List', 'wp-restaurant-menu' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'menu_items',
			array(
				'label'       => esc_html__( 'List Items', 'wp-restaurant-menu' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $this->get_default_items(),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register style controls.
	 *
	 * @return void
	 */
	private function register_style_controls() {
		$this->start_controls_section(
			'section_container_style',
			array(
				'label' => esc_html__( 'Container', 'wp-restaurant-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'container_background',
				'selector' => '{{WRAPPER}} .wprm-menu',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .wprm-menu',
			)
		);

		$this->add_responsive_control(
			'container_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} .wprm-menu',
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => esc_html__( 'Padding', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_margin',
			array(
				'label'      => esc_html__( 'Margin', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_item_style',
			array(
				'label' => esc_html__( 'Menu Item', 'wp-restaurant-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'item_background',
				'selector' => '{{WRAPPER}} .wprm-menu__item',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'item_border',
				'selector' => '{{WRAPPER}} .wprm-menu__item',
			)
		);

		$this->add_responsive_control(
			'item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'item_box_shadow',
				'selector' => '{{WRAPPER}} .wprm-menu__item',
			)
		);

		$this->add_responsive_control(
			'item_padding',
			array(
				'label'      => esc_html__( 'Padding', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'item_margin',
			array(
				'label'      => esc_html__( 'Margin', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'item_gap',
			array(
				'label'      => esc_html__( 'Item Gap', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 28,
				),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_gap',
			array(
				'label'      => esc_html__( 'Image/Content Gap', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 18,
				),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu__item' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			array(
				'label' => esc_html__( 'Title', 'wp-restaurant-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'wp-restaurant-menu' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .wprm-menu__title, {{WRAPPER}} .wprm-menu__title a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'selector'       => '{{WRAPPER}} .wprm-menu__title, {{WRAPPER}} .wprm-menu__title a',
				'fields_options' => array(
					'font_family'    => array(
						'default' => 'Oswald',
					),
					'font_size'      => array(
						'default' => array(
							'unit' => 'px',
							'size' => 25,
						),
					),
					'font_weight'    => array(
						'default' => '800',
					),
					'text_transform' => array(
						'default' => 'uppercase',
					),
					'line_height'    => array(
						'default' => array(
							'unit' => 'em',
							'size' => 1.1,
						),
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_description_style',
			array(
				'label' => esc_html__( 'Description', 'wp-restaurant-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Color', 'wp-restaurant-menu' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .wprm-menu__description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'description_typography',
				'selector'       => '{{WRAPPER}} .wprm-menu__description',
				'fields_options' => array(
					'font_size'   => array(
						'default' => array(
							'unit' => 'px',
							'size' => 20,
						),
					),
					'font_weight' => array(
						'default' => '500',
					),
					'line_height' => array(
						'default' => array(
							'unit' => 'em',
							'size' => 1.5,
						),
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price_style',
			array(
				'label' => esc_html__( 'Price', 'wp-restaurant-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'Color', 'wp-restaurant-menu' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d63f4c',
				'selectors' => array(
					'{{WRAPPER}} .wprm-menu__price, {{WRAPPER}} .wprm-menu__price *' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'price_typography',
				'selector'       => '{{WRAPPER}} .wprm-menu__price, {{WRAPPER}} .wprm-menu__price *',
				'fields_options' => array(
					'font_family' => array(
						'default' => 'Oswald',
					),
					'font_size'   => array(
						'default' => array(
							'unit' => 'px',
							'size' => 25,
						),
					),
					'font_weight' => array(
						'default' => '800',
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_style',
			array(
				'label' => esc_html__( 'Image', 'wp-restaurant-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => esc_html__( 'Width', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'rem' ),
				'range'      => array(
					'px' => array(
						'min' => 24,
						'max' => 400,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 150,
				),
				'selectors' => array(
					'{{WRAPPER}} .wprm-menu__image' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_height',
			array(
				'label'      => esc_html__( 'Height', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'rem' ),
				'range'      => array(
					'px' => array(
						'min' => 24,
						'max' => 400,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 150,
				),
				'selectors' => array(
					'{{WRAPPER}} .wprm-menu__image' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'rem' ),
				'default'    => array(
					'top'      => 8,
					'right'    => 8,
					'bottom'   => 8,
					'left'     => 8,
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu__image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu__item' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_badge_style',
			array(
				'label' => esc_html__( 'Sold Out Badge', 'wp-restaurant-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'badge_background_color',
			array(
				'label'     => esc_html__( 'Background', 'wp-restaurant-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wprm-menu__sold-out-badge' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'badge_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'wp-restaurant-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wprm-menu__sold-out-badge' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'badge_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu__sold-out-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'badge_padding',
			array(
				'label'      => esc_html__( 'Padding', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu__sold-out-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .wprm-menu__sold-out-badge',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_divider_style',
			array(
				'label' => esc_html__( 'Divider', 'wp-restaurant-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'divider_color',
			array(
				'label'     => esc_html__( 'Color', 'wp-restaurant-menu' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d6a900',
				'selectors' => array(
					'{{WRAPPER}} .wprm-menu__separator' => 'border-bottom-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'divider_thickness',
			array(
				'label'      => esc_html__( 'Thickness', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 2,
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu__separator' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'divider_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'wp-restaurant-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 9,
				),
				'selectors'  => array(
					'{{WRAPPER}} .wprm-menu__header' => 'column-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget.
	 *
	 * @return void
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		include WPRM_PATH . 'templates/restaurant-menu.php';
	}

	/**
	 * Get published WooCommerce products for the inventory selector.
	 *
	 * @return array
	 */
	private function get_product_options() {
		$options = array(
			'' => esc_html__( 'Select Product', 'wp-restaurant-menu' ),
		);

		if ( ! function_exists( 'wc_get_products' ) ) {
			return $options;
		}

		$products = wc_get_products(
			array(
				'status'  => 'publish',
				'limit'   => -1,
				'orderby' => 'title',
				'order'   => 'ASC',
				'return'  => 'objects',
			)
		);

		foreach ( $products as $product ) {
			if ( $product instanceof \WC_Product ) {
				$options[ $product->get_id() ] = $product->get_name();
			}
		}

		return $options;
	}

	/**
	 * Get default menu items.
	 *
	 * @return array
	 */
	private function get_default_items() {
		return array(
			array(
				'title'            => esc_html__( 'Combo Chicken Plate', 'wp-restaurant-menu' ),
				'description'      => esc_html__( 'Your choice of any two chicken meats (curry chicken, brown stew, jerked chicken or jerked wings).', 'wp-restaurant-menu' ),
				'price'            => esc_html__( '$21.95 - $24.95', 'wp-restaurant-menu' ),
				'link'             => array(
					'url' => '#',
				),
				'product_id'       => '',
				'inventory_status' => 'in_stock',
			),
			array(
				'title'            => esc_html__( 'Jerk Chicken', 'wp-restaurant-menu' ),
				'description'      => esc_html__( 'Marinated in jerk seasoning and special spices to achieve the legendary jerk flavor.', 'wp-restaurant-menu' ),
				'price'            => esc_html__( '$15.95 - $17.95', 'wp-restaurant-menu' ),
				'link'             => array(
					'url' => '#',
				),
				'product_id'       => '',
				'inventory_status' => 'in_stock',
			),
			array(
				'title'            => esc_html__( 'Brown Stew Chicken', 'wp-restaurant-menu' ),
				'description'      => esc_html__( 'Tender chicken richly marinated and then stewed in brown gravy.', 'wp-restaurant-menu' ),
				'price'            => esc_html__( '$15.95 - $18.95', 'wp-restaurant-menu' ),
				'link'             => array(
					'url' => '#',
				),
				'product_id'       => '',
				'inventory_status' => 'in_stock',
			),
		);
	}
}

<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.passagenspromo.com.br/
 * @since      1.0.0
 *
 * @package    Passagens_Promo
 * @subpackage Passagens_Promo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Passagens_Promo
 * @subpackage Passagens_Promo/public
 * @author     2XT <plugins@2xt.com.br>
 */
class Passagens_Promo_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $options
	 */
	private $options;

	/**	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $option_name
	 */
	private $option_name = 'passagens_promo';

	/**	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $broker_api
	 */
	private $broker_api='https://broker.passagenspromo.com.br/pquery/';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->options = get_option('passagens_promo');
		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function passagens_promo_public_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the scripts for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function passagens_promo_public_enqueue_scripts() {
		wp_register_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/public.js');

		wp_localize_script(
			$this->plugin_name,
			'passagens_promo',
			array(
				'plugin_dir' => plugin_dir_url(__FILE__),
				'page_width' => $this->options['page_width']
			)
		);

		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/public.js',
			array(), $this->version,
			'all'
		);
	}


	public function passagens_promo_public_add_shortcodes(){
		add_shortcode('ppromo_passagens', array($this, $this->option_name . '_display_shortcode'));
	}


	public function amp_inline_css(){
		include_once('css/public.css');
	}


	public function import_ampbind_dependency(){
		$link = '<script async custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script>
				<script async custom-element="amp-list" src="https://cdn.ampproject.org/v0/amp-list-0.1.js"></script>
				<script async custom-template="amp-mustache" src="https://cdn.ampproject.org/v0/amp-mustache-0.1.js"></script>
				<script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
				<script async custom-element="amp-selector" src="https://cdn.ampproject.org/v0/amp-selector-0.1.js"></script>';
		print(esc_html($link));
	}


	public function passagens_promo_display_shortcode($attrs=array()){
		global $post;
		global $widget;

		$passagens_promo_public_path = plugin_dir_url(__FILE__);
		$passagens_promo_options = $this->options;

		// TEMPLATE VARIABLES
		$header_text = isset($attrs['header_text']) && $attrs['header_text'] != '' ? $attrs['header_text'] : '';

		if (isset($attrs['alteroriginallowed']) && $attrs['alteroriginallowed'] != '')
			$alteroriginallowed = $attrs['alteroriginallowed'];
		else if (!isset($attrs['origin']))
			$alteroriginallowed = 'enabled';

		$show_logo = false;
		if (isset($attrs['show_logo']) && $attrs['show_logo'] == true)
			$show_logo = true;

		$request_data = $this->format_req_url($attrs);
		$utm_params_str = $request_data['utm_params'];
		$data = json_decode(wp_remote_retrieve_body(wp_remote_get($request_data['req_url'])), true);
		$req_origin_mask = explode('##', $request_data['req_wildcard']);

		ob_start();
		if(
			( (isset($_GET['amp']) ) || (preg_match('/\/amp\//', $_SERVER['REQUEST_URI'] )) )
		) {
			include('partials/passagens-promo-shortcode-amp-display.php');
		}else{
			include('partials/passagens-promo-shortcode-display.php');
		}

		$content = ob_get_clean();

		return $content;
	}


	private function format_req_url($attrs){
		$req_url = $this->broker_api;
		$req_wildcard = $req_url;

		$url_params = array(
			'origin' => '@',
			'destination' => '',
			'month' => '',
			'z_limit' => '',
			'preset_date' => '',
			'airline_code' => ''
		);


		if (isset($attrs['origin']))
			$url_params['origin'] .= $attrs['origin'];
		if (isset($attrs['destination']))
			$url_params['destination'] = '--@' . $attrs['destination'];
		if (isset($attrs['airline_code']))
			$url_params['airline_code'] = '+CODE_' . $attrs['airline_code'];
		if (isset($attrs['preset_date']))
			$url_params['preset_date'] =  '+DT_' . $attrs['preset_date'];

		// Month is only set if preset date is empty
		if (isset($attrs['month']) && $url_params['preset_date'] == '')
			$url_params['month'] = '+DTM_' . $attrs['month'];

		// if destination is not set, zlimit will bet set to 2
		if (isset($attrs['z_limit']))
			$url_params['z_limit'] = '+ZLIMIT_' . $attrs['z_limit'];
		else if (!isset($attrs['destination']) || $attrs['destination']== '')
			$url_params['z_limit'] = '+ZLIMIT_1';

		// GET_REQUEST PARAMETERS
		$req_params['limit'] = isset($attrs['limit']) && is_numeric($attrs['limit']) ? $attrs['limit'] : 6;
		$req_params['max_age'] = isset($attrs['max_age']) && $attrs['max_age'] != '' ? $attrs['max_age'] : '';

		// PARTNER LINK PARAMETERS
		$utm_params['utm_medium'] = 'afiliado';
		$utm_params['utm_source'] = 'wp_plugin';
		$utm_params['pcrid'] = $this->options['affiliate_id'];
		$utm_params['pcrtt'] = isset($attrs['tags']) ? $attrs['tags'] : '';

		foreach ($url_params as $params => $v) {
			$req_url .= $v;
			if($params == 'origin')
				$req_wildcard .= '##';
			else
				$req_wildcard .= $v;
		}

		foreach ($req_params as $field => $v) {
			if ($req_params[$field] == '')
				unset($req_params[$field]);
		}

		foreach ($utm_params as $field => $v) {
			if ($utm_params[$field] == '')
				unset($utm_params[$field]);
		}

		$req_url .= '?' . http_build_query($req_params);
		$req_wildcard .= '?' . http_build_query($req_params);
		$utm_params_str = http_build_query($utm_params);

		return array('req_url' => $req_url, 'utm_params' => $utm_params_str, 'req_wildcard' => ($url_params['origin'] == '@') ? $req_wildcard : '');
	}

	private function transform_month_pt_br($month_number) {
		if ($month_number >= 1 && $month_number <= 12) {
			$month_name = array('Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');
			return $month_name[$month_number - 1];
		} else return '';
	}
}

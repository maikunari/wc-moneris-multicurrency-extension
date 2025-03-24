/**
 * Main class for Moneris Multicurrency functionality
 *
 * @package WC_Moneris_Multicurrency_Extension
 */

defined('ABSPATH') || exit;

/**
 * Class WC_Moneris_Multicurrency
 */
class WC_Moneris_Multicurrency {
    /**
     * Single instance of the class
     *
     * @var WC_Moneris_Multicurrency|null
     */
    protected static $instance = null;

    /**
     * Supported currencies
     *
     * @var array
     */
    protected $supported_currencies = array('CAD', 'USD');

    /**
     * Returns single instance of the class
     *
     * @return WC_Moneris_Multicurrency
     */
    public static function get_instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->init_hooks();
    }

    /**
     * Initialize hooks
     */
    protected function init_hooks() {
        // Add settings to Moneris gateway
        add_filter('woocommerce_settings_api_form_fields_moneris', array($this, 'add_multicurrency_settings'));
        
        // Filter currency options
        add_filter('woocommerce_currency', array($this, 'maybe_convert_currency'));
        
        // Filter payment gateway to handle multicurrency
        add_filter('woocommerce_payment_gateways', array($this, 'maybe_modify_gateway'));
    }

    /**
     * Add multicurrency settings to Moneris gateway
     *
     * @param array $form_fields Existing form fields.
     * @return array Modified form fields.
     */
    public function add_multicurrency_settings($form_fields) {
        $currency_settings = array(
            'multicurrency_enabled' => array(
                'title'       => __('Enable Multicurrency', 'wc-moneris-multicurrency-extension'),
                'type'        => 'checkbox',
                'label'       => __('Enable multicurrency support', 'wc-moneris-multicurrency-extension'),
                'default'     => 'no',
                'description' => __('Allow customers to pay in different currencies.', 'wc-moneris-multicurrency-extension'),
            ),
            'supported_currencies' => array(
                'title'       => __('Supported Currencies', 'wc-moneris-multicurrency-extension'),
                'type'        => 'multiselect',
                'class'       => 'wc-enhanced-select',
                'css'         => 'width: 400px;',
                'default'     => array('CAD'),
                'options'     => array(
                    'CAD' => __('Canadian Dollar (CAD)', 'wc-moneris-multicurrency-extension'),
                    'USD' => __('US Dollar (USD)', 'wc-moneris-multicurrency-extension'),
                ),
                'description' => __('Select which currencies you want to support.', 'wc-moneris-multicurrency-extension'),
            ),
        );

        return array_merge($form_fields, $currency_settings);
    }

    /**
     * Convert currency if needed
     *
     * @param string $currency Current currency.
     * @return string Modified currency.
     */
    public function maybe_convert_currency($currency) {
        // Add currency conversion logic here
        return $currency;
    }

    /**
     * Modify gateway for multicurrency support
     *
     * @param array $gateways Available gateways.
     * @return array Modified gateways.
     */
    public function maybe_modify_gateway($gateways) {
        // Add gateway modification logic here
        return $gateways;
    }
}

// Initialize the class
WC_Moneris_Multicurrency::get_instance(); 
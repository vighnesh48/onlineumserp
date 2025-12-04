<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Mylibrary {

	/**
	 * Calendar layout template
	 *
	 * @var mixed
	 */
	public $template = '';

	/**
	 * Replacements array for template
	 *
	 * @var array
	 */
	public $replacements = array();

	/**
	 * Day of the week to start the calendar on
	 *
	 * @var string
	 */
	public $start_day = 'sunday';

	/**
	 * How to display months
	 *
	 * @var string
	 */
	public $month_type = 'long';

	/**
	 * How to display names of days
	 *
	 * @var string
	 */
	public $day_type = 'abr';

	/**
	 * Whether to show next/prev month links
	 *
	 * @var bool
	 */
	public $show_next_prev = FALSE;

	/**
	 * Url base to use for next/prev month links
	 *
	 * @var bool
	 */
	public $next_prev_url = '';

	/**
	 * Show days of other months
	 *
	 * @var bool
	 */
	public $show_other_days = FALSE;

	// --------------------------------------------------------------------

	/**
	 * CI Singleton
	 *
	 * @var object
	 */
	protected $CI;

	// --------------------------------------------------------------------

	/**
	 * Class constructor
	 *
	 * Loads the calendar language file and sets the default time reference.
	 *
	 * @uses	CI_Lang::$is_loaded
	 *
	 * @param	array	$config	Calendar options
	 * @return	void
	 */
	public function __construct($config = array())
	{
		$this->CI =& get_instance();
		$this->CI->lang->load('calendar');

		empty($config) OR $this->initialize($config);

		log_message('info', 'Calendar Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize the user preferences
	 *
	 * Accepts an associative array as input, containing display preferences
	 *
	 * @param	array	config preferences
	 * @return	CI_Calendar
	 */
	public function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$this->$key = $val;
			}
		}

		// Set the next_prev_url to the controller if required but not defined
		if ($this->show_next_prev === TRUE && empty($this->next_prev_url))
		{
			$this->next_prev_url = $this->CI->config->site_url($this->CI->router->class.'/'.$this->CI->router->method);
		}

		return $this;
	}
	// send sms
	public function sendSms($mob='', $sms_message='')
	{		
		/*$curl = curl_init('http://123.63.33.43/blank/sms/user/urlsms.php');
		curl_setopt($curl, CURLOPT_POST, 1);

		curl_setopt($curl, CURLOPT_POSTFIELDS, "username=sandipfoundationnsk&pass=sandip@123&senderid=SANDIP&dest_mobileno=$mob&msgtype=UNI&message=$sms_message&response=Y");
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($curl);*/
		 $ch = curl_init();
		$sms=urlencode($sms_message);
		$query="?username=SANDIP03&password=SANDIP@2018&from=SANDIP&to=$mob&text=$sms&coding=0";

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL,'http://49.50.67.32/smsapi/httpapi.jsp' . $query); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		  $res = trim(curl_exec($ch));

			if ($res === FALSE) {
			   echo  $res=  'fail';
			} else {
			   echo $res= 'success';
			}
     
        curl_close($ch); 
		return $res;
	}

}

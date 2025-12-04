<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Calendar Class
 *
 * This class enables the creation of calendars
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/calendar.html
 */
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
		$curl = curl_init('http://123.63.33.43/blank/sms/user/urlsms.php');
		curl_setopt($curl, CURLOPT_POST, 1);

		curl_setopt($curl, CURLOPT_POSTFIELDS, "username=sandipfoundationnsk&pass=sandip@123&senderid=SANDIP&dest_mobileno=$mob&msgtype=UNI&message=$sms_message&response=Y");
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($curl);
		return $res;
	}

}

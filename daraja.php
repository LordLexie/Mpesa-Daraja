<?php

class mpesa
{
	private $consumer_key;		// @param - your applications consumer key
	private $consumer_secret;	// @param - your applications secret key
	private $shortCode;			// @param - your Paybill or Till Number

	function __construct()		// Initialize the properties
	{
		$this->consumer_key  	 = "XXXXXXXXXXXXXXX";	// Replace with your consumer key
		$this->consumer_secret 	 = "xxxxxxxxxxxXXXX";	// Replace with your secret key
		$this->shortCode 		 = "xxxxxxXXXXXXXXX";	// Replace with your short code
	}

	// Generate app credentials
	public function app_credentials()
	{

		$consumer_key = $this->consumer_key;
		$consumer_secret = $this->consumer_secret;
		$credentials = base64_encode($consumer_key.':'.$consumer_secret);

		return $credentials;

	}

	// Generate Access tokens
	public function access_tokens()
	{
		$consumer_key = $this->consumer_key;
		$consumer_secret = $this->consumer_secret;
		$credentials = $this->app_credentials();
		$url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode($consumer_key.':'.$consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curl_response = curl_exec($curl);

        return json_decode($curl_response)->access_token;
	}

	// Register url 
	public function register_url($confirmationUrl,$validationUrl)
	{
		$access_token = $this->access_tokens();
		$shortCode = $this->shortCode;
		$url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token));//setting custom header


		$curl_post_data = array(
	  //Fill in the request parameters with valid values
	  'ShortCode' => $shortCode,
	  'ResponseType' => 'Confirmed',
	  'ConfirmationURL' => $confirmationUrl,
	  'ValidationURL' => $validationUrl
	);

	$data_string = json_encode($curl_post_data);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

	$curl_response = curl_exec($curl);
	print_r($curl_response);

	echo $curl_response;
	}

}

?>
<?php

class Marketing_email extends MX_Controller {
		
	private 
		$_order_id   = FALSE,
		$_order_info = FALSE,
		$_response   = array(
			'success' => 0,
			'errors'  => array(),
			'data'    => array()
		);

	function __construct()
	{

		parent::__construct();

		$key = $this->input->post('api_key');
		$this->_verify_key($key);

		$id = $this->input->post('order_id');
		$this->_set_vars($id);

	}

	function _verify_key($key)
	{

		if ($key !== 'CE2_stUswutrAbTrawrE9A86teD'):

			$this->_response['success']  = FALSE;
			$this->_response['errors'][] = 'Invalid API Key';
			return;

		endif;
	}

	function index()
	{

		$this->_response = array(
			'success' => 1,
			'errors'  => array(),
			'data'    => array('No marketing email lists set up')
		);

		$data['response'] = $this->_response;

		$this->load->view('json', $data);

		return;

	}

	function add_contact_to_list()
	{

		if (count($this->_response['errors'])):

			return $this->index();

		endif;

		# Need to detect where the order is in the queue and add the appropriate list
		return $this->add_dropoff();
		return $this->add_client();
	}

	function add_dropoff()
	{

		return $this->index();

	}

	function add_client()
	{

		return $this->index();
	}


	function _set_vars($id)
	{

		if ($id):

			$this->_order_id = $id;

		endif;

		if ( ! $this->_order_id):

			$this->_response['success']  = FALSE;
			$this->_response['errors'][] = 'Invalid Order ID';
			return;

		endif;

		$o_info = $this->platform->post(
			'ubersmith/order/get',
			array(
				'order_id' => $this->_order_id
			)
		);

		if ( ! $o_info['success']):

			$this->_response['success']  = FALSE;
			$this->_response['errors'][] = 'Unable to retrieve order info';
			return;

		endif;

		$this->_order_info = $o_info['data'];

	}

}
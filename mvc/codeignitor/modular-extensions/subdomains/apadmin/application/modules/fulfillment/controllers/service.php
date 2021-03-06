<?php 

class Service extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * This page adds a service to the system
	 */
	public function errors($pack_id=FALSE)
	{
		// initialize variables
		$data	= array();

		// grab errors
		$errors = $this->platform->post('fulfillment/errors/get',array('brand' => 'allphase','type' => 'service','_id' => $pack_id));

		// if no errors, set variable to empty array
		if ( ! $errors['success'] OR empty($errors['data']))
			$errors	= array('data' => array());

		// set template layout to use
		$this->template->set_layout('default');

		// set data variables
		$data['errors']	= $errors['data'];

		// load view
		$this->template->build('fulfillment/service/errors', $data);
	}

	public function queue()
	{		
		// initialize variables
		$data	= array();
		
		// grab pages
		$queue	= $this->platform->post('fulfillment/fulfill/searchpacks',array('where' => array('active' => 0)));
		
		
		// set template layout to use
		$this->template->set_layout('default');
		
		// set the page's title
		$this->template->title('All Phase Partner Queue');
		
		// append custom css
		$this->template->append_metadata('<link rel="stylesheet" href="/resources/modules/pages/assets/css/style.css">');
		$this->template->append_metadata('<link rel="stylesheet" href="/resources/modules/pages/assets/css/button.css">');
		$this->template->prepend_footermeta('<script type="text/javascript" src="/resources/modules/service/assets/js/notes.js"></script>');

		// set data variables
		$data['queue']	= $queue['data'];	// The available pages
		
		// load view
		$this->template->build('fulfillment/service/queue', $data);
	}

	public function dismiss($error_id=FALSE)
	{
		// if no error id, return back to error queue
		if ( ! $error_id OR ! is_numeric($error_id))
			redirect('fulfillment/service/error');

		// grab error information
		$error 	= $this->platform->post('fulfillment/errors/get',array('brand' => 'allphase','type' => 'service','id' => $error_id));

		// if unable to grab error, then we were unable to re-fulfill
		if ( ! $error['success'] OR empty($error['data']))
			show_error('Unable to grab error information in order to re-fulfill.  Error ID: '.$error_id);

		// dismiss the error
		$dismiss 	= $this->platform->post('fulfillment/errors/dismiss',array('id' => $error_id, 'user_id' => $this->session->userdata('login_id')));

		// if there was an error, display it
		if ( ! $dismiss['success'] AND isset($dismiss['error']))
			show_error('There was an error dismissing the error: '.$dismiss['error']);

		// we need to re-run fulfillment for this item
		$fulfill 	= $this->platform->post('fulfillment/fulfill/item/service/'.$error['data'][0]['_id']);

		// if fulfillment was successful, we need to mark as fulfilled in Jamie's database table
		if ($fulfill['success'])
			$this->platform->post('fulfillment/cron/package/markfulfilled',array('pack_id' => $error['data'][0]['_id']));

		// return to errors page
		redirect($this->config->item('subdir').'/fulfillment/service/errors');
	}

	public function close($error_id=FALSE)
	{
		// if no error id, return back to error queue
		if ( ! $error_id OR ! is_numeric($error_id))
			redirect('fulfillment/service/error');

		// grab error information
		$error 	= $this->platform->post('fulfillment/errors/get',array('brand' => 'allphase','type' => 'service','id' => $error_id));

		// if unable to grab error, then we were unable to close
		if ( ! $error['success'] OR empty($error['data']))
			show_error('Unable to grab error information in order to close.  Error ID: '.$error_id);

		// close the error
		$close 	= $this->platform->post('fulfillment/errors/close',array('id' => $error_id, 'user_id' => $this->session->userdata('login_id')));

		// if there was an error, display it
		if ( ! $close['success'] AND isset($close['error']))
			show_error('There was an error closing the error: '.$close['error']);

		// mark as fulfilled in Jamie's table
		$mark  = $this->platform->post('fulfillment/cron/package/markfulfilled',array('pack_id' => $error['data'][0]['_id']));

		// if we made it here, then things were successful
		redirect($this->config->item('subdir').'/fulfillment/service/errors');	
	}

}
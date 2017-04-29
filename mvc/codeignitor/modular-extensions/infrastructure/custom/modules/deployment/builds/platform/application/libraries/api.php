<?php

/**
 * API
 * 
 * This class formats api responses into a standard format.
 * @version	1.0	July 28,2012
 * 
 * @method array	response(boolean $success, array $data)
 * @method array	obj_to_arr(object|array $obj)
 * @method string	query_string(array $arr)
 * 
 */
class Api
{
	
	/**
	 * Formats into standard API output
	 * 
	 * This method formats a response into the standard API output
	 * 
	 * @access	public
	 * 
	 * @example	response(TRUE,array('variable' => 'value'));
	 * 
	 * @param	boolean	$success	The success value of the response
	 * @param	array	$data		The data/error to be passed back depending on the $success 
	 * 
	 * @return	array
	 */
	public function response($success=TRUE, $data=array())
	{
		// initialize variables
		$response = array();
		
		// set success variable (make === TRUE OR FALSE)
		$response['success']	= ($success)
			? TRUE
			: FALSE;
		
		// set error variable (depending on whether success or not)
		$response['error']		= ($success == TRUE)
			? array()
			: $data;
			
		// set data variable (depending on whether success or not)
		$response['data']		= ($success == TRUE)
			? $data
			: array(); 
			
		// return the formatted output
		return $response;
	}

	/**
	 * API Error Handling
	 * 
	 * This method writes an error to the return value and sends it to output for object passed ot it (eg: the api controllers $this object)
	 * 
	 * @access	public
	 * 
	 * @example	error_handling($this,'This is my error message')
	 * 
	 * @param	object	$obj	This is the object of the file calling this function
	 * @param	string	$error	This is the error message to be displayed
	 * 
	 * @return	json
	 */	
	function error_handling($obj,$error)
	{
		// set error
		$obj->_response	= $this->response(0, $error);
		
		// run object's index (to return json output)
		return $obj->index();
	}
	
}

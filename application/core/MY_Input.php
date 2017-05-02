<?php 
class MY_Input extends CI_Input 
{
	/**
	 * Clear the URL Characters
	 * @see CI_Input::_clean_input_keys()
	 */
    function _clean_input_keys($str, $fatal = TRUE)
    {
       if ( ! preg_match('/^[a-z0-9:_\/|-]+$/i', $str))
        {
                if ($fatal === TRUE)
                {
                        return FALSE;
                }
                else
                {
                        set_status_header(503);
                        echo 'Disallowed Key Characters.';
                        exit(7); // EXIT_USER_INPUT
                }
        }
        // Clean UTF-8 if supported
        if (UTF8_ENABLED === TRUE)
        {
            $str = $this->uni->clean_string($str);
        }
     
        return $str;
    }
    
    /**
     * Check if the request is ajax request
     * @return boolean if the request is ajax request
     */
	
	public function isAjaxRequest()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest';
	}
	
	/**
	 * Returns the named POST parameter value.
	 * If the POST parameter does not exist, the second parameter to this method will be returned.
	 * @param string $name the POST parameter name
	 * @param mixed $defaultValue the default parameter value if the POST parameter does not exist.
	 * @return mixed the POST parameter value
	 * @see getParam
	 * @see getQuery
	 */
	public function getPost($name, $defaultValue=null, $xss_clean=TRUE)
	{
		return isset($_POST[$name]) ? $this->post($name, $xss_clean) : $defaultValue;
	}
	
	/**
	 * Returns the named GET or POST parameter value.
	 * If the GET or POST parameter does not exist, the second parameter to this method will be returned.
	 * If both GET and POST contains such a named parameter, the GET parameter takes precedence.
	 * @param string $name the GET parameter name
	 * @param mixed $defaultValue the default parameter value if the GET parameter does not exist.
	 * @return mixed the GET parameter value
	 * @see getQuery
	 * @see getPost
	 */
	public function getParam($name, $defaultValue=null, $xss_clean=TRUE)
	{
		return isset($_GET[$name]) ? $this->get($name, $xss_clean) : (isset($_POST[$name]) ? $this->post($name, $xss_clean) : $defaultValue);
	}
}
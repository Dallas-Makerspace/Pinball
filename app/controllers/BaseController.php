<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
        
            public function mimeToExt($mime)
    {
        if($mime == "image/jpeg"):
            return ".jpg";
        elseif($mime == "image/gif"):
            return ".gif";
        elseif($mime == "image/png"):
            return ".png";
        else:
            throw new Exception("Bad Image Mime Type");
        endif;
            
    }

}
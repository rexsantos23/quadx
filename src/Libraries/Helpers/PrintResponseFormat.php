<?php

namespace Libraries\Helpers;

use Libraries\Interfaces\ResponseFormat;

class PrintResponseFormat implements ResponseFormat
{
	public function format($data)
	{
		var_dump($data);
	}
}
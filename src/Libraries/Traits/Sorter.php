<?php

namespace Libraries\Traits;

trait Sorter
{
	public function sort($key)
	{
		return function ($a, $b) use ($key) {
        	return strnatcmp($a[$key], $b[$key]);
    	};
	}
}
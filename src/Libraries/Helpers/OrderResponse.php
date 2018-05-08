<?php

namespace Libraries\Helpers;

class OrderResponse
{

	public function format($data)
	{
		
		return $this->html($data);
		
	}

	public function html(array $data)
	{
		$output = '';

		for ($i=0; $i < count($data) ; $i++) { 

			if(isset($data[$i]))
			{

				foreach ($data[$i] as $key => $value) {

					//var_dump($key);
					if($key == 'tracking_number'){
						$output .= PHP_EOL . $value;

					}

					if($key == 'status'){
						$output .= ' (' .$value  .')'. PHP_EOL;
					}

					if($key == 'history')
					{
						$output .= 'history: ' . PHP_EOL;
						foreach ($value as $key => $val) {
							$output .= $val . ': ' . $key .PHP_EOL;
						}
					}

					if($key == 'breakdown')
					{
						$output .= 'breakdown: ' .PHP_EOL;
						foreach ($value as $key => $val) {
							$output .= $key . ': ' . $val .PHP_EOL;
						}
					}

					if($key == 'fees')
					{
			
						$output .= 'fees: ' . PHP_EOL;
						foreach ($value as $key => $val) {
							$output .= $key . ': ' . $val .PHP_EOL;
						}
					}
				}
			}
			
		}

		if($data['total'])
		{
			
			$output .= PHP_EOL . 'total collections: ' . $data['total'] . PHP_EOL;
		} 

		if($data['sales'])
		{
			$output .= 'total sales: ' . $data['sales'] . PHP_EOL;
		}

		return $output;

	}
}
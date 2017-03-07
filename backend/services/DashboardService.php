<?php

namespace backend\services;

class DashboardService {

	public function result()
	{

		$result = [
			'visitorGraph'  => $this->visitorGraph(),
			'isOnline' 		=> $this->isOnline(),
			'registerToday' => $this->registerToday(),
			'messageToday' 	=> $this->messageToday(),
		];
		// var_dump($result);exit;
		return $result;
	}	

	private function visitorGraph()
	{
		return json_encode([
			[ 'date' => '1 Januari', 'item1' => rand(1,9999)],
			[ 'date' => '2 Januari', 'item1' => rand(1,9999)],
			[ 'date' => '3 Januari', 'item1' => rand(1,9999)],
			[ 'date' => '4 Januari', 'item1' => rand(1,9999)],
			[ 'date' => '5 Januari', 'item1' => rand(1,9999)],
			[ 'date' => '6 Januari', 'item1' => rand(1,9999)],
			[ 'date' => '7 Januari', 'item1' => rand(1,9999)],
			[ 'date' => '8 Januari', 'item1' => rand(1,9999)],
			[ 'date' => '9 Januari', 'item1' => rand(1,9999)],
			[ 'date' => '10 Januari', 'item1' => rand(1,9999)]
		]);
	}

	private function isOnline() { return rand(1,99); }

	private function registerToday() { return rand(1,99); }
	
	private function messageToday() { return rand(1,99); }
}
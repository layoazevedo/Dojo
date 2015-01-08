<?php

namespace Dojo;

class TradutorTelefone
{
	private $depara = [
		2 => "ABC",
		3 => "DEF",
		4 => "GHI",
		5 => "JKL",
		6 => "MNO",
		7 => "PQRS",
		8 => "TUV",
		9 => "WXYZ"
	];

	public function translate($input) {
        if (is_string($input)) {
			return (int) $this->handleString($input);
		}

		return false;
	}

	private function handleString($input)
	{
		$numeros = null;
		for ( $i=0 ; $i < strlen($input) ; $i++ ) {
			foreach ($this->depara as $key => $value) {
				if (strstr($value, strtoupper($input[$i]))) {
					$numeros .= $key;
				}
			}
		}
		return $numeros;
	}
}

<?php

/**
 * The function stored
 * 
 * @since 1.0.0
 * @version 1.0.0
 * @author Cak Adi <cakadi190@gmail.com>
 */

/**
 * Abbrevating for large number length function
 * 
 * @see https://www.solusilain.com/solusi-menyingkat-format-angka-ribuan-rb-jutaan-jt-dst-di-php/
 * @author SolusiLain.com 
 */
function numberAbbr($n, $precission = 1)
{
	if ($n < 999) {
		$numbers = number_format($n, $precission);
		$simbol = '';
	} else if ($n < 999999) {
		$numbers = number_format($n / 1000, $precission);
		$simbol = 'K';
	} else if ($n < 999999999) {
		$numbers = number_format($n / 1000000, $precission);
		$simbol = 'M';
	} else if ($n < 999999999999) {
		$numbers = number_format($n / 1000000000, $precission);
		$simbol = 'B';
	} else {
		$numbers = number_format($n / 1000000000000, $precission);
		$simbol = 'T';
	}
 
	if ( $precission > 0 ) {
		$pisah = '.' . str_repeat( '0', $precission );
		$numbers = str_replace( $pisah, '', $numbers );
	}
	
	return $numbers . $simbol;
}
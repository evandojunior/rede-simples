<?php


define('ASN_UNIVERSAL', 0x00);
define('ASN_APPLICATION', 0x40);
define('ASN_CONTEXT', 0x80);
define('ASN_PRIVATE', 0xC0);

define('ASN_PRIMITIVE', 0x00);
define('ASN_CONSTRUCTOR', 0x20);

define('ASN_LONG_LEN', 0x80);
define('ASN_EXTENSION_ID', 0x1F);
define('ASN_BIT', 0x80);

define('ASN_BOOLEAN', 1);
define('ASN_INTEGER', 2);
define('ASN_BIT_STR', 3);
define('ASN_OCTET_STR', 4);
define('ASN_NULL', 5);
define('ASN_OBJECT_ID', 6);
define('ASN_REAL', 9);
define('ASN_ENUMERATED', 10);
define('ASN_RELATIVE_OID', 13);
define('ASN_SEQUENCE', 48);
define('ASN_SET', 49);
define('ASN_PRINT_STR', 19);
define('ASN_IA5_STR', 22);
define('ASN_UTC_TIME', 23);
define('ASN_GENERAL_TIME', 24);


class ASN1 {

	/**
	 * Parse an ASN.1 binary string.
	 * 
	 * This function takes a binary ASN.1 string and parses it into it's respective
	 * pieces and returns it.  It can optionally stop at any depth.
	 *
	 * @param	string	$string		The binary ASN.1 String
	 * @param	int	$level		The current parsing depth level
	 * @param	int	$maxLevel	The max parsing depth level
	 * @return	array	The array representation of the ASN.1 data contained in $string
	 */
	public static function parseASNString($string=false, $level=1, $maxLevels=false){
		$parsed = array();
		if ($level>$maxLevels && $maxLevels) return $string;
		$endLength = strlen($string);
		$bigLength = $length = $type = $dtype = $p = 0;
		while ($p<$endLength){
			$type = ord($string[$p++]);
			$dtype = ($type & 192) >> 6;
			if ($type==0){ // if we are type 0, just continue
			} else {
				$length = ord($string[$p++]);
				if (($length & ASN_LONG_LEN)==ASN_LONG_LEN){
					$tempLength = 0;
					for ($x=0; $x<($length & (ASN_LONG_LEN-1)); $x++){
						$tempLength = ord($string[$p++]) + ($tempLength * 256);
					}
					$length = $tempLength;
				}
				$data = substr($string, $p, $length);
				$parsed[] = self::parseASNData($type, $data, $level, $maxLevels);
				$p = $p + $length;
			}
		}
		return $parsed;
	}

	/**
	 * Parse an ASN.1 field value.
	 * 
	 * This function takes a binary ASN.1 value and parses it according to it's specified type
	 *
	 * @param	int	$type		The type of data being provided
	 * @param	string	$data		The raw binary data string
	 * @param	int	$level		The current parsing depth
	 * @param	int	$maxLevels	The max parsing depth
	 * @return	mixed	The data that was parsed from the raw binary data string
	 */
	public static function parseASNData($type, $data, $level, $maxLevels){
		$type = $type%50; // strip out context
		switch ($type){
			default:
				return array($type, $data);
			case ASN_BOOLEAN:
				return array($type, (bool)$data);
			case ASN_INTEGER:
				return array($type, ord($data));
			case ASN_BIT_STR:
				return array($type, $data);
			case ASN_OCTET_STR:
				return array($type, $data);
			case ASN_NULL:
				return array($type, null);
			case ASN_REAL:
				return array($type, $data);
			case ASN_ENUMERATED:
				return array($type, self::parseASNString($data, $level+1, $maxLevels));
			case ASN_RELATIVE_OID: // I don't really know how this works and don't have an example :-)
						// so, lets just return it ...
				return array($type, $data);
			case ASN_SEQUENCE:
				return array($type, self::parseASNString($data, $level+1, $maxLevels));
			case ASN_SET:
				return array($type, self::parseASNString($data, $level+1, $maxLevels));
			case ASN_PRINT_STR:
				return array($type, $data);
			case ASN_IA5_STR:
				return array($type, $data);
			case ASN_UTC_TIME:
				return array($type, $data);
			case ASN_GENERAL_TIME:
				return array($type, $data);
			case ASN_OBJECT_ID:
				return array($type, self::parseOID($data));
		}
	}

	/**
	 * Parse an ASN.1 OID value.
	 * 
	 * This takes the raw binary string that represents an OID value and parses it into its
	 * dot notation form.  example - 1.2.840.113549.1.1.5
	 * look up OID's here: http://www.oid-info.com/
	 * (the multi-byte OID section can be done in a more efficient way, I will fix it later)
	 *
	 * @param	string	$data		The raw binary data string
	 * @return	string	The OID contained in $data
	 */
	public static function parseOID($string){
		$ret = floor(ord($string[0])/40).".";
		$ret .= (ord($string[0]) % 40);
		$build = array();
		$cs = 0;	
		
		for ($i=1; $i<strlen($string); $i++){
			$v = ord($string[$i]);
			if ($v>127){
				$build[] = ord($string[$i])-ASN_BIT;
			} elseif ($build){
				// do the build here for multibyte values
				$build[] = ord($string[$i])-ASN_BIT;
				// you know, it seems there should be a better way to do this...
				$build = array_reverse($build);
				$num = 0;
				for ($x=0; $x<count($build); $x++){
					$mult = $x==0?1:pow(256, $x);
					if ($x+1==count($build)){
						$value = ((($build[$x] & (ASN_BIT-1)) >> $x)) * $mult;
					} else {
						$value = ((($build[$x] & (ASN_BIT-1)) >> $x) ^ ($build[$x+1] << (7 - $x) & 255)) * $mult;
					}
					$num += $value;
				}
				$ret .= ".".$num;
				$build = array(); // start over
			} else {
				$ret .= ".".$v;
				$build = array();
			}
		}
		return $ret;
	}

	/**
	 * Encode data using DER encoding rules.
	 * 
	 * This takes data in the same form returned by ASN1::parseASNString() and returns the DER encoded
	 * string that represents it.  It has been tested to return the same binary string as openSSL when
	 * operating with the same input.
	 *
	 * @param	array	$encode		The specially formatted array of data to encode
	 * @return	string	The binary string representation of the supplied data
	 */
	public static function DEREncodeFormatted($encode, $root=true){
		$output = "";
		$encode = $root ? array($encode) : $encode;
		foreach ($encode as $item){
			$output .= chr($item[0]);
			$value = self::createDERValue($item[0], $item[1]);
			$length = strlen($value);
			$output .= self::createDERLength($length);
			$output .= $value;
		}
		return $output;
	}

	/**
	 * Encode a value in DER form
	 * 
	 * This encodes data into a DER value for a given data type
	 *
	 * @param	int	$type		The type of data being supplied
	 * @param	mixed	$data		The data to encode
	 * @return	string	The binary string representation of the supplied data encoded as the supplied type
	 */
	public static function createDERValue($type, $data){
		switch ($type){
			case ASN_BOOLEAN:
				return (bool)$data?chr(1):chr(0);
			case ASN_INTEGER:
				return chr($data);
			case ASN_BIT_STR:
				return $data;
			case ASN_OCTET_STR:
				return $data;
			case ASN_NULL:
				return null;
			case ASN_REAL:
				return $data;
			case ASN_ENUMERATED:
				return self::DEREncodeFormatted($data, false);
			case ASN_RELATIVE_OID: // I don't really know how this works and don't have an example :-)
						// so, lets just return it ...
				return $data;
			case ASN_SEQUENCE:
				return self::DEREncodeFormatted($data, false);
			case ASN_SET:
				return self::DEREncodeFormatted($data, false);
			case ASN_PRINT_STR:
				return $data;
			case ASN_IA5_STR:
				return $data;
			case ASN_UTC_TIME:
				return $data;
			case ASN_GENERAL_TIME:
				return $data;
			case ASN_OBJECT_ID:
				return self::createDEROID($data);
		}
	}

	/**
	 * Create the binary form of a dot-notated OID
	 * 
	 * This takes a dot-notated OID like "1.2.840.113549.1.1.5" and returns the binary string representation
	 * of that OID adhering to DER.
	 *
	 * @param	string	$dotNotedOID	The OID to encode
	 * @return	string	The binary string representation of the supplied OID
	 */
	public static function createDEROID($dotNotatedOID){
		$pieces = explode(".", $dotNotatedOID);
		switch ($pieces[0]){
			case 2:
				$oid = chr($pieces[1] | 0x40);
				break;
			case 1:
			default:
				$oid = chr($pieces[1]);
				break;
		}
		$oid = chr((40 * $pieces[0]) + $pieces[1]);
		for ($i=2; $i<count($pieces); $i++){
			$current = (int)$pieces[$i];
			if ($current-1 > ASN_BIT){
				$add = chr($current % ASN_BIT);
				$current = floor($current / ASN_BIT);
				while ($current > 127){
					$add = chr(($current % ASN_BIT) | ASN_BIT).$add;
					$current = floor($current / ASN_BIT);
				}
				$add = chr(($current % ASN_BIT) | ASN_BIT).$add;
				$oid .= $add;
			} else {
				$oid .= chr($current);
			}
		}
		return $oid;
	}

	/**
	 * Creates the binary string representing the length of a DER value
	 * 
	 * This takes an int value and encodes it using DER
	 *
	 * @param	int	$length		The length to encode
	 * @return	string	The binary string representation of the supplied length
	 */
	public static function createDERLength($length){
		if ($length+1 < ASN_LONG_LEN){
			return chr($length);
		} else {
			$out = '';
			while ($length > 256){
				$out = chr($length%256).$out;
				$length = floor($length/256);
			}
			$out = chr($length).$out;
			$out = chr(ASN_LONG_LEN | strlen($out)).$out;
			return $out;
		}
	}

}





<?php

function get_algo($miner, $flag = NULL) {
	if($miner!='ccminer'){
		switch($miner){
			case 'claymore': $algo = 'DaggerHash';
				break;
			case 'ethminer': $algo = 'DaggerHash';
				break;
			case 'ewbf-zcash': $algo = 'EquiHash';
				break;
			case 'claymore-zcash': $algo = 'EquiHash';
				break;
			case 'sgminer-gm-xmr': $algo = 'CryptoNight';
				break;
			case 'optiminer-zcash': $algo = 'EquiHash';
				break;
			case 'cgminer-skein': $algo = 'Skein-SHA2';
				break;
			case 'sgminer-gm': $algo = 'Scrypt';
				break;
			/*case '': $algo = '';
				break;
			*/
			default: $algo = $miner;
		}	
		
	}else{
		switch($flag){
      
			case 'bastion' : $algo = 'Hefty bastion';
				break;
			case 'bitcore' : $algo = 'Timetravel-10';
				break;
			case 'blake'   : $algo = 'Blake 256 (SFR)';
				break;
			case 'blake2s' : $algo = 'Blake2-S 256 (NEVA)';
				break;
			case 'blakecoin' : $algo = 'Fast Blake 256';
				break;
			case 'bmw'       : $algo = 'BMW 256';
				break;
			case 'cryptolight' : $algo = 'AEON';
				break;
			case 'cryptonight' : $algo = 'XMR cryptonight';
				break;
			case 'c11/flax'  :  $algo = 'X11 variant';
				break;
			case 'decred'  :  $algo = 'Decred Blake256';
				break;
			case 'deep' :  $algo = 'Deepcoin';
				break;
			case 'equihash'  : $algo = 'Equihash';
				break;
			case 'dmd-gr' :  $algo = 'Diamond-Groestl';
				break;
			case 'fresh'  :  $algo = 'Freshcoin';
				break;
			case 'fugue256'  : $algo = 'Fuguecoin';
				break;
			case 'groestl'  :  $algo = 'Groestlcoin';
				break;
			case 'heavy' :  $algo = 'Heavycoin';
				break;
			case 'hmq1725' :  $algo = 'Doubloons/Espers';
				break;
			case 'jha'  :   $algo = 'JackpotCoin';
				break;
			case 'keccak' : $algo =  'Keccak-256';
				break;
			case 'lbry'  :  $algo = 'LBRY';
				break;
			case 'luffa'  :  $algo = 'Joincoin';
				break;
			case 'lyra2'  : $algo =  'CryptoCoin';
				break;
			case 'lyra2v2' : $algo = 'VertCoin';
				break;
			case 'lyra2z'  : $algo = 'ZeroCoin';
				break;
			case 'mjollnir' : $algo = 'Mjollnircoin';
				break;
			case 'myr-gr' : $algo = 'Myriad-Groestl';
				break;
			case 'neoscrypt' : $algo = 'Neoscrypt';
				break;
			case 'nist5' :  $algo =  'NIST5';
				break;
			case 'penta' : $algo =  'Pentablake';
				break;
			case 'quark' : $algo = 'Quark';
				break;
			case 'qubit' : $algo =  'Qubit';
				break;
			case 'sha256d' : $algo =  'Bitcoin';
				break;
			case 'sha256t' : $algo =  'SHA256 x3';
				break;
			case 'sia' : $algo = 'SIA';
				break;
			case 'sib' : $algo = 'Sibcoin';
				break;
			case 'scrypt' : $algo = 'Scrypt';
				break;
			case 'scrypt-jane' : $algo = 'Scrypt Chacha';
				break;
			case 'skein'  : $algo = 'Skein SHA2';
				break;
			case 'skein2'  : $algo = 'Woodcoin';
				break;
			case 'skunk' : $algo = 'Skein Cube';
				break;
			case 's3'  : $algo = 'S3';
				break;
			case 'timetravel' : $algo = 'Machinecoin';
				break;
			case 'tribus' : $algo =  'Denerius';
				break;
			case 'vanilla'  : $algo = 'Blake256';
				break;
			case 'veltor' : $algo =  'Thorsriddle';
				break;
			case 'whirlcoin' : $algo =  'Old Whirlcoin';
				break;
			case 'whirlpool' : $algo =  'Whirlpool';
				break;
			case 'x11evo'  : $algo =    'Revolver';
				break;
			case 'x11'     : $algo =    'X11';
				break;
			case 'x13'     : $algo =    'X13';
				break;
			case 'x14'     : $algo =    'X14';
				break;
			case 'x15'     : $algo =    'X15';
				break;
			case 'x17'     : $algo =    'X17';
				break;
			case 'wildkeccak' : $algo =  'Boolberry';
				break;
			case 'zr5' : $algo =  'ZR5';
				break;
			default: $algo = $miner; 
		}
				
	}
	
	return $algo;
}
?>
<?php
  /*
  * PHP-Implementierung der SHA-512 Hash-Funktion nach FIPS PUB 180-2
  * Version 1.00 Copyright Sirke Reimann 2008
  */
  
  /*
  * Erstellen eines 64-Bit-Wortes aus zwei 32-Bit-Wörtern
  *
  * @param int $high: Höchstwertiges 32-Bit-Wort
  * @param int $low: Niedrigstwertiges 32-Bit-Wort
  *
  * @return array: Array-basiertes 64-Bit-Wort
  */
  function int64( $high, $low )
  {
    return array( 'high' => $high, 'low' => $low );
  }
  
  /*
  * Sicheres addieren eines Arrays von 64-Bit-Wörtern
  *
  * @param array $arr: Array von 64-Bit-Datenwörtern
  *
  * @return array: Summe der 64-Bit-Wörter als 64-Bit-Wort
  */
  function safeadd64( $arr )
  {
    $low_lsw = 0;
    $low_msw = 0;
    $high_lsw = 0;
    $high_msw = 0;
    for( $i = 0; $i < sizeof( $arr ); $i++ )
    {
      $low_lsw += $arr[$i]['low'] & 0x0000FFFF;
      $low_msw += ( $arr[$i]['low'] >> 16 ) & 0x0000FFFF;
      $high_lsw += $arr[$i]['high'] & 0x0000FFFF;
      $high_msw += ( $arr[$i]['high'] >> 16 ) & 0x0000FFFF;
    }
    $low_msw += ( $low_lsw >> 16 ) & 0x0000FFFF;
    $high_lsw += ( $low_msw >> 16 ) & 0x0000FFFF;
    $high_msw += ( $high_lsw >> 16 ) & 0x0000FFFF;
    
    $low = ( ( ( $low_msw & 0xFFFF ) << 16 ) & 0xFFFF0000 ) | ( $low_lsw & 0xFFFF );
    $high = ( ( ( $high_msw & 0xFFFF ) << 16 ) & 0xFFFF0000 ) | ( $high_lsw & 0xFFFF );
    
    return int64( $high, $low );
  }
  
  /*
  * Berechnung des SHA-512 Hashwertes aus 32-Bit-Wörtern
  *
  * @param array $message: Array von 32-Bit-Wörtern
  * @param int $length: Länge von $message in Bits
  * 
  * @return array: Array von 32-Bit-Datenwörtern
  */
  function core_sha512( $message, $length )
  {
    // Initialisierung des Arrays der Konstanten
    $k = array( int64(0x428a2f98,0xd728ae22), int64(0x71374491,0x23ef65cd), int64(0xb5c0fbcf,0xec4d3b2f), int64(0xe9b5dba5,0x8189dbbc),
                int64(0x3956c25b,0xf348b538), int64(0x59f111f1,0xb605d019), int64(0x923f82a4,0xaf194f9b), int64(0xab1c5ed5,0xda6d8118),
                int64(0xd807aa98,0xa3030242), int64(0x12835b01,0x45706fbe), int64(0x243185be,0x4ee4b28c), int64(0x550c7dc3,0xd5ffb4e2),
                int64(0x72be5d74,0xf27b896f), int64(0x80deb1fe,0x3b1696b1), int64(0x9bdc06a7,0x25c71235), int64(0xc19bf174,0xcf692694),
                int64(0xe49b69c1,0x9ef14ad2), int64(0xefbe4786,0x384f25e3), int64(0x0fc19dc6,0x8b8cd5b5), int64(0x240ca1cc,0x77ac9c65),
                int64(0x2de92c6f,0x592b0275), int64(0x4a7484aa,0x6ea6e483), int64(0x5cb0a9dc,0xbd41fbd4), int64(0x76f988da,0x831153b5),
                int64(0x983e5152,0xee66dfab), int64(0xa831c66d,0x2db43210), int64(0xb00327c8,0x98fb213f), int64(0xbf597fc7,0xbeef0ee4),
                int64(0xc6e00bf3,0x3da88fc2), int64(0xd5a79147,0x930aa725), int64(0x06ca6351,0xe003826f), int64(0x14292967,0x0a0e6e70),
                int64(0x27b70a85,0x46d22ffc), int64(0x2e1b2138,0x5c26c926), int64(0x4d2c6dfc,0x5ac42aed), int64(0x53380d13,0x9d95b3df),
                int64(0x650a7354,0x8baf63de), int64(0x766a0abb,0x3c77b2a8), int64(0x81c2c92e,0x47edaee6), int64(0x92722c85,0x1482353b),
                int64(0xa2bfe8a1,0x4cf10364), int64(0xa81a664b,0xbc423001), int64(0xc24b8b70,0xd0f89791), int64(0xc76c51a3,0x0654be30),
                int64(0xd192e819,0xd6ef5218), int64(0xd6990624,0x5565a910), int64(0xf40e3585,0x5771202a), int64(0x106aa070,0x32bbd1b8),
                int64(0x19a4c116,0xb8d2d0c8), int64(0x1e376c08,0x5141ab53), int64(0x2748774c,0xdf8eeb99), int64(0x34b0bcb5,0xe19b48a8),
                int64(0x391c0cb3,0xc5c95a63), int64(0x4ed8aa4a,0xe3418acb), int64(0x5b9cca4f,0x7763e373), int64(0x682e6ff3,0xd6b2b8a3),
                int64(0x748f82ee,0x5defb2fc), int64(0x78a5636f,0x43172f60), int64(0x84c87814,0xa1f0ab72), int64(0x8cc70208,0x1a6439ec),
                int64(0x90befffa,0x23631e28), int64(0xa4506ceb,0xde82bde9), int64(0xbef9a3f7,0xb2c67915), int64(0xc67178f2,0xe372532b),
                int64(0xca273ece,0xea26619c), int64(0xd186b8c7,0x21c0c207), int64(0xeada7dd6,0xcde0eb1e), int64(0xf57d4f7f,0xee6ed178),
                int64(0x06f067aa,0x72176fba), int64(0x0a637dc5,0xa2c898a6), int64(0x113f9804,0xbef90dae), int64(0x1b710b35,0x131c471b),
                int64(0x28db77f5,0x23047d84), int64(0x32caab7b,0x40c72493), int64(0x3c9ebe0a,0x15c9bebc), int64(0x431d67c4,0x9c100d4c),
                int64(0x4cc5d4be,0xcb3e42b6), int64(0x597f299c,0xfc657e2a), int64(0x5fcb6fab,0x3ad6faec), int64(0x6c44198c,0x4a475817));
    // Initialisierung der Variablen
    $h0 = int64(0x6a09e667,0xf3bcc908);
    $h1 = int64(0xbb67ae85,0x84caa73b);
    $h2 = int64(0x3c6ef372,0xfe94f82b);
    $h3 = int64(0xa54ff53a,0x5f1d36f1);
    $h4 = int64(0x510e527f,0xade682d1);
    $h5 = int64(0x9b05688c,0x2b3e6c1f);
    $h6 = int64(0x1f83d9ab,0xfb41bd6b);
    $h7 = int64(0x5be0cd19,0x137e2179);
    
    // Anhängen des Paddings
    $message[ $length >> 5 ] |= 0x80 << ( 24 - $length % 32 );
    for( $i = sizeof( $message ); $i < ( ( $length + 1 + 128 >> 10 ) << 5 ) + 31; $i++ )
    {
      $message[$i] = 0;
    }
    $message[ ( ( $length + 128 + 1 >> 10 ) << 5 ) + 31 ] = $length;
    
    // Berechnung der Kompressionsfunktion je 1024-Bit-Blöcke
    for( $i = 0; $i < sizeof( $message ); $i += 32 )
    {
      // Initialisierung der Rundenvariablen
      $a = $h0;
      $b = $h1;
      $c = $h2;
      $d = $h3;
      $e = $h4;
      $f = $h5;
      $g = $h6;
      $h = $h7;
      
      // Berechnung der 80 Runden je Block
      for( $j = 0; $j < 80; $j++ )
      {
        // Erweitern der sechzehn 64-Bit-Wörter auf achzig 64-Bit-Wörter
        if( $j < 16 )
        {
          $w[$j] = int64( $message[ $i + 2 * $j ], $message[ $i + 2 * $j + 1 ] );
        }
        else
        {
          // $w[ $j - 2 ] rightrotate 19
          $s10 = int64( ( $w[ $j -  2 ]['high'] >> 19 ) & 0x00001FFF | ( $w[ $j -  2 ]['low']  << 13 ), ( $w[ $j -  2 ]['low']  >> 19 ) & 0x00001FFF | ( $w[ $j -  2 ]['high'] << 13 ) );
          // $w[ $j - 2 ] rightrotate 61
          $s11 = int64( ( $w[ $j -  2 ]['low']  >> 29 ) & 0x00000007 | ( $w[ $j -  2 ]['high'] <<  3 ), ( $w[ $j -  2 ]['high'] >> 29 ) & 0x00000007 | ( $w[ $j -  2 ]['low']  <<  3 ) );
          // $w[ $j - 2 ] rightshift 6
          $s12 = int64( ( $w[ $j -  2 ]['high'] >>  6 ) & 0x03FFFFFF                                  , ( $w[ $j -  2 ]['low']  >>  6 ) & 0x03FFFFFF | ( $w[ $j -  2 ]['high'] << 26 ) );  
          // ( $w[ $j - 2 ] rightrotate 19 ) xor ( $w[ $j - 2 ] rightrotate 61 ) xor ( $w[ $j - 2 ] rightshift 6 )
          
          $s1  = int64( $s10['high'] ^ $s11['high'] ^ $s12['high'], $s10['low'] ^ $s11['low'] ^ $s12['low'] );
          // $w[ $j - 15 ] rightrotate 1
          $s00 = int64( ( $w[ $j - 15 ]['high'] >>  1 ) & 0x7FFFFFFF | ( $w[ $j - 15 ]['low']  << 31 ), ( $w[ $j - 15 ]['low']  >>  1 ) & 0x7FFFFFFF | ( $w[ $j - 15 ]['high'] << 31 ) );
          // $w[ $j - 15 ] rightrotate 8
          $s01 = int64( ( $w[ $j - 15 ]['high'] >>  8 ) & 0x00FFFFFF | ( $w[ $j - 15 ]['low']  << 24 ), ( $w[ $j - 15 ]['low']  >>  8 ) & 0x00FFFFFF | ( $w[ $j - 15 ]['high'] << 24 ) );
          // $w[ $j - 15 ] rightshift 7
          $s02 = int64( ( $w[ $j - 15 ]['high'] >>  7 ) & 0x01FFFFFF                                  , ( $w[ $j - 15 ]['low']  >>  7 ) & 0x01FFFFFF | ( $w[ $j - 15 ]['high'] << 25 ) );  
          // ( $w[ $j - 15 ] rightrotate 1 ) xor ( $w[ $j - 15 ] rightrotate 8 ) xor ( $w[ $j - 15 ] rightshift 7 )
          $s0  = int64( $s00['high'] ^ $s01['high'] ^ $s02['high'], $s00['low'] ^ $s01['low'] ^ $s02['low'] );
          
          // $w[ $j] = Sigma1( $w[ $j -  2 ] ) + $w[ $j - 7 ] + Sigma0( $w[ $j - 15 ] ) + $w[ $j - 16 ]
          $w[$j] = safeadd64( array( $w[ $j - 16 ], $s0, $w[ $j - 7 ], $s1 ) );
        }
        
        // $a rightrotate 28
        $s00 = int64( ( $a['high'] >> 28 ) & 0x0000000F | ( $a['low']  <<  4 ), ( $a['low']  >> 28 ) & 0x0000000F | ( $a['high'] <<  4 ) );
        // $a rightrotate 34
        $s01 = int64( ( $a['low']  >>  2 ) & 0x3FFFFFFF | ( $a['high'] << 30 ), ( $a['high'] >>  2 ) & 0x3FFFFFFF | ( $a['low']  << 30 ) );
        // $a rightrotate 39
        $s02 = int64( ( $a['low']  >>  7 ) & 0x01FFFFFF | ( $a['high'] << 25 ), ( $a['high'] >>  7 ) & 0x01FFFFFF | ( $a['low']  << 25 ) );
        // $s0 = ( $a rightrotate 28 ) xor ( $a rightrotate 34 ) xor ( $a rightrotate 39 )
        $s0  = int64( $s00['high'] ^ $s01['high'] ^ $s02['high'], $s00['low'] ^ $s01['low'] ^ $s02['low'] );
        
        // $maj = ( $a and $b ) xor ( $a and $c ) xor ( $b and $c )
        $maj = int64( ( $a['high'] & $b['high'] ) ^ ( $a['high'] & $c['high'] ) ^ ( $b['high'] & $c['high'] ), ( $a['low'] & $b['low'] ) ^ ( $a['low'] & $c['low'] ) ^ ( $b['low'] & $c['low'] ) );
        // $t2 = $s0 + $maj
        $t2  = safeadd64( array( $s0, $maj ) );
        
        // $e rightrotate 14
        $s10 = int64( ( $e['high'] >> 14 ) & 0x0003FFFF | ( $e['low']  << 18 ), ( $e['low']  >> 14 ) & 0x0003FFFF | ( $e['high'] << 18 ) );
        // $e rightrotate 18
        $s11 = int64( ( $e['high'] >> 18 ) & 0x00003FFF | ( $e['low']  << 14 ), ( $e['low']  >> 18 ) & 0x00003FFF | ( $e['high'] << 14 ) );
        // $e rightrotate 41
        $s12 = int64( ( $e['low']  >>  9 ) & 0x007FFFFF | ( $e['high'] << 23 ), ( $e['high'] >>  9 ) & 0x007FFFFF | ( $e['low']  << 23 ) );
        // $s1 = ( $e rightrotate 14 ) xor ( $e rightrotate 18 ) xor ( $e rightrotate 41 )
        $s1  = int64( $s10['high'] ^ $s11['high'] ^ $s12['high'], $s10['low'] ^ $s11['low'] ^ $s12['low'] );
        
        // $ch = ( $e and $f ) xor ( (not $e) and $g )
        $ch  = int64( ( $e['high'] & $f['high'] ) ^ ( (~$e['high']) & $g['high'] ), ( $e['low'] & $f['low'] ) ^ ( (~$e['low']) & $g['low'] ) );
        // $t1 = $h + $s1 + $ch + $k[ $j ] + $w[ $j ]
        $t1  = safeadd64( array( $h, $s1, $ch, $k[$j], $w[$j] ) );
        
        $h = $g;
        $g = $f;
        $f = $e;
        $e = safeadd64( array( $d, $t1 ) );
        $d = $c;
        $c = $b;
        $b = $a;
        $a = safeadd64( array( $t1, $t2 ) );
      }
      
      // Aufaddieren der Rundenvariablen auf Haswerte
      $h0 = safeadd64( array( $h0, $a ) );
      $h1 = safeadd64( array( $h1, $b ) );
      $h2 = safeadd64( array( $h2, $c ) );
      $h3 = safeadd64( array( $h3, $d ) );
      $h4 = safeadd64( array( $h4, $e ) );
      $h5 = safeadd64( array( $h5, $f ) );
      $h6 = safeadd64( array( $h6, $g ) );
      $h7 = safeadd64( array( $h7, $h ) );
    }
    
    // Ausgabe der Hashwerte als Array von 32-Bit-Wörtern
    return array( $h0['high'], $h0['low'], $h1['high'], $h1['low'],
                  $h2['high'], $h2['low'], $h3['high'], $h3['low'],
                  $h4['high'], $h4['low'], $h5['high'], $h5['low'],
                  $h6['high'], $h6['low'], $h7['high'], $h7['low'] );
  }
  
  /*
  * Hauptfunktion: Berechnung des SHA-512 Hashwertes aus einem String
  *
  * @param string $str: Nachricht/Daten über die ein Hashwert berechnet wird
  * @param boolean $raw_output: false = Ausgabe als Hex-String, true = Ausgabe als Byte-Array
  *
  * @return array|string: In Abhängigkeit von $raw_output einen String oder Byte-Array 
  */
  function SHA512( $str, $raw_output = false )
  {
    // Erstellen eines Arrays von 32-Bit-Wörtern aus String
    $data = array();
    for( $i = 0; $i < strlen( $str ); $i++ )
    {
      $data[ $i >> 2 ] |= ord( $str[$i] ) << ( (3 - $i % 4) << 3 );
    }
    
    // Berechnung des Hashwertes
    $output = core_sha512( $data, 8 * strlen( $str ) );
    
    // Ausgabe des Haswertes in Abhängigkeit von $raw_output
    switch( $raw_output )
    {
      case true:
      /* Byte-Array */
        $bin = array();
        for( $i = 0; $i < sizeof( $output ) << 2; $i++ )
        {
          $bin[ $i ] = $output[ $i >> 2 ] >> ( 24 - ( $i % 4 << 3 ) ) & 0xFF;
        }
        return $bin;
      case false:
      /* Hex-String */
        $hexchars = "0123456789abcdef";
        $hex = '';
        for( $i = 0; $i < sizeof( $output ) << 3; $i++ )
        {
          $hex .= $hexchars[ $output[ $i >> 3 ] >> ( 28 - ( $i % 8 << 2 ) ) & 0xF ];
        }
        return $hex;
      default:
      /* NULL */
        return null;
    }
  }
  /*
  * EOF
  */
?>
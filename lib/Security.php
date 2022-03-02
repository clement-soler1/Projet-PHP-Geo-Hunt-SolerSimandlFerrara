<?php

class Security {
    
    private static $seed = 'XqY7TCn70D';
    private static $seed2 = 'fR66cPEXBO';

    static public function getSeed() {
       return self::$seed;
    }
    static public function getSeed2() {
       return self::$seed;
    }

    static function chiffrer($texte_en_clair) {
      $texte_a_chiffrer = self::$seed . $texte_en_clair . self::$seed2;
      $texte_chiffre = hash('sha256', $texte_a_chiffrer);
      return $texte_chiffre;
    }


    //verif usage
    static function generateRandomHex() {
        // Generate a 32 digits hexadecimal number
        $numbytes = 16; // Because 32 digits hexadecimal = 16 bytes
        $bytes = openssl_random_pseudo_bytes($numbytes); 
        $hex   = bin2hex($bytes);
        return $hex;
    }


}
?>

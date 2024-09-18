<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;
use Transliterator;

class GeneralModel extends Model
{
    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
    }

    public function translatarate($str= ''):string
    {
        $rules                  = <<<'RULES'
                                 :: NFC ;
                                 ё > e; ж > zh; й > i; х > kh; ц > ts; ч > ch; ш > sh; щ > shch; ъ > ie;
                                 э > e; ю > iu; я > ia;
                                 :: Cyrillic-Latin ;
                                 RULES;

        $tls                    = Transliterator::createFromRules($rules);
        return $tls->transliterate( mb_strtolower($str, 'UTF-8') );
    }

}


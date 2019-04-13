<?php 

require_once __DIR__ . '/vendor/autoload.php';

class PreProcessing {

    public $text;

    public function __construct($text, $includeSpaceBetweenWords = true, $useStem = true, $useSort = false)
    {
        $this->text = $text;

        $this->text = $this->casefold();
        $this->text = $this->tokenize();
        $this->text = $this->filter();

        $this->text = ($useStem) ? $this->stem() : $this->text;
        $this->text = (!$includeSpaceBetweenWords) ? $this->removeWhiteSpaces() : $this->text;
        $this->text = ($useSort) ? $this->sort() : $this->text;

    }

    public function getResult()
    {
        return $this->text;
    }

    function casefold()
    {
        return strtolower($this->text);
    }

    function tokenize()
    {
        return preg_replace('/[0-9,\(\)\-\=\"\/\—\`\~\|\{\}\+\*\&\%\$\#\@\^\<\>\;\:\_\.\,\;\!\?]+/', ' ', $this->text);
    }

    function filter()
    {
        $stopWords = '/\b(ya|ada|adalah|adanya|adapun|agak|agaknya|agar|akan|akankah|akhir|akhiri|akhirnya|aku|akulah|amat|amatlah|anda|andalah|antar|antara|antaranya|apa|apaan|apabila|apakah|apalagi|apatah|artinya|asal|asalkan|atas|atau|ataukah|ataupun|awal|awalnya|bagai|bagaikan|bagaimana|bagaimanakah|bagaimanapun|bagi|bagian|bahkan|bahwa|bahwasanya|baik|bakal|bakalan|balik|banyak|bapak|baru|bawah|beberapa|begini|beginian|beginikah|beginilah|begitu|begitukah|begitulah|begitupun|bekerja|belakang|belakangan|belum|belumlah|benar|benarkah|benarlah|berada|berakhir|berakhirlah|berakhirnya|berapa|berapakah|berapalah|berapapun|berarti|berawal|berbagai|berdatangan|beri|berikan|berikut|berikutnya|berjumlah|berkalikali|berkata|berkehendak|berkeinginan|berkenaan|berlainan|berlalu|berlangsung|berlebihan|bermacam|bermacammacam|bermaksud|bermula|bersama|bersamasama|bersiap|bersiapsiap|bertanya|bertanyatanya|berturut|berturutturut|bertutur|berujar|berupa|besar|betul|betulkah|biasa|biasanya|bila|bilakah|bisa|bisakah|boleh|bolehkah|bolehlah|buat|bukan|bukankah|bukanlah|bukannya|bulan|bung|cara|caranya|cukup|cukupkah|cukuplah|cuma|dahulu|dalam|dan|dapat|dari|daripada|datang|dekat|demi|demikian|demikianlah|dengan|depan|di|dia|diakhiri|diakhirinya|dialah|diantara|diantaranya|diberi|diberikan|diberikannya|dibuat|dibuatnya|didapat|didatangkan|digunakan|diibaratkan|diibaratkannya|diingat|diingatkan|diinginkan|dijawab|dijelaskan|dijelaskannya|dikarenakan|dikatakan|dikatakannya|dikerjakan|diketahui|diketahuinya|dikira|dilakukan|dilalui|dilihat|dimaksud|dimaksudkan|dimaksudkannya|dimaksudnya|diminta|dimintai|dimisalkan|dimulai|dimulailah|dimulainya|dimungkinkan|dini|dipastikan|diperbuat|diperbuatnya|dipergunakan|diperkirakan|diperlihatkan|diperlukan|diperlukannya|dipersoalkan|dipertanyakan|dipunyai|diri|dirinya|disampaikan|disebut|disebutkan|disebutkannya|disini|disinilah|ditambahkan|ditandaskan|ditanya|ditanyai|ditanyakan|ditegaskan|ditujukan|ditunjuk|ditunjuki|ditunjukkan|ditunjukkannya|ditunjuknya|dituturkan|dituturkannya|diucapkan|diucapkannya|diungkapkan|dong|dua|dulu|empat|enggak|enggaknya|entah|entahlah|guna|gunakan|hal|hampir|hanya|hanyalah|hari|harus|haruslah|harusnya|hendak|hendaklah|hendaknya|hingga|ia|ialah|ibarat|ibaratkan|ibaratnya|ibu|ikut|ingat|ingatingat|ingin|inginkah|inginkan|ini|inikah|inilah|itu|itukah|itulah|jadi|jadilah|jadinya|jangan|jangankan|janganlah|jauh|jawab|jawaban|jawabnya|jelas|jelaskan|jelaslah|jelasnya|jika|jikalau|juga|jumlah|jumlahnya|justru|kala|kalau|kalaulah|kalaupun|kalian|kami|kamilah|kamu|kamulah|kan|kapan|kapankah|kapanpun|karena|karenanya|kasus|kata|katakan|katakanlah|katanya|ke|keadaan|kebetulan|kecil|kedua|keduanya|keinginan|kelamaan|kelihatan|kelihatannya|kelima|keluar|kembali|kemudian|kemungkinan|kemungkinannya|kenapa|kepada|kepadanya|kesampaian|keseluruhan|keseluruhannya|keterlaluan|ketika|khususnya|kini|kinilah|kira|kirakira|kiranya|kita|kitalah|kok|kurang|lagi|lagian|lah|lain|lainnya|lalu|lama|lamanya|lanjut|lanjutnya|lebih|lewat|lima|luar|macam|maka|makanya|makin|malah|malahan|mampu|mampukah|mana|manakala|manalagi|masa|masalah|masalahnya|masih|masihkah|masing|masingmasing|mau|maupun|melainkan|melakukan|melalui|melihat|melihatnya|memang|memastikan|memberi|memberikan|membuat|memerlukan|memihak|meminta|memintakan|memisalkan|memperbuat|mempergunakan|memperkirakan|memperlihatkan|mempersiapkan|mempersoalkan|mempertanyakan|mempunyai|memulai|memungkinkan|menaiki|menambahkan|menandaskan|menanti|menantinanti|menantikan|menanya|menanyai|menanyakan|mendapat|mendapatkan|mendatang|mendatangi|mendatangkan|menegaskan|mengakhiri|mengapa|mengatakan|mengatakannya|mengenai|mengerjakan|mengetahui|menggunakan|menghendaki|mengibaratkan|mengibaratkannya|mengingat|mengingatkan|menginginkan|mengira|mengucapkan|mengucapkannya|mengungkapkan|menjadi|menjawab|menjelaskan|menuju|menunjuk|menunjuki|menunjukkan|menunjuknya|menurut|menuturkan|menyampaikan|menyangkut|menyatakan|menyebutkan|menyeluruh|menyiapkan|merasa|mereka|merekalah|merupakan|meski|meskipun|meyakini|meyakinkan|minta|mirip|misal|misalkan|misalnya|mula|mulai|mulailah|mulanya|mungkin|mungkinkah|nah|naik|namun|nanti|nantinya|nyaris|nyatanya|oleh|olehnya|pada|padahal|padanya|pak|paling|panjang|pantas|para|pasti|pastilah|penting|pentingnya|per|percuma|perlu|perlukah|perlunya|pernah|persoalan|pertama|pertamatama|pertanyaan|pertanyakan|pihak|pihaknya|pukul|pula|pun|punya|rasa|rasanya|rata|rupanya|saat|saatnya|saja|sajalah|saling|sama|samasama|sambil|sampai|sampaisampai|sampaikan|sana|sangat|sangatlah|satu|saya|sayalah|se|sebab|sebabnya|sebagai|sebagaimana|sebagainya|sebagian|sebaik|sebaikbaiknya|sebaiknya|sebaliknya|sebanyak|sebegini|sebegitu|sebelum|sebelumnya|sebenarnya|seberapa|sebesar|sebetulnya|sebisanya|sebuah|sebut|sebutlah|sebutnya|secara|secukupnya|sedang|sedangkan|sedemikian|sedikit|sedikitnya|seenaknya|segala|segalanya|segera|seharusnya|sehingga|seingat|sejak|sejauh|sejenak|sejumlah|sekadar|sekadarnya|sekali|sekalikali|sekalian|sekaligus|sekalipun|sekarang|sekarang|sekecil|seketika|sekiranya|sekitar|sekitarnya|sekurangkurangnya|sekurangnya|sela|selain|selaku|selalu|selama|selamalamanya|selamanya|selanjutnya|seluruh|seluruhnya|semacam|semakin|semampu|semampunya|semasa|semasih|semata|sematamata|semaunya|sementara|semisal|semisalnya|sempat|semua|semuanya|semula|sendiri|sendirian|sendirinya|seolah|seolaholah|seorang|sepanjang|sepantasnya|sepantasnyalah|seperlunya|seperti|sepertinya|sepihak|sering|seringnya|serta|serupa|sesaat|sesama|sesampai|sesegera|sesekali|seseorang|sesuatu|sesuatunya|sesudah|sesudahnya|setelah|setempat|setengah|seterusnya|setiap|setiba|setibanya|setidaktidaknya|setidaknya|setinggi|seusai|sewaktu|siap|siapa|siapakah|siapapun|sini|sinilah|soal|soalnya|suatu|sudah|sudahkah|sudahlah|supaya|tadi|tadinya|tahu|tahun|tak|tambah|tambahnya|tampak|tampaknya|tandas|tandasnya|tanpa|tanya|tanyakan|tanyanya|tapi|tegas|tegasnya|telah|tempat|tengah|tentang|tentu|tentulah|tentunya|tepat|terakhir|terasa|terbanyak|terdahulu|terdapat|terdiri|terhadap|terhadapnya|teringat|teringatingat|terjadi|terjadilah|terjadinya|terkira|terlalu|terlebih|terlihat|termasuk|ternyata|tersampaikan|tersebut|tersebutlah|tertentu|tertuju|terus|terutama|tetap|tetapi|tiap|tiba|tibatiba|tidak|tidakkah|tidaklah|tiga|tinggi|toh|tunjuk|turut|tutur|tuturnya|ucap|ucapnya|ujar|ujarnya|umum|umumnya|ungkap|ungkapnya|untuk|usah|usai|waduh|wah|wahai|waktu|waktunya|walau|walaupun|wong|yaitu|yakin|yakni|yang)\b/';
        $whiteSpace = '!\s+!';

        $text = preg_replace($stopWords, ' ', $this->text);

        return preg_replace($whiteSpace, ' ', $text);
    }

    function stem()
    {
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();

        return $stemmer->stem($this->text);
    }

    function removeWhiteSpaces()
    {
        $arrayTeks = explode(" ",$this->text);
        $arrayTeks = array_filter($arrayTeks);
        
        return join("", $arrayTeks);
    }

    function sort()
    {
        $arrayTeks = explode(" ",$this->text);
        $arrayTeks = array_filter($arrayTeks);

        sort($arrayTeks);

        
        return join(" ", $arrayTeks);
    }
}
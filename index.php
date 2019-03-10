<?php 
class NextPalindrome {

    public $k;  // input string of digts up to 1000000 digits max
    public $n;  // length of input digits string
    public $output;
    public $int = array();

    private function process() {
        $this->int = array_map('intval', str_split($this->k));
        $this->n = count($this->int);
        $mid = (int)($this->n / 2);
        $i = $mid - 1; 
        $j = ($this->n % 2 == 0) ?  $mid : ($mid + 1);
        $this->output = '';
        $leftsmaller = false;
        $even = ($this->n % 2 == 0);
        $odd = !$even;

        // pozycjonujemy wskaźniki, jeśli liczby są równe i nie skończył się zakres danych wejściowych to przesuwamy $i w lewno oraz $j w prawo
        while ($i >= 0 && $this->int[$i] === $this->int[$j]) {
            $i--;
            $j++;
        }
        // sprawdzamy czy wyszliśmy poza zakres lub czy lewa cyfra jest mniejsza od prawej, jeśli tak to ustawiamy flagę
        if ($i < 0 || $this->int[$i] < $this->int[$j])  
        { 
            $leftsmaller = true; 
        }
        
        /************* obsługa przypadków **************/
        // najprostszy przypadek kiedy cyfra z lewej strony jest większa, wtedy wsytarczy że przekopiujemy lustrzane odbicie lewej strony na prawą stronę
        if ($i >= 0 && $this->int[$i] > $this->int[$j]) {
            while ($i >= 0) {
                $this->int[$j++] = $this->int[$i--];
            }
            $leftsmaller = false;
        }

        if ($leftsmaller) {
            // reset indeksów
            $i = $mid - 1; 
            $j = ($this->n % 2 == 0) ?  $mid : ($mid + 1); 
            $carry = 1;
            // jesli mamy nieparzysta liczbę cyfr to inkrementujemy środek i wyliczamy przeniesienie
            if ($odd) {
                $this->int[$mid]++;
                $carry = $this->int[$mid] / 10;
                $this->int[$mid] %= 10;
            }
            while ($i >= 0) {
                $this->int[$i] += $carry;
                $carry = $this->int[$i] / 10;
                $this->int[$i] %= 10;
                $this->int[$j++] = $this->int[$i--];
            }
            
        }
        $this->output = implode($this->int);
    }

    private function all9ns() {
        $n = $this->n - 1;
        while ($n >= 0) {
            if ($this->k[$n] !== '9') {
                return false;
            }
            --$n;
        }
        return true;
    }

    public function init() {
        $t = stream_get_line(STDIN, 20000000000, PHP_EOL);
        for ($j=0; $j<$t; $j++) {
            $this->k = stream_get_line(STDIN, 20000000000, PHP_EOL);
            $this->n = strlen(trim($this->k));
            if ($this->all9ns()) {
                $length = $this->n === 0 ? 0 : $this->n-1;
                $this->output = '1'. implode(array_fill(0, $length, '0')) .'1';
            } else {
                $this->process();
            }
            echo $this->output . PHP_EOL;
        }
    }

}


$nextPalindrome = new NextPalindrome();
$nextPalindrome->init();
?>
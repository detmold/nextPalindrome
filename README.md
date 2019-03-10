# devclass

The next palindrome

## Problem

Na wejściu dostajemy liczbę testów i dla każdego testu mamy: 
- liczbę dodatnią K oznaczamy jako **$k**, interpretowaną jako ciąg znaków
Dla każdej liczby **$k** musimy wyznaczyć najmniejszą ale większą od liczby **$k** liczbę będącą palindromem.
Palindrom to liczba którą tak samo czytamy od z lewej i prawej strony. Przykłady:
621126
888
54300345
9

## Algorytm

Zadanie [NextPalindrome](https://www.codechef.com/problems/PALIN)

1. Wyznaczymy indeks środkowy od, którego powinno się zaczać sprawdzać jest to: 
```php 
$length = strlen($k);
$mid = (int)($length / 2);
$i = $mid - 1; 
$j = ($k % 2 == 0) ?  $mid : ($mid + 1);
$output = '';
$leftsmaller = false;
$even = ($k % 2 == 0);
$odd = !$even;

/****************************************************OPIS ALGORYTMU****************************************************
Następnie w pętli porównujemy ze sobą litery zaczynając od wyznaczonego indeksu. Muszą być spełnione jednocześnie trzy warunki:
    1 - wyznaczana liczba musi być palindormem czyli dla każdej liczby odpowiednio z miejsc <0,$index-1>..<$index+1,strlen((string)$k)); musi zajść równość
    2 - wyznaczna liczba musi być większa niż $k
    3 - wyznaczana liczba musi być najmniejszym możliwym palindormem większym niż $k
Zdefiniujmy lewą i prawą stronę jako liczby z przedziału: 
$leftSide = <$k[0]..$k[$mid-1]>
$rightSide = <$k[$mid+1]..$k[strlen($k)]>
$i - indeks lewy
$j - indeks prawy
Możemy spotkać następujące przypadki:
    1 - liczba $k jest palindromem i ma same 9-ki
    2 - liczba $k jest palindromem ale nie ma samych 9-tek
    3 - liczna $k nie jest palindromem 
        3a - pierwsza cyfra po lewej stronie liczby $k jest większa niż odpowiadająca jej cyfra po prawej stronie: $k[$i] > $k[$j]
        3b - pierwsza cyfra po lewej stronie liczby $k jest mniejsza niż odpowiadająca jej cyfra po prawej stronie: $k[$i] < $k[$j]
 ***********************************************************************************************************************/

 if (all9ns()) {
     $output = '1'. array_fill(0, $length-1, '0') .'1'. PHP_EOL; 
 } else {
     // pozycjonujemy wskaźniki, jeśli liczby są równe i nie skończył się zakres danych wejściowych to przesuwamy $i w lewno oraz $j w prawo
     while ($i >= 0 && $k[$i] === $k[$j]) {
        $i--;
        $j++;
    }
    // sprawdzamy czy wyszliśmy poza zakres lub czy lewa cyfra jest mniejsza od prawej, jeśli tak to ustawiamy flagę
    if ($i < 0 || $k[$i] < $k[$j])  
    { 
        $leftsmaller = true; 
    }
    
    /************* obsługa przypadków **************/
    // najprostszy przypadek kiedy cyfra z lewej strony jest większa, wtedy wsytarczy że przekopiujemy lustrzane odbicie lewej strony na prawą stronę
    if ($i > 0 && $k[$i] > $k[$j]) {
        while ($i >= 0) {
            $k[$j++] = $k[$i--];
        }
    }

    if ($leftsmaller) {
        // reset indeksów
        $i = $mid - 1; 
        $j = ($k % 2 == 0) ?  $mid : ($mid + 1); 
        $carry = 1;
        // jesli mamy nieparzysta liczbę cyfr to inkrementujemy środek i wyliczamy przeniesienie
        if ($odd) {
            ++$k[$mid];
            $carry = (int)$k[$mid] / 10;
            $k[$mid] %= 10;
        }
        while ($i >= 0) {
            $k[$i] += $carry;
            $carry = (int)$k[$i] / 10;
            $k[$i] %= 10;
            $i--;
            $j++;
        }
        
    }

$output = $k;
}

function all9ns() {
    $n = count($k);
    while ($n >= 0) {
        if ($k[$n] !== '9') {
            return false;
        }
        --$n;
    }
    return true;
}

``` 
 



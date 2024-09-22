<?php
/* Check if a word is symmetric */
function is_symmetric_word($word) {
    $left = 0;
    $right = strlen($word) - 1;

    while ($left < $right) {
        // Check if the characters are the same
        if ($word[$left] !== $word[$right]) {
            return "FALSE";
        }

        // Move the pointers
        $left++;
        $right--;
    }

    return "TRUE";
}

/* Example usage */
$str = "madam";
print_r(is_symmetric_word($str) . "\n");

$str = "gozaru";
print_r(is_symmetric_word($str) . "\n");
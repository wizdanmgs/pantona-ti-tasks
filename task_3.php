<?php
/* Sort an array using custom sort */
function custom_sort($array_number, $chunk_size = 5) {
    $result = [];
    $asc = true;

    while (count($array_number) > 0) {
        // Implement bubble sort
        for ($i = 0; $i < count($array_number); $i++) {
            for ($j = 0; $j < count($array_number) - 1; $j++) {
                // Compare the numbers
                if (($asc && $array_number[$j] > $array_number[$j + 1]) || (!$asc && $array_number[$j] < $array_number[$j + 1])) {
                    // Swap the numbers
                    $temp = $array_number[$j];
                    $array_number[$j] = $array_number[$j + 1];
                    $array_number[$j + 1] = $temp;
                }
            }
        }

        // Take the first chunk of numbers
        $chunk = array_slice($array_number, 0, $chunk_size);

        // Add the chunk to the result array
        $result = array_merge($result, $chunk);

        // Remove the taken numbers from the array
        $array_number = array_slice($array_number, $chunk_size);

        // Toggle the sorting order
        $asc = !$asc;
    }

    // Return the sorted array as a string
    return rtrim(implode(",", $result), ',');
}

/* Example usage */
$array_number = [2,5,1,12,-5,4,-1,3,-3,20,8,7,-2,6,9,9,2,-2,1,-20];
print_r(custom_sort($array_number, 5));
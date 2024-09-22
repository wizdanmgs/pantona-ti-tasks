<?php
/* Find three numbers that sum to zero */
function find_three_numbers($array_number) {
    $num_map = [];
    $sums = [];

    foreach ($array_number as $i => $current) {
        // Find the remaining number
        $remaining = -$current;

        foreach ($num_map as $j => $prev) {
            if ($prev != 0) {
                // Check if the remaining number is in the map
                $k = $num_map[$remaining - $prev];

                if ($k !== null && $k !== $i && $k !== $j) {
                    // Add the three numbers
                    $el = [$prev, $current, $remaining - $prev];

                    // Sort the numbers
                    sort($el);

                    // Add the numbers to the sums array
                    $sums[] = $el;
                }
            }
            
        }

        // Add the current number to the map
        $num_map[$current] = $i;
    }

    if (empty($sums)) {
        return "Not Found";
    }

    // Sort the sums
    usort($sums, function ($a, $b) {
        return $a <=> $b;
    });

    // Return the last sum as a string
    return rtrim(implode(",", array_pop($sums)), ',');
}

/* Example usage */
$array_number = [2,1,5,7,4,-8,-3,-1];
print_r(find_three_numbers($array_number));
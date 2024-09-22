<?php
/* Remove duplicates from an array */
function remove_duplicates($array_number) {
    $result = [];
    
    foreach ($array_number as $value) {
        // If the value is not in the new array, add it
        if (!in_array($value, $result)) {
            $result[] = $value;
        }
    }
    
    // Return the new array as a string
    return rtrim(implode(",", $result), ',');
}

/* Example usage */
$array_number = [1,1,4,4,4,5,5,6,8,9,10,10,12,13,13,17];
print_r(remove_duplicates($array_number));
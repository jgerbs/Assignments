<?php

/**
 * Remove invalid shows from the assoc. array that is passed as a parameter, 
 * and return an array which contains only valid entries.
 * 
 * Hint #1: make it easier on yourself by using a foreach loop
 * Hint #2: look into https://www.php.net/manual/en/function.unset.php
 *              - What should we pass to the unset function?
 * 
 * @param array $shows: an associative array of shows in a format following: 
 *              ['name' => '<date string>', ...]
 * 
 * @return array: an associative array containing shows that don't have 
 *                empty strings or null values for their names and dates
 */
function filterInvalidShows(array $shows): array {
    foreach($shows as $title => $date){
        if($title !== null && $title !== '' && $date !== null && $date !== ''){
            $filteredShows[$title] = $date;
        }
    }

    return $filteredShows ?? [];
}

// An associative array of show names and associated dates when the shows aired
$shows = [
    'Seinfeld' => 'July 5th, 1989 - May 14th, 1998', 
    'Curb Your Enthusiasm' => 'October 15th, 2000 - Current', 
    'The Simpsons' => 'December 17, 1989 - Current', 
    'Invalid data1' => '', 
    'Invalid data2' => null, 
    null => 'December 17, 1999 - Current', 
    '' => 'December 17, 1999 - Current', 
];

// Here you can call filterInvalidShows and store the resulting array in a variable
// In the HTML portion of the document we will open some PHP tags and output the show info.

$validatedShows = filterInvalidShows($shows);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 1</title>
</head>
<body>
    <h3>Shows</h3>
    <div>
        <?php
        // You can access variables defined in the above PHP tags here. 
        // Use an (alternative syntax) foreach loop here: https://www.php.net/manual/en/control-structures.foreach.php
        // and within the loop, print/echo out the results
        foreach($validatedShows as $title => $date){
            echo("<p><strong>$title:</strong> $date</p>");
        }
        ?>
    </div>
</body>
</html>

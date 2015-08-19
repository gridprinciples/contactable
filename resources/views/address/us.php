<?php

// Start with both of the street lines that aren't blank.
$lines = array_filter([$street, $street_extra], 'strlen');

// Now craft the final line.  Should look like "City, State Zip"
$final_line = [
    $city . ($city && $subdivision ? ',' : ''),
    $subdivision,
    $postal_code,
];

// Filter out any blank parts of the line.
$final_line = array_filter($final_line, 'strlen');

// Append the final line to the main set.
$lines[] = implode(' ', $final_line);

// Echo out the non-empty lines with line breaks.
echo implode("\n", array_filter($lines, 'strlen'));

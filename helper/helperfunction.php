<?php
function generateTechnicianID($name, $lastId)
{
    // Extract the first and last characters of the name
    $firstChar = strtolower($name[0]);
    $lastChar = strtolower($name[strlen($name) - 1]);

    // Generate a new technician ID by combining the characters and an auto-increment number
    $prefix = $firstChar . $lastChar;  // First and last characters of the name
    $newId = str_pad($lastId + 1, 6, '0', STR_PAD_LEFT); // Auto increment with 6 digits

    return $prefix . $newId;
}




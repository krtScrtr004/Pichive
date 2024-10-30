<?php
require_once '../config/database.php';

function generateUUID()
{
    global $pdo;
    try {
        // Fetch the UUID directly from the database
        $generate_uuid = $pdo->query('SELECT UUID() AS ID');
        $uuid = $generate_uuid->fetch();
        $uuid = hex2bin(str_replace('-', '', $uuid['ID']));         // Remove dashes and convert the UUID string to binary

        return $uuid; // Return UUID as BINARY(16)

    } catch (PDOException $e) {
        // Optionally handle the exception (e.g., log the error)
        echo "Error: " . $e->getMessage();
        return null; // Return null on error
    }
}


function parseUUID($bin_uuid)
{
    $hex_uuid = bin2hex($bin_uuid);
    // Format the hexadecimal UUID with dashes to match the standard UUID format
    $uuid = sprintf(
        '%08s-%04s-%04s-%04s-%012s',
        substr($hex_uuid, 0, 8),
        substr($hex_uuid, 8, 4),
        substr($hex_uuid, 12, 4),
        substr($hex_uuid, 16, 4),
        substr($hex_uuid, 20, 12)
    );
    return $uuid;
}

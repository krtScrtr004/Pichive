<?php

require_once '../config/database.php';
include_once '../utils/uuid.php';

date_default_timezone_set('Asia/Manila');

use OTPHP\TOTP;

function generate_otp()
{
    $totp = TOTP::generate();       // Generate secret (64-bit)
    $totp->setDigits(6);            // Set OTP length to 6-digit long
    return $totp->now();
}

function search_existing_record($id, $otp = null)
{
    global $pdo;
    try {
        $query = null;
        if ($otp) {
            $query = $pdo->prepare('SELECT * FROM otp WHERE otp_code = :otp_code AND user_id = :user_id');
            $query->execute([
                'otp_code' => $otp,
                'user_id' => encode_uuid($id)
            ]);
        } else {
            $query = $pdo->prepare('SELECT otp_code FROM otp WHERE user_id = :user_id');
            $query->execute([
                ':user_id' => encode_uuid($id)
            ]);
        }

        return $query->fetch();
    } catch (PDOException $e) {
        throw new PDOException('Database error: ' . $e->getMessage());
    }
}

function insert_otp_record($id, $otp)
{
    global $pdo;
    try {
        // Record otp  with id in db
        $query = $pdo->prepare('INSERT INTO otp(otp_code, user_id, record_time) VALUES(:otp_code, :user_id, :record_time)');
        $query->execute([
            ':otp_code' => $otp,
            ':user_id' => $id,
            ':record_time' => (new DateTime())->format('Y-m-d H:i:s')
        ]);
    } catch (PDOException $e) {
        throw new PDOException('Database error: ' . $e->getMessage());
    }
}

function update_otp_record($id, $otp)
{
    global $pdo;
    try {
        $query = $pdo->prepare('UPDATE otp SET otp_code = :otp_code, record_time = :record_time WHERE user_id = :user_id');
        $query->execute([
            ':otp_code' => $otp,
            ':record_time' => (new DateTime())->format('Y-m-d H:i:s'),  // Corrected order
            ':user_id' => $id,
        ]);
    } catch (PDOException $e) {
        throw new PDOException('Database error: ' . $e->getMessage());
    }
}

function delete_otp_record($id, $otp)
{
    global $pdo;
    try {
        $query = $pdo->prepare('DELETE FROM otp WHERE otp_code = :otp_code AND user_id = :user_id');
        $query->execute([
            ':otp_code' => $otp,
            ':user_id' => $id
        ]);
    } catch (PDOException $e) {
        throw new PDOException('Database error: ' . $e->getMessage());
    }
}

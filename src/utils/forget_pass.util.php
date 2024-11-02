<!----------------------------------------
    FORGET PASSWORD UTILITY FUNCTIONS
----------------------------------------->
<?php
function search_existing_record($id, $otp = null)
{
    global $pdo;
    try {
        $query = null;
        if ($otp) {
            $query = $pdo->prepare('SELECT * FROM otp WHERE otp_code = :otp_code AND user_id = :user_id');
            $id = encodeUUID($id);
            $query->execute([
                'otp_code' => $otp,
                'user_id' => $id
            ]);
        } else {
            $query = $pdo->prepare('SELECT otp_code FROM otp WHERE user_id = :user_id');
            $query->execute([
                ':user_id' => $id
            ]);
        }
        
        return $query->fetch();
    } catch (PDOException $e) {
        return json_encode(array(
            'status' => 'fail',
            'message' => 'Database error: ' . $e->getMessage()
        ));
    }
}

function insert_otp_record($id)
{
    global $pdo, $otp;
    try {
        date_default_timezone_set('Asia/Manila');

        // Record otp  with id in db
        $insert_query = $pdo->prepare('INSERT INTO otp(otp_code, user_id, record_time) VALUES(:otp_code, :user_id, :record_time)');
        $insert_query->execute([
            ':otp_code' => $otp,
            ':user_id' => $id,
            ':record_time' => (new DateTime())->format('Y-m-d H:i:s')
        ]);
    } catch (PDOException $e) {
        return json_encode(array(
            'status' => 'fail',
            'message' => 'Database error: ' . $e->getMessage()
        ));
    }
}

function delete_otp_record($id, $otp) {
    global $pdo;
    try {
        $delete_query = $pdo->prepare('DELETE FROM otp WHERE otp_code = :otp_code AND user_id = :user_id');
        $delete_query->execute([
            ':otp_code' => $id,
            ':user_id' => encodeUUID($otp)
        ]);
        return true;
    } catch (PDOException $e) {
        return json_encode(array(
            'status' => 'fail',
            'message' => 'Database error: ' . $e->getMessage()
        ));
    }
}

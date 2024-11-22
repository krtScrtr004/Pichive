<?php
require_once '../config/session.php';
include_once 'partials/create_post.php';
include_once 'partials/post_modal.php';

if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['user_email']) ||
    !isset($_GET['page'])
) {
    header('Location: index.php');
    exit();
}
?>

<link rel="stylesheet" href="../assets/style/generic.css">
<link rel="stylesheet" href="../assets/style/modal.css">
<link rel="stylesheet" href="../assets/style/post_modal.css">

<style>

</style>

<div class="modal-wrapper" id="post_modal">
    <span class="result"></span>

    <section class="modal">
        <section class="img-view">
           
        </section>

        <section class="detail">
            <section class="post-detail">
                <!-- TODO: Add more details here -->
            </section>

            <section class="comment">
                <section class="comment-list">
                    <div class="comment-wrapper">
                        <!-- Original comment -->
                        <!-- <section class="original_comment comment-box">
                            <div class="commenter-img">

                                <img src="../assets/img/default_img_prev.png" alt="">
                            </div>
                            <div class="comment-detail">
                                <div class="comment-header">
                                    <h4 class="commenter_name">Julius Caesar</h4>
                                    <p class="comment_date">123123</p>
                                </div>
                                <p class="comment-content">
                                    asdfbdasbflkdabfajdsbflakjsbdflkjadsbfljaskdbfljkasdbfljkasbfabdsflkjasbfljasbdfjkladsbfljkasdbfkjlasbdflkjasbfjlkadsbfalsbjdfadsjlbfasjlkdbflaskdbfljksdbfaldsjbfbkjlb
                                </p>
                            </div>
                        </section> -->

                        <!-- TODO: If have time, add this -->
                        <!-- Replied comment -->
                        <!-- <section class="reply_list comment-box">
                            <div class="commenter-img">
                                
                                <img src="../../assets/img/default_img_prev.png" alt="">
                            </div>
                            <div class="comment-detail">
                                <div class="comment-header">
                                    <h4 class="commenter_name">Julius Caesar</h4>
                                    <p class="comment_date">123123</p>
                                </div>
                                <p class="comment-content">
                                    asdfbdasbflkdabfajdsbflakjsbdflkjadsbfljaskdbfljkasdbfljkasbfabdsflkjasbfljasbdfjkladsbfljkasdbfkjlasbdflkjasbfjlkadsbfalsbjdfadsjlbfasjlkdbflaskdbfljksdbfaldsjbfbkjlb
                                </p>
                            </div>
                        </section> -->
                    </div>
                </section>

                <section class="write-comment-form">
                    <form action="" method="POST">
                        <input type="text" name="write_comment" id="input_comment" min="1" max="300" required>
                        <button type="submit" id="submit_comment_btn">Send</button>
                    </form>
                </section>

            </section>
        </section>
    </section>
</div>
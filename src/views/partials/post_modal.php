<?php
require_once '../config/session.php';
include_once 'partials/edit_post_modal.php';
include_once 'partials/report_modal.php';

if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['user_email'])
) {
    header('Location: index.php');
    exit();
}
?>

<link rel="stylesheet" href="../assets/style/generic.css">
<link rel="stylesheet" href="../assets/style/modal.css">
<link rel="stylesheet" href="../assets/style/post_modal.css">

<div class="modal-wrapper" id="post_modal">
    <span class="result"></span>

    <section class="modal">
        <section class="img-view">
            <!-- <div style="background-color:white;color:black;"> -->

            <!-- <div class="poster-info flex-row">
                    <a href="">
                        <img class="circle" src="" alt="Poster Profile Icon" title="Poster Profile Icon" witdh="36" height="36">
                    </a>

                    <div class="flex-column">
                        <h3 id="poster-name" class="dark-text">Anonymous</h3>
                        <p id="poster-id" class="dark-text">Unknown</p>
                    </div>

                    <div class="flex-row">
                        <p id="date" class="dark-text">Unkown Date</p>
                    </div>
                </div>

                <h1 id="title" class="dark-text">Untitled</h1>
                <p id="description" class="dark-text">NA</p>
            </div> -->
        </section>

        <section class="detail">
            <section class="post-detail">
                <!-- TODO: Add more details here -->
            </section>

            <section class="comment">
                <section class="comment-list flex-column">
                    <!-- <div class="comment-wrapper"> -->
                        <!-- Original comment -->
                        <!-- <section class="original_comment comment-box">
                            <div class="commenter-img">

                                <img src="../assets/img/default_img_prev.png" alt="">
                            </div>
                            <div class="comment-detail">
                                <div class="comment-header flex-row">
                                    <h4 class="commenter-name">Julius Caesar</h4>
                                    <p class="comment-date">123123</p>
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
                    <!-- </div> -->
                </section>

                <section class="write-comment-form">
                    <form id="comment_form" class="flex-row" action="" method="POST">
                        <textarea name="input_comment" id="input_comment" cols="30" rows="10" maxlength="300" placeholder="Write comment here..."></textarea>
                        <button type="submit" id="submit_comment_btn" class="button">Send</button>
                    </form>
                </section>

            </section>
        </section>
    </section>
</div>
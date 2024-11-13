<?php
?>

<style>
    .modal_wrapper {
        width: 100%;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.7);
        display: none;
        justify-content: center;
        align-items: center;
        position: fixed;
        z-index: 1000;
    }

    #img_view {
        flex: 1;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }

    #img_view>img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    #detail {
        width: 40%;
        height: 100%;
        border: solid 1px blue;
        display: flex;
        flex-direction: column;
    }

    .post_detail {
        background-color: white;
    }

    .post_detail>p {
        display: block;
    }

    #comment {
        width: 100%;
        height: 100%;
        background-color: pink;
        color: white;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        padding: 10px;
    }

    .comment_list {
        flex: 1;
        overflow: hidden auto;
    }

    .comment_wrapper {
        width: 100%;
    }

    .comment_box {
        width: 100%;
        display: flex;
    }

    .commenter_img {
        width: 8%;
        display: grid;
        grid-template-rows: 1fr 1fr;
        place-items: center;
    }

    .commenter_img>img {
        width: 100%;
        height: auto;
        aspect-ratio: 1/1;
        border: 1px solid black;
        border-radius: 50%;
        overflow: hidden;
        object-fit: cover;
    }

    .comment_detail {
        flex: 1;
        width: 100%;
        height: auto;
        display: flex;
        flex-direction: column;
        padding-left: 1rem;
        word-wrap: break-word;
        overflow-x: hidden;
        overflow-wrap: break-word;
    }

    .comment_header {
        display: flex;
        flex-direction: row;
    }

    .comment_content {
        flex: 1;
    }

    /* .reply_list {
        padding-left: 1rem;
    } */

    #write_comment_form {
        width: 100%;
        height: 15%;
        /* bottom: 100%; */
    }

    #write_comment_form>form {
        width: 100%;
        height: 100%;
        display: grid;
        grid-template-rows: 2fr 1fr;
    }

    #input_comment {
        width: 100%;
    }
</style>

<div class="modal_wrapper">
    <span class="result"></span>

    <section class="modal">

        <section id="img_view">
        </section>

        <section id="detail">
            <section class="post_detail">
                <!-- TODO: Add more details here -->
            </section>

            <section id="comment">
                <section class="comment_list">
                    <div class="comment_wrapper">
                        <!-- Original comment -->
                        <!-- <section class="original_comment comment_box">
                            <div class="commenter_img">
                                <img src="../assets/img/default_img_prev.png" alt="">
                            </div>
                            <div class="comment_detail">
                                <div class="comment_header">
                                    <h4 class="commenter_name">Julius Caesar</h4>
                                    <p class="comment_date">123123</p>
                                </div>
                                <p class="comment_content">
                                    asdfbdasbflkdabfajdsbflakjsbdflkjadsbfljaskdbfljkasdbfljkasbfabdsflkjasbfljasbdfjkladsbfljkasdbfkjlasbdflkjasbfjlkadsbfalsbjdfadsjlbfasjlkdbflaskdbfljksdbfaldsjbfbkjlb
                                </p>
                            </div>
                        </section> -->

                        <!-- TODO: If have time, add this -->
                        <!-- Replied comment -->
                        <!-- <section class="reply_list comment_box">
                            <div class="commenter_img">
                                <img src="../../assets/img/default_img_prev.png" alt="">
                            </div>
                            <div class="comment_detail">
                                <div class="comment_header">
                                    <h4 class="commenter_name">Julius Caesar</h4>
                                    <p class="comment_date">123123</p>
                                </div>
                                <p class="comment_content">
                                    asdfbdasbflkdabfajdsbflakjsbdflkjadsbfljaskdbfljkasdbfljkasbfabdsflkjasbfljasbdfjkladsbfljkasdbfkjlasbdflkjasbfjlkadsbfalsbjdfadsjlbfasjlkdbflaskdbfljksdbfaldsjbfbkjlb
                                </p>
                            </div>
                        </section> -->
                    </div>
                </section>

                <section id="write_comment_form">
                    <form action="" method="POST">
                        <input type="text" name="write_comment" id="input_comment" min="1" max="300" required>
                        <button type="submit" id="submit_comment_btn">Send</button>
                    </form>
                </section>

            </section>
        </section>
    </section>
</div>

<script type="module" src="../assets/js/event/fetch_post.js"></script>
<script type="module" src="../assets/js/event/comment.js"></script>

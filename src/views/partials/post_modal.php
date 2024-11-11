<?php
?>

<style>
    .modal_wrapper {
        width: 100%;
        height: 100%;
        display: none;
        justify-content: center;
        align-items: center;
        position: fixed;
        background-color: rgba(0, 0, 0, 0.7);
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
    }

    #post_detail {
        background-color: white;
    }

    #post_detail>p {
        display: block;
    }
</style>

<div class="modal_wrapper">
    <section class="modal">
        <section id="img_view">
            <img src="../assets/img/default_img_prev.png" alt="Image preview">
        </section>

        <section id="detail">
            <section id="post_detail">
                <!-- TODO: Add more details here -->
                <h3 id="poster_name"></h3>
                <p id="poster_id"></p>
                <h1 id="title"></h1>
                <h2 id="description"></h2>
                <p id="date"></p>
            </section>

            <section id="comment">
                <div class="comment_list">
                    <div class="comment_wrapper">
                        <!-- Original comment -->
                        <section id="original_comment">
                            <div class="commenter_img"></div>
                            <div class="comment_header">
                                <div class="commenter_name"></div>
                                <div class="comment_date"></div>
                            </div>
                            <div class="comment_content"></div>
                        </section>

                        <!-- Replied comment -->
                        <section id="reply_list">
                            <div class="commenter_img"></div>
                            <div class="comment_header">
                                <div class="commenter_name"></div>
                                <div class="comment_date"></div>
                            </div>
                            <div class="comment_content"></div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
    </section>
</div>
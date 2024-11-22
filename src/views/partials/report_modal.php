<?php
?>

<link rel="stylesheet" href="../assets/style/report.css">

<section id="report_modal" class="modal-wrapper">
    <span class="result_box"></span>

    <section class="modal report light-background">
        <form class="flex-column" action="" method="POST">
            <span>
                <h3 class="modal-header dark-text">DESCRIBE YOUR REPORT HERE</h3>
                <p class="dark-text">Lorem ipsum dolor sit amet.</p>
            </span>

            <textarea class="description" name="description" id="description" cols="30" rows="10" maxlength="300" placeholder="Description"></textarea>

            <section class="button flex-row">
                <button class="dark-background light-text"  type="button" id="cancel_btn">CANCEL</button>
                <button class="dark-background light-text" type="submit" id="report_btn">SUBMIT REPORT</button>
            </section>
        </form>
    </section>
</section>
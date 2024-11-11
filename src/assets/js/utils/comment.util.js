export function display_comment(data) {
    const comment_list = document.querySelector('.comment_list')

    // Using a template string to create the comment structure
    const comment_HTML = `
        <div class="comment_wrapper">
            <section class="original_comment comment_box">
                <div class="commenter_img">
                    <img src="${data.img_url || '../assets/img/default_img_prev.png'}" alt="Commenter Image">
                </div>
                <div class="comment_detail">
                    <div class="comment_header">
                        <h4 class="commenter_name">${data.commenter_name || 'Anonymous'}</h4>
                        <p class="comment_date">${data.comment_date || 'Unknown Date'}</p>
                    </div>
                    <p class="comment_content">
                        ${data.comment_content || 'No content provided'}
                    </p>
                </div>
            </section>
        </div>`

    // Convert the string to an HTML element and append it
    comment_list.insertAdjacentHTML('afterbegin', comment_HTML)
}

export function remove_comment(data) {
    document.querySelector('.comment_list').innerHTML = ''
}
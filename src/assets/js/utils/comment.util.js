import { get_data, test_response } from '../utils/request.js'

export function display_comment(data) {
	const comment_list = document.querySelector('.comment-list')

	// Using a template string to create the comment structure
	const comment_HTML = `
        <div class="comment-wrapper">
            <section class="original-comment comment-box flex-row">
				<a href="../views/profile.php?page=profile&id=${
							data.commenter_id ?? null
						}">
					<div class="commenter-img">
						<img src="${
												data.img_url || '../assets/img/default_img_prev.png'
											}" alt="Commenter Image">
					</div>
					<div class="comment-detail">
						<div class="comment-header flex-row">
							<h4 class="commenter-name dark-text">${
														data.commenter_name || 'Anonymous'
													}</h4>
							<p class="comment-date dark-text">${
														data.comment_date || 'Unknown Date'
													}</p>
						</div>
					</a>
                    <p class="comment-content dark-text">
                        ${data.comment_content || 'No content provided'}
                    </p>
                </div>
            </section>
        </div>`

	// Convert the string to an HTML element and append it
	comment_list.insertAdjacentHTML('afterbegin', comment_HTML)
}

export function remove_comment() {
	document.querySelector('.comment-list').innerHTML = ''
}

export function display_comments_in_batches(
    img_id,
	records,
	batch_size = 5,
	delay = 200
) {
	let index = 0

	function displayNextBatch() {
		const batch = records.slice(index, index + batch_size)
		batch.forEach((record) => {
			if (parseInt(img_id) === record['post_id']) {
				display_comment({
					img_url: record['profile_url'],
					commenter_id: record['commenter_id'],
					commenter_name: record['username'],
					comment_content: record['cmment'],
					comment_date: record['date_time'],
				})
			}
		})
		index += batch_size
		if (index < records.length) {
			setTimeout(displayNextBatch, delay)
		}
	}

	displayNextBatch()
}

export let has_already_ran = { status: false }
export async function fetch_post_comments(img_source) {
	try {
		const response = await get_data(
			`../api/fetch_comment.php?has_already_ran=${has_already_ran['status']}`
		)
		const test = test_response(response)
		if (!test['status']) {
			return {
				status: false,
				message: test['message']
			}
		}

		display_comments_in_batches(img_source.getAttribute('data-id'), response['data'])
        return {
            status: true,
            message: 'Comments fetched successfully!',
        }
	} catch (error) {
		throw new Error(error['message'])
	}
}

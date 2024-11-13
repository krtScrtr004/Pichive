import { get_data } from '../utils/request.js'

export function display_comment(data) {
	const comment_list = document.querySelector('.comment_list')

	// Using a template string to create the comment structure
	const comment_HTML = `
        <div class="comment_wrapper">
            <section class="original_comment comment_box">
                <div class="commenter_img">
                    <img src="${
											data.img_url || '../assets/img/default_img_prev.png'
										}" alt="Commenter Image">
                </div>
                <div class="comment_detail">
                    <div class="comment_header">
                        <h4 class="commenter_name">${
													data.commenter_name || 'Anonymous'
												}</h4>
                        <p class="comment_date">${
													data.comment_date || 'Unknown Date'
												}</p>
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

export function remove_comment() {
	document.querySelector('.comment_list').innerHTML = ''
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
					img_url: record['img_url'],
					commenter_name: record['commenter_name'],
					comment_content: record['comment'],
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
		const data = await get_data(
			`../api/fetch_comment.php?has_already_ran=${has_already_ran['status']}`
		)
		if (!data) {
			return {
				status: false,
				message:
					'Response was not successfully recieved while fetching comment!',
			}
		} else if (data['status'] === 'fail') {
			return {
                status: false,
                message: data['message']
            }
		}

		display_comments_in_batches(img_source.getAttribute('data-id'), data['data'])
        return {
            status: true,
            message: 'Comments fetched successfully!',
        }
	} catch (error) {
		throw new Error(error['message'])
	}
}

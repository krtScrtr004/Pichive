import { send_data } from '../utils/request.js'
import { display_comment, fetch_post_comments } from '../utils/comment.util.js'
import { has_already_ran } from '../utils/comment.util.js'

const result = document.querySelector('.result')
const img_source = document.querySelector('#img_view>img')
const submit_comment_btn = document.querySelector('#submit_comment_btn')

let is_loading = false

submit_comment_btn.onclick = async (e) => {
	e.preventDefault()

	const input_comment = document.querySelector('#input_comment')
	try {
		const data = await send_data('../api/write_comment.php', {
			post_id: img_source.getAttribute('data-id'),
			comment: input_comment.value,
		})

		if (!data) {
			result.innerHTML =
				'Response was not successfully recieved while adding comment!'
			return
		} else if (data['status'] === 'fail') {
			result.innerHTML = data['message']
			return
		}

		result.innserHTML = data['message']
		display_comment({
			// Display new comment
			img_url: data['data']['img_url'],
			commenter_name: data['data']['commenter_name'],
			comment_content: input_comment.value,
			comment_date: data['data']['comment_date'],
		})
	} catch (error) {
		result.innserHTML = error['message']
	}
}

setInterval(async () => {
	const modal_wrapper = document.querySelector('.modal_wrapper')
	if (!modal_wrapper.classList.contains('show_modal') || is_loading) {
		return
	}
	is_loading = true

	try {
		const result = await fetch_post_comments(img_source)
		if (!result['status']) {
			result.innerHTML = result['message']
			is_loading = false
		}

		has_already_ran['status'] = true // Set to true to prevent fetching comments again in the next interval
		is_loading = false
	} catch (error) {
		result.innserHTML = error
	}
}, 10000)

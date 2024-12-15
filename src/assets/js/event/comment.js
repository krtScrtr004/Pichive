import { send_data, test_response } from '../utils/request.js'
import { display_comment, fetch_post_comments } from '../utils/comment.util.js'
import { has_already_ran } from '../utils/comment.util.js'
import { form_reset } from '../utils/utils.js'

document.addEventListener('DOMContentLoaded', () => {
	const result = document.querySelector('.result')
	const submit_comment_btn = document.querySelector('#submit_comment_btn')

	const input_comment = document.querySelector('#input_comment')
	input_comment.oninput = () => {
		const char_count = input_comment.value.length;
		const max_char = 50;

		const write_comment_form = document.querySelector('.write-comment-form')
		if (char_count >= max_char) {
			write_comment_form.style.height = '25%'; // Increase height of comment input box
		} else {
			input_comment.style.height = '100%'; 
		}
	};

	let is_loading = false

	submit_comment_btn.onclick = async (e) => {
		e.preventDefault()

		const img_source = document.querySelector('.img-view>img')
		try {
			const response = await send_data('../api/write_comment.php', {
				post_id: img_source.getAttribute('data-id'),
				comment: input_comment.value,
			})

			const test = test_response(response)
			if (!test['status']) {
				throw new Error(test['message'])
			}

			result.innserHTML = response['message']
			display_comment({
				// Display new comment
				img_url: response['data']['img_url'],
				commenter_name: response['data']['commenter_name'],
				comment_content: input_comment.value,
				comment_date: response['data']['comment_date'],
			})
			form_reset(write_comment_form)
		} catch (error) {
			result.innserHTML = error
		}
	}

	setInterval(async () => {
		const post_modal = document.querySelector('#post_modal')
		if (!post_modal.classList.contains('show-modal') || is_loading) {
			return
		}
		is_loading = true

		try {
			const result = await fetch_post_comments(document.querySelector('.img-view>img'))
			if (!result['status']) {
				is_loading = false
				throw new Error(result['message'])
			}

			has_already_ran['status'] = true // Set to true to prevent fetching comments again in the next interval
			is_loading = false
		} catch (error) {
			result.innserHTML = error
		}
	}, 10000)
})

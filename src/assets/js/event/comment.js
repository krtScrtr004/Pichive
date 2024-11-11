import { get_data, send_data } from '../utils/request.js'
import { display_comment } from '../utils/comment.util.js'

export let has_already_ran = { status: false }

const modal_wrapper = document.querySelector('.modal_wrapper')
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
			result_box.innerHTML =
				'Response was not successfully recieved while adding comment!'
			return
		} else if (data['status'] === 'fail') {
			result_box.innerHTML = data['message']
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
	if (!modal_wrapper.classList.contains('show_modal') || is_loading) {
		return
	}
	is_loading = true

	try {
		const data = await get_data(
			`../api/fetch_post_comment.php?has_already_ran=${has_already_ran['status']}`
		)
		if (!data) {
			result_box.innerHTML =
				'Response was not successfully recieved while fetching comment!'
			is_loading = false
			return
		} else if (data['status'] === 'fail') {
			result_box.innerHTML = data['message']
			is_loading = false
			return
		}

		const records = data['data']
		records.forEach((record) => {
			if (parseInt(img_source.getAttribute('data-id')) === record['post_id']) {
				display_comment({
					img_url: record['img_url'],
					commenter_name: record['commenter_name'],
					comment_content: record['comment'],
					comment_date: record['date_time'],
				})
			}
		})
		has_already_ran['status'] = true // Set to true to prevent fetching comments again in the next interval
		is_loading = false
	} catch (error) {
		result.innserHTML = error['message']
	}
}, '4000')

import { send_data, test_response } from '../utils/request.js'

document.addEventListener('DOMContentLoaded', async () => {
	const result_box = document.querySelector('.result-box')

	const follow_user_btn = document.querySelector('#follow_user_btn')
	const block_user_btn = document.querySelector('#block_user_btn')

	if (follow_user_btn && block_user_btn) {
		const body = document.querySelector('body')

		follow_user_btn.onclick = async () => {
			try {
				const response = await send_data('../api/follow_user.php', {
					id: body.getAttribute('data-id'),
					is_followed: body.getAttribute('data-followed'),
				})
				const test = test_response(response)
				if (!test['status']) {
					result_box.innerHTML = test['message']
					return
				}

				result_box.innerHTML = response['message']
			} catch (error) {
				result_box.innerHTML = error['message']
			}
		}
	}
})

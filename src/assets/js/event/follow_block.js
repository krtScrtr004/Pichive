import { send_data, test_response } from '../utils/request.js'
import { listed_followed_user } from '../utils/fetch_user_list.util.js'

document.addEventListener('DOMContentLoaded', async () => {
	// const result_box = document.querySelector('.result-box')

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
					throw new Error(test['message'])
				}

				if (body.getAttribute('data-followed') === '0') {
					follow_user_btn.innerHTML = 'Unfollow'
				} else {
					follow_user_btn.innerHTML = 'Follow'
					if (listed_followed_user.has(body.getAttribute('data-id'))) {
						listed_followed_user.delete(body.getAttribute('data-id'))
					}
				}

				alert(response['message'])
			} catch (error) {
				alert(error.message)
				console.error(error.message)
			}
		}

		block_user_btn.onclick = async () => {
			try {
				const response = await send_data('../api/block_user.php', {
					id: body.getAttribute('data-id'),
					is_blocked: body.getAttribute('data-blocked'),
				})
				const test = test_response(response)
				if (!test['status']) {
					throw new Error(test['message'])
				}

				follow_user_btn.innerHTML = 'Follow'
				if (body.getAttribute('data-blocked') === '0') {
					follow_user_btn.disabled = true
					block_user_btn.innerHTML = 'Unblock'
					body.setAttribute('data-followed', 0)
					body.setAttribute('data-blocked', 1)
					if (listed_followed_user.has(body.getAttribute('data-id'))) {
						listed_followed_user.delete(body.getAttribute('data-id'))
					}
				} else {
					follow_user_btn.disabled = false
					block_user_btn.innerHTML = 'Block'
					body.setAttribute('data-blocked', 0)
				}

				alert(response['message'])
			} catch (error) {
				alert(error.message)
				console.error(error.message)
			}
		}
	}
})

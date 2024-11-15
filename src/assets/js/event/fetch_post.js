import { handle_scroll, load_posts } from '../utils/fetch_post.util.js'
import { remove_comment, has_already_ran } from '../utils/comment.util.js'
import { remove_details } from '../utils/fetch_post.util.js'

document.addEventListener('DOMContentLoaded', async () => {
	await load_posts()

	// Add scroll event listener
	document.querySelector('.center').addEventListener('scroll', handle_scroll)

	const post_modal = document.querySelector('#post_modal')
	window.onclick = (e) => {
		if (e.target === post_modal) {
			post_modal.classList.remove('show-modal')
			has_already_ran['status'] = false
			remove_comment()
			remove_details()
		}
	}
})

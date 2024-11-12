import { handle_scroll, load_posts } from '../utils/fetch_post.util.js'
import { remove_comment, has_already_ran } from '../utils/comment.util.js'
import { remove_details } from '../utils/fetch_post.util.js'

document.addEventListener('DOMContentLoaded', async () => {
	await load_posts()

	// Add scroll event listener
	window.addEventListener('scroll', handle_scroll)

	const modal_wrapper = document.querySelector('.modal_wrapper')
	window.onclick = (e) => {
		if (e.target === modal_wrapper) {
			modal_wrapper.classList.remove('show_modal')
			has_already_ran['status'] = false
			remove_comment()
			remove_details()
		}
	}
})

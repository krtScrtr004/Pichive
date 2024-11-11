import { handle_scroll, load_posts } from '../utils/fetch_img.util.js'


document.addEventListener('DOMContentLoaded', async () => {
	await load_posts()

	// Add scroll event listener
	window.addEventListener('scroll', handle_scroll)

	const modal_wrapper = document.querySelector('.modal_wrapper')
	window.onclick = (e) => {
		if (e.target === modal_wrapper) {
			modal_wrapper.classList.remove('show_modal')
		}
	}
})

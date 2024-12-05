import { load_posts, offset } from './fetch_post.js'

const tabs = document.querySelectorAll('.post-tabs button')
const img_grid = document.querySelectorAll('.img-grid')

if (tabs) {
	// tabs.forEach((tab, index) => {
	//     tab.addEventListener('click', () => {
	//         contents.forEach(content => {
	//             content.classList.remove('active')
	//         });

	//         contents[index].classList.add('active')
	//     })
	// })

	own_post_tab.onclick = async () => {
        offset['current_count'] = 0

		if (document.querySelector('.content.active')) {
			document.querySelector('.content.active').remove()
		}

		const profile_posts = document.querySelector('.profile-posts')
		const img_grid_HTML = `<div class="content active img-grid" data-content="profile" data-id="${document
			.querySelector('body')
			.getAttribute('data-id')}"></div>`

		profile_posts.insertAdjacentHTML('beforeend', img_grid_HTML)

		try {
			await load_posts()
		} catch (error) {
			console.error('Error loading posts:', error)
		}
	}

	liked_post_tab.onclick = async () => {
        offset['current_count'] = 0

		if (document.querySelector('.content.active')) {
			document.querySelector('.content.active').remove()
		}

		const profile_posts = document.querySelector('.profile-posts')
		const img_grid_HTML = `<div class="content active img-grid" data-content="like"></div>`

		profile_posts.insertAdjacentHTML('beforeend', img_grid_HTML)
		try {
			await load_posts()
		} catch (error) {
			console.error('Error loading posts:', error)
		}
	}
}

own_post_tab.click()

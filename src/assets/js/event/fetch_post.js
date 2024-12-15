import { get_data, send_data, test_response } from '../utils/request.js'
import { add_post_details } from '../utils/fetch_post.util.js'
import { remove_comment, has_already_ran } from '../utils/comment.util.js'
import { remove_details } from '../utils/fetch_post.util.js'
import { form_reset } from '../utils/utils.js'

export let offset = { current_count: 0 }
const limit = 9
let is_loading = false // Flag to prevent multiple calls

// document.addEventListener('DOMContentLoaded', async () => {
const post_modal = document.querySelector('#post_modal')
// const result_box = document.querySelector('.result')
const center = document.querySelector('.center')

await load_posts()

// Add scroll event listener
document.querySelector('.center').addEventListener('scroll', handle_scroll)

post_modal.onclick = (e) => {
	if (e.target === post_modal) {
		post_modal.classList.remove('show-modal')
		has_already_ran['status'] = false
		remove_comment()
		remove_details()
		form_reset(document.querySelector('#comment_form'))
	}
}

async function handle_scroll() {
	if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
		await load_posts()
	}
}

export async function load_posts() {
	if (is_loading) {
		return
	}
	is_loading = true

	const loading = document.querySelector('.loading')
	loading.style.display = 'block'

	try {
		const img_grid = document.querySelector('.img-grid')
		if (!img_grid) {
			is_loading = false
			return
		}

		const content_type = img_grid.getAttribute('data-content')
		let response = null
		if (content_type !== 'search') {
			response = await get_data(
				`../api/fetch_post.php?content_type=${content_type ?? 'home'}&id=${
					img_grid.getAttribute('data-id') ?? null
				}&offset=${offset['current_count']}&limit=${limit}`
			)
		} else {
			const query_params = window.location.search
			const params = new URLSearchParams(query_params)
			const search_term = params.get('term')

			response = await send_data('../api/search_post.php', {
				search_term: search_term,
				offset: offset['current_count'],
			})
		}

		const test = test_response(response)
		if (!test['status']) {
			center.removeEventListener('scroll', handle_scroll)
			loading.style.display = 'none'
			is_loading = false
			throw new Error(test['message'])
		}

		const data = response['data']
		if (!data || data.length === 0) {
			center.removeEventListener('scroll', handle_scroll)
			loading.style.display = 'none'
			is_loading = false
			return
		}

		// Iterate over each post and create image elements
		data.forEach((post) => {
			// Create image
			const img = document.createElement('img')
			img.src = post['img_url']
			img.loading = 'lazy'

			// Create image container
			const new_img_cont = document.createElement('div')
			new_img_cont.classList.add('img-cont')
			new_img_cont.appendChild(img)
			new_img_cont.onclick = async () => {
				// Open post modal when img container it clicked
				await add_post_details(post)
			}

			img_grid.appendChild(new_img_cont)
		})

		// Update offset for the next batch of data
		offset['current_count'] += limit
		loading.style.display = 'none'
		is_loading = false // Reset loading flag
	} catch (error) {
		alert(error.message)
		console.error(error.message)
	}
}
// })

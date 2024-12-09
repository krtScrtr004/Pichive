import { get_data, test_response } from './request.js'
import { has_already_ran, fetch_post_comments } from '../utils/comment.util.js'

const result_box = document.querySelector('.result')
const center = document.querySelector('.center')

let offset = 0
const limit = 9
let is_loading = false // Flag to prevent multiple calls

export function handle_scroll() {
	if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
		load_posts()
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
		let response = await get_data(
			`../api/fetch_post.php?content_type=${img_grid.getAttribute(
				'data-content'
			) ?? 'home'}&id=${img_grid.getAttribute('data-id') ?? null}&offset=${offset}&limit=${limit}`
		)
		const test = test_response(response)
		if (!test) {
			result_box.innerHTML = test['message']
			center.removeEventListener('scroll', handle_scroll)
			loading.style.display = 'none'
			is_loading = false
			return
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
		offset += limit
		loading.style.display = 'none'
		is_loading = false // Reset loading flag
	} catch (error) {
		result_box.innerHTML = error['message']
	}
}

async function add_post_details(post) {
	if (!post) {
		result_box.innerHTML = 'Failed to fetch post details!'
		return
	}

	// Open post modal
	const post_modal = document.querySelector('#post_modal')
	post_modal.classList.add('show-modal')
	display_detail({
		id: post['id'],
		img_url: post['img_url'],
		username: post['username'],
		poster_id: post['poster_id'],
		title: post['title'],
		description: post['description'],
		date: post['date_time'],
	})

	// Fetch post comments
	const img_source = document.querySelector('.img-view>img')
	let fetch_comment = null
	if (!has_already_ran['status']) {
		fetch_comment = await fetch_post_comments(img_source)
	}
	if (!fetch_comment['status']) {
		result_box.innerHTML = 'Failed to fetch comments!'
	}
	has_already_ran['status'] = true
}

function display_detail(data) {
	if (!data) {
		return
	}

	const img_view = document.querySelector('.img-view')
	const img_HTML = `<img src="${
		data.img_url || '../assets/img/default_img_prev.png'
	}" alt="Image preview" data-id=${data.id || null}>`
	img_view.insertAdjacentHTML('afterbegin', img_HTML)

	const post_detail = document.querySelector('.post-detail')
	const detail_HTML = `
                <h3 id="poster-name">${data.username || 'Anonymous'}</h3>
                <p id="poster-id">${data.poster_id || 'Unknown'}</p>
                <h1 id="title">${data.title || 'Untitled'}</h1>
                <h2 id="description">${data.description || 'NA'}</h2>
                <p id="date">${data.date || 'Unkown Date'}</p>`
	post_detail.insertAdjacentHTML('afterbegin', detail_HTML)
}

export function remove_details() {
	document.querySelector('.img-view').innerHTML = ''
	document.querySelector('.post-detail').innerHTML = ''
}

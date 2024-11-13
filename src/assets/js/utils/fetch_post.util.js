import { get_data, test_response } from './request.js'
import { has_already_ran, fetch_post_comments } from '../utils/comment.util.js'

const result_box = document.querySelector('#result-box')

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

	const loading = document.querySelector('#loading')
	loading.style.display = 'block'

	try {
		const page_type = document.querySelector('#page_type')
		let response = await get_data(
			`../api/fetch_post.php?page_type=${page_type.getAttribute(
				'data-page'
			)}&offset=${offset}&limit=${limit}`
		)
		const test = test_response(response)
		if (!test) {
			result_box.innerHTML = test['message']
			window.removeEventListener('scroll', handle_scroll)
			loading.style.display = 'none'
			is_loading = false
			return
		}

		const data = response['data']
		if (data.length === 0) {
			window.removeEventListener('scroll', handle_scroll)
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
			new_img_cont.classList.add('img_cont')
			new_img_cont.appendChild(img)
			new_img_cont.onclick = async () => {
				// Open post modal when img container it clicked
				await add_post_details(post)
			}
			document.querySelector('.img_grid').appendChild(new_img_cont)

			// Update offset for the next batch of data
			offset += limit
			loading.style.display = 'none'
			is_loading = false // Reset loading flag
		})
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
	const modal_wrapper = document.querySelector('.modal_wrapper')
	modal_wrapper.classList.add('show_modal')
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
	const img_source = document.querySelector('#img_view>img')
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

	const img_view = document.querySelector('#img_view')
	const img_HTML = `<img src="${
		data.img_url || '../assets/img/default_img_prev.png'
	}" alt="Image preview" data-id=${data.id || null}>`
	img_view.insertAdjacentHTML('afterbegin', img_HTML)

	const post_detail = document.querySelector('.post_detail')
	const detail_HTML = `
                <h3 id="poster_name">${data.username || 'Anonymous'}</h3>
                <p id="poster_id">${data.poster_id || 'Unknown'}</p>
                <h1 id="title">${data.title || 'Untitled'}</h1>
                <h2 id="description">${data.description || 'NA'}</h2>
                <p id="date">${data.date || 'Unkown Date'}</p>`
	post_detail.insertAdjacentHTML('afterbegin', detail_HTML)
}

export function remove_details() {
	document.querySelector('#img_view').innerHTML = ''
	document.querySelector('.post_detail').innerHTML = ''
}

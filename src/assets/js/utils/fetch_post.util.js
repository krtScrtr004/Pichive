import { get_data, send_data, test_response } from './request.js'
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
			`../api/fetch_post.php?content_type=${
				img_grid.getAttribute('data-content') ?? 'home'
			}&id=${
				img_grid.getAttribute('data-id') ?? null
			}&offset=${offset}&limit=${limit}`
		)
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
		offset += limit
		loading.style.display = 'none'
		is_loading = false // Reset loading flag
	} catch (error) {
		result_box.innerHTML = error
	}
}

async function add_post_details(post) {
	if (!post) {
		throw new Error('Failed to fetch post details!')
	}

	// Open post modal
	const post_modal = document.querySelector('#post_modal')
	post_modal.classList.add('show-modal')
	display_detail(post)

	add_modal_event(post)

	// Fetch post comments
	const img_source = document.querySelector('.img-view>img')
	let fetch_comment = null
	if (!has_already_ran['status']) {
		fetch_comment = await fetch_post_comments(img_source)
	}
	if (!fetch_comment['status']) {
		throw new Error('Failed to fetch comments!')
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
	}" alt="Image preview" data-id=${data.id || null} data-like="${
		data.is_liked || 0
	}">
	
	<div class="img-view-icons flex-column">
		<div id="like" class="icon-cont">
			<img src="../assets/img/icons/${
				data.is_liked === 1 ? 'Highlight' : 'Light'
			}/Like.svg" alt="">
			<p class="light-text">${data.likes}</p>
		</div>
		<div id="copy_link" class="icon-cont">
			<img src="../assets/img/icons/Light/Link.svg" alt="">
			<p class="light-text">Copy<br>Link</p>
		</div>
		<div id="report" class="icon-cont">
			<img src="../assets/img/icons/Light/Block.svg" alt="">
			<p class="light-text">Report</p>
		</div>
	</div>`
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

function add_modal_event(post) {
	const modal = document.querySelector('#post_modal>.modal')
	modal.onmouseover = () => {
		const img_view_icons = document.querySelector('.img-view-icons')
		img_view_icons.classList.add('flex-column')
		img_view_icons.style.backgroundColor = 'rgba(28, 30, 31, 0.5)'
	}

	modal.onmouseout = () => {
		const img_view_icons = document.querySelector('.img-view-icons')
		img_view_icons.classList.remove('flex-column')
		img_view_icons.style.backgroundColor = ''
	}

	add_icon_event(post)
}

function add_icon_event(post) {
	const like = document.querySelector('#like')
	const copy_link = document.querySelector('#copy_link')
	const report = document.querySelector('#report')

	like.onclick = async () => {
		try {
			const img_view = document.querySelector('.img-view>img')
			const response = await send_data('../api/like_post.php', {
				id: img_view.getAttribute('data-id'),
				is_liked: img_view.getAttribute('data-like'),
			})
			const test = test_response(response)
			if (!test['status']) {
				throw new Error(test['message'])
			}

			if (img_view.getAttribute('data-like') === '0') {
				img_view.setAttribute('data-like', '1')
				like.querySelector('img').src = '../assets/img/icons/Highlight/Like.svg'
				like.querySelector('p').textContent =
					parseInt(like.querySelector('p').textContent) + 1
				like.querySelector('p').style.color = 'rgb(253, 210, 0)'
			} else {
				img_view.setAttribute('data-like', '0')
				like.querySelector('img').src = '../assets/img/icons/Light/Like.svg'
				like.querySelector('p').textContent =
					parseInt(like.querySelector('p').textContent) - 1
				like.querySelector('p').style.color = 'rgb(233, 233, 233)'
			}
		} catch (error) {
			result_box.innerHTML = error
		}
	}

	copy_link.onclick = async () => {
		navigator.clipboard
			.writeText(post['img_url'])
			.then(() => {
				// TODO:
				// result_box.innerHTML = 'URL copied to clipboard!';
			})
			.catch((error) => {
				result_box.innerHTML = error
			})
	}

	report.onclick = async () => {
		const report_modal = document.querySelector('#report_modal')
		report_modal.classList.add('show-modal')

		report_modal.onclick = (e) => {
			if (e.target === report_modal) {
				report_modal.classList.remove('show-modal')
			}
		}

		document.querySelector('#report_modal #cancel_btn').onclick = () => {
			report_modal.classList.remove('show-modal')
		}

		document.querySelector('#report_btn').onclick = async () => {
			try {
				const description = document.querySelector(
					'#report_modal form #description'
				)
				const response = await send_data('../api/report_post.php', {
					id: post['id'],
					description: description.value,
				})
				const test = test_response(response)
				if (!test['status']) {
					throw new Error(test['message'])
				}

				// TODO:
			} catch (error) {
				result_box.innerHTML = error
			}
		}
	}
}

export function remove_details() {
	document.querySelector('.img-view').innerHTML = ''
	document.querySelector('.post-detail').innerHTML = ''
}

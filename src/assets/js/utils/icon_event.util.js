import { send_data, test_response } from './request.js'

const result_box = document.querySelector('.result')

export function add_modal_event(post) {
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
    const edit = document.querySelector('#edit_post')
	const copy_link = document.querySelector('#copy_link')
	const report = document.querySelector('#report')

	like.onclick = async () => {
		try {
			like_event()
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

	if (edit) {
		edit.onclick = async () => {
			try {
				edit_event(post)
			} catch (error) {
				result_box.innerHTML = error
			}
		}
	}

	if (report) {
		report.onclick = async () => {try {
            report_event(post)
        } catch (error) {
            result_box.innerHTML = error
        }}
	}
}

async function like_event() {
	const like = document.querySelector('#like')

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
}

async function edit_event(post) {
	const edit_post_modal = document.querySelector('#edit_post_modal')
	edit_post_modal.classList.add('show-modal')

	const img = document.querySelector('#post_img')
	const title = document.querySelector('#edit_post_modal #title')
	const description = document.querySelector('#edit_post_modal #description')

	img.src = post['img_url']
	title.value = post['title']
	description.value = post['description']

	edit_post_modal.onclick = (e) => {
		if (e.target === edit_post_modal) {
			edit_post_modal.classList.remove('show-modal')
		}
	}

	document.querySelector('#edit_post_modal #cancel_btn').onclick = () => {
		edit_post_modal.classList.remove('show-modal')
	}

	document.querySelector('#edit_post_modal #edit_btn').onclick = async () => {
		const response = await send_data('../api/edit_post.php', {
			id: post['id'],
			title: title.value,
			description: description.value,
		})
		const test = test_response(response)
		if (!test['status']) {
			throw new Error(test['message'])
		}

		// TODO:
        location.reload()
	}
}

async function report_event(post) {
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
		location.reload()
	}
}

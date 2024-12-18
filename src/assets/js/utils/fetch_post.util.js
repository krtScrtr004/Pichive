import { has_already_ran, fetch_post_comments } from './comment.util.js'
import { add_modal_event } from './icon_event.util.js'

export async function add_post_details(post) {
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

	const img_view = document.querySelector('#post_modal .img-view')
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
		${
			data.is_own === 1
				? `
            <div id="edit_post" class="icon-cont">
                <img src="../assets/img/icons/Light/Edit.svg" alt="">
                <p class="light-text">Edit</p>
            </div>
        `
				: `
            <div id="report" class="icon-cont">
                <img src="../assets/img/icons/Light/Block.svg" alt="">
                <p class="light-text">Report</p>
            </div>
        `
		}
	</div>`
	img_view.insertAdjacentHTML('afterbegin', img_HTML)

	const post_detail = document.querySelector('.post-detail')
	const detail_HTML = `
				<div class="poster-info flex-row">
                    <a class="flex-row" href="../views/profile.php?page=profile&id=${
							data.poster_id ?? null
						}">
                        <img class="circle" src="${data.profile_url || '../assets/img/default_img_prev.png'}" alt="Poster Profile Icon" title="Poster Profile Icon" witdh="50" height="50">
                    

						<div class="flex-column">
							<h3 id="poster_name" class="light-text">${data.username || 'Anonymous'}</h3>
							<p id="poster_id" class="light-text">${data.poster_id || 'Unknown'}</p>
						</div>
					</a>

                    <div class="flex-row">
                        <p id="post_date" class="light-text">${data.date_time || 'Unkown Date'}</p>
                    </div>
                </div>

				<div class="post-info flex-column">
					<h1 id="post_title" class="light-text heading-title">${data.title || 'Untitled'}</h1>
					<p id="post_description" class="light-text">${data.description || 'No description...'}</p>
				</div>
            </div>`
	post_detail.insertAdjacentHTML('afterbegin', detail_HTML)
}

export function remove_details() {
	document.querySelector('.img-view').innerHTML = ''
	document.querySelector('.post-detail').innerHTML = ''
}
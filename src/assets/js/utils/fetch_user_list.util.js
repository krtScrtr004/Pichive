import { get_data, send_data, test_response } from './request.js'

function display_sidenav_user(user) {
	const followed_user_list = document.querySelector('#followed_user_list')

	const user_HTML = `
        <li class="link-wrapper list">
            <a class="nav-link list" href="../views/profile.php?page=profile&id=${
							user.id ?? null
						}">
                <img class="circle" src="${
									user.profile_url ?? '../assets/img/icons/Light/Profile.svg'
								}" alt="" width="32" height="32">
                <h3>${user.username ?? 'Anonymous'}</h3>
            </a>
        </li>`

	followed_user_list.insertAdjacentHTML('beforeend', user_HTML)
}

function display_search_user(user) {
	const search_user_list = document.querySelector('#search_user_list')

	const user_HTML = `
        <div class="user-wrapper list">
            <a class="flex-row" href="../views/profile.php?page=profile&id=${
							user.id ?? null
						}">
                <img class="circle" src="${
									user.profile_url ?? '../assets/img/default_img_prev.png'
								}" alt="User Profile" title="User Profile" width="36" height="36">

                <span class="user-details flex-column">
                    <h4>${user.username ?? 'Anonymous'}</h4>
                    <p>${user.id ?? '00000000-0000-0000-0000-000000000000'}</p>
                </span>
            </a>
        </div>`

	search_user_list.insertAdjacentHTML('beforeend', user_HTML)
}

let offset = 0
const limit = 15

let is_loading = false
let has_loaded = false

export const listed_followed_user = new Set() // Use to monitor users who already have been listed in the sidenav
export async function fetch_user(content) {
	if (is_loading) {
		return
	}
	is_loading = true

	try {
		let response = null

		if (content === 'sidenav') {
			response = await get_data(`../api/fetch_user.php?relation=followed`)
		} else {
			const query_params = window.location.search
			const params = new URLSearchParams(query_params)
			const search_term = params.get('term')

			response = await send_data('../api/search_user.php', {
				search_term: search_term,
				offset: offset,
			})
		}

		const test = test_response(response)
		if (!test) {
			is_loading = false
			throw new Error(test['message'])
		}
		const data = response['data']
		if (data.length === 0 && !has_loaded) {
			if (content === 'sidenav') {
				document.querySelector('.sidenav-result').innerHTML =
					'You have no followed users.'
			} else {
				document.querySelector('#search_user_list').innerHTML =
					'No users found.'
			}
			is_loading = false
            return
		}

		data.forEach((user, index) => {
			if (content === 'sidenav' && !listed_followed_user.has(user['id'])) {
				if (index >= 5) {
					is_loading = false
					return
				}

				// Display user in sidenav only if it's not already there and there are only 5 users to display in the sidenav
				display_sidenav_user(user)
				listed_followed_user.add(user['id'])
			} else {
				display_search_user(user)
			}
		})

		is_loading = false
        has_loaded = true
		offset += limit
	} catch (error) {
		alert(error.message)
		console.error(error.message)
	}
}

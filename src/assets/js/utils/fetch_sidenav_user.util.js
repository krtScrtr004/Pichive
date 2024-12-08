import { get_data, test_response } from '../utils/request.js'

function display_sidenav_user(user) {
    const following_user_list = document.querySelector('#following_user_list')

    const sidenav_user_HTML = `
        <li class="link-wrapper list">
            <a class="nav-link list" href="../views/profile.php?page=profile&id=${user.id ?? null}">
                <img class="circle" src="${user.profile_url ?? '../assets/img/icons/Light/Profile.svg'}" alt="" width="32" height="32">
                <h3>${user.username ?? 'Anonymous'}</h3>
            </a>
        </li>`

    following_user_list.insertAdjacentHTML('beforeend', sidenav_user_HTML)
}

export const listed_followed_user = new Set() // Use to monitor users who already have been listed in the sidenav
export async function fetch_followed_user() {
    try {
        const response  = await get_data(`../api/fetch_user.php?relation=followed`);
        const test = test_response(response)
        if (!test) {
			throw new Error(test['message'])
		}
        const data = response['data']
        if (data.length === 0) {
            document.querySelector('.sidenav-result').innerHTML = 'You have no followed users.'
            return
        }

        data.forEach((user, index) => {
            if (index >= 5) {
                return
            }

            if (!listed_followed_user.has(user['id'])) {
                display_sidenav_user(user)
                listed_followed_user.add(user['id'])
            }
        })

    } catch (error) {
        sidenav_result.innerHTML = error
    }
}
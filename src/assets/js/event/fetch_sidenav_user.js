import { get_data, test_response } from '../utils/request.js'

document.addEventListener('DOMContentLoaded', async () => {
    const sidenav_result = document.querySelector('.sidenav-result')

    try {
        const response  = await get_data(`../api/fetch_user.php?relation=followed`);
        const test = test_response(response)
        if (!test) {
			sidenav_result.innerHTML = test['message']
			return
		}

        const data = response['data']
        if (!data) {
            sidenav_result.innerHTML = 'You have no followed users.'
            return
        }
        data.forEach((user) => {
            display_sidenav_user(user)
        })

    } catch (error) {
        sidenav_result.innerHTML = error['message']
    }

    function display_sidenav_user(user) {
        const following_user_list = document.querySelector('#following_user_list')

        const sidenav_user_HTML = `
            <li class="link-wrapper">
                <a class="nav-link" href="../views/profile.php?page=profile&id=${user.id ?? null}">
                    <img class="circle" src="${user.profile_url ?? '../assets/img/icons/Light/Profile.svg'}" alt="" width="32" height="32">
                    <h3>${user.username ?? 'Anonymous'}</h3>
                </a>
            </li>`

        following_user_list.insertAdjacentHTML('beforeend', sidenav_user_HTML)
    }
})
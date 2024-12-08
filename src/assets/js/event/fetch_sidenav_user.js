import { fetch_user } from '../utils/fetch_user_list.util.js'

document.addEventListener('DOMContentLoaded', async () => {
	const sidenav_result = document.querySelector('.sidenav-result')

	try {
        // Fetch followed users for the first time
		await fetch_user('sidenav')

        // Fetch followed users every 30 seconds
		setTimeout(async () => {
			await fetch_user('sidenav')
		}, 30000)
	} catch (error) {
		sidenav_result.innerHTML = error
	}
})

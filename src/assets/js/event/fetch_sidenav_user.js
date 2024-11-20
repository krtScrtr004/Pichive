import { fetch_followed_user } from '../utils/fetch_sidenav_user.util.js'

document.addEventListener('DOMContentLoaded', async () => {
	const sidenav_result = document.querySelector('.sidenav-result')

	try {
        // Fetch followed users for the first time
		await fetch_followed_user()

        // Fetch followed users every 30 seconds
		setTimeout(async () => {
			await fetch_followed_user()
		}, 5000)
	} catch (error) {
		sidenav_result.innerHTML = error['message']
	}
})

import { send_data, test_response } from '../utils/request.js'

document.addEventListener('DOMContentLoaded', () => {
	const email = document.querySelector('#login_form>#email')
	const password = document.querySelector('#login_form>#password')
	const login_btn = document.querySelector('#login_form>#login_btn')
	const result = document.querySelector('#result')

	login_btn.onclick = async (e) => {
		e.preventDefault()
		// Send data to backend for authentication
		try {
			const response = await send_data('../api/login.php', {
				email: email.value,
				password: password.value,
			})

			// TODO: Change this if possible
			if (!response) {
				result.innerHTML = 'Data cannot be processed!'
				return
			} else if (response['status'] === 'fail') {
				// TODO: Handle fauilure
				if (response.hasOwnProperty('error')) {
					Object.values(response['error']).forEach((error) => {
						const paragraph = document.createElement('p')
						paragraph.textContent = error
						result.appendChild(paragraph)
					})
				} else {
					result.textContent = response['message']
				}
				return
			}

			// TODO: Display successfull message on modal
			result.innerHTML = response['message']
			window.location.href = '../views/home_explore.php?page=home'
		} catch (error) {
			result.innerHTML = error['message']
		}
	}
})

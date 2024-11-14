import { send_data } from '../utils/request.js'

document.addEventListener('DOMContentLoaded', () => {
	const username = document.querySelector('#signup_form>#username')
	const email = document.querySelector('#signup_form>#email')
	const password = document.querySelector('#signup_form>#password')
	const c_password = document.querySelector('#signup_form>#c_password')
	const signup_btn = document.querySelector('#signup_form>#signup_btn')

	const result = document.querySelector('#result')

	signup_btn.onclick = async (e) => {
		e.preventDefault()
		// Send data to backend for validation
		try {
			const response = await send_data('../api/signup.php', {
				username: username.value,
				email: email.value,
				password: password.value,
				c_password: c_password.value,
			})

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
					return
				}
			}

			// TODO: Handle success
			result.innerHTML = response['message']
		} catch (error) {
			result.innerHTML = error['message']
		}
	}
})

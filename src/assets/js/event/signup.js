import { sendData } from '../utils/request.js'

const username = document.querySelector('#signup>#signup_form>#username')
const email = document.querySelector('#signup>#signup_form>#email')
const password = document.querySelector('#signup>#signup_form>#password')
const c_password = document.querySelector('#signup>#signup_form>#c_password')
const signup_btn = document.querySelector('#signup>#signup_form>#signup_btn')

const result = document.querySelector('#result')

signup_btn.onclick = (e) => {
	e.preventDefault()
	// Send data to backend for validation
	sendData('../api/signup.php', {
		username: username.value,
		email: email.value,
		password: password.value,
		c_password: c_password.value,
	})
		.then((data) => {
			if (data === undefined) {
				result.innerHTML = 'Data cannot be processed!'
				return
			}

			if (data['status'] === 'fail') {
				// TODO: Handle fauilure
				if (data.hasOwnProperty('error')) {
					Object.values(data['error']).forEach((error) => {
						const paragraph = document.createElement('p')
						paragraph.textContent = error
						result.appendChild(paragraph)
					})
					return;
				}
			}

			// TODO: Handle success
			result.innerHTML = data['message']
		})
		.catch((error) => {
			// TODO: Display error on modal
			result.innerHTML = error['message']
		})
}

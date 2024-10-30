import { sendData } from './utils.js'

const username = document.querySelector('#signup>#signup_form>#username')
const email = document.querySelector('#signup>#signup_form>#email')
const password = document.querySelector('#signup>#signup_form>#password')
const c_password = document.querySelector('#signup>#signup_form>#c_password')
const signup_btn = document.querySelector('#signup>#signup_form>#signup_btn')

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
			// TODO: Display error on modal
			const result = document.querySelector('#result')
			if (data['status'] === 'fail') {
				if (data.hasOwnProperty('error')) {
					Object.values(data['error']).forEach((error) => {
						const paragraph = document.createElement('p')
						paragraph.textContent = error
						result.appendChild(paragraph)
					})
				}
			}
			result.innerHTML = data['message']
			// TODO: Display successfull message on modal
			// TODO: Redirect to home if successful
		})
		.catch((error) => {
			// TODO: Display error on modal
			document.querySelector('#result').innerHTML = error['message']
		})
}

import { send_data } from '../utils/request.js'

const email = document.querySelector('#login>#login_form>#email')
const password = document.querySelector('#login>#login_form>#password')
const login_btn = document.querySelector('#login>#login_form>#login_btn')
const result = document.querySelector('#result')

login_btn.onclick = async (e) => {
	e.preventDefault()
	// Send data to backend for authentication
	await send_data('../api/login.php', {
		email: email.value,
		password: password.value,
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
				}
				return;
			}

			// TODO: Display successfull message on modal
			result.innerHTML = data['message']
			window.location.href = '../views/homepage.php'
		})
		.catch((error) => {
			// TODO: Display error on modal
			result.innerHTML = data['message']
		})
}

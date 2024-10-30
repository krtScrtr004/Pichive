import { sendData } from './utils.js'

const email = document.querySelector('#login>#login_form>#email')
const password = document.querySelector('#login>#login_form>#password')
const login_btn = document.querySelector('#login>#login_form>#login_btn')
const result = document.querySelector('#result')

login_btn.onclick = (e) => {
	e.preventDefault()
	// Send data to backend for authentication
	sendData('../api/login.php', {
		email: email.value,
		password: password.value,
	})
		.then((data) => {
			// TODO: Display error on modal
			if (data['status'] === 'fail') {
				if (data.hasOwnProperty('error')) {
					Object.values(data['error']).forEach((error) => {
						const paragraph = document.createElement('p')
						paragraph.textContent = error
						result.appendChild(paragraph)
					})
				}
			} else {
                // TODO: Redirect here
                result.innerHTML = data['message']
            }
			// TODO: Display successfull message on modal
		})
		.catch((error) => {
			// TODO: Display error on modal
			result.innerHTML = data['message']
		})
}

import { sendData } from './utils'

const username = document.querySelector('#username')
const email = document.querySelector('#email')
const password = document.querySelector('#password')
const c_password = document.querySelector('#c_password')
const signup_btn = document.querySelector('#signup_btn')

signup_btn.onclick = function (e) {
	e.preventDefault()
	// Send data to backend for validation
	sendData('../../api/', {
		username: username.value,
		email: email.value,
		password: password.value,
		c_password: c_password.value,
	})
		.then((data) => {
			document.querySelector('#result').innerHTML = data['message']
		})
		.catch((error) => {
			document.querySelector('#result').innerHTML = error['message']
		})
}

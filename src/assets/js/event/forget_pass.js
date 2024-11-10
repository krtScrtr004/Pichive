import { send_data } from '../utils/request.js'

const result = document.querySelector('#result')

const email = document.querySelector(
	'#forget_password>#forget_password_form>#email'
)
const send_otp_btn = document.querySelector(
	'#forget_password>#forget_password_form>#send_otp_btn'
)
const otp = document.querySelector('#otp>#otp_form>#otp_code')
const reset_password_btn = document.querySelector(
	'#otp>#otp_form>#reset_password_btn'
)
const new_password = document.querySelector(
	'#change_password>#change_password_form>#new_password'
)
const c_password = document.querySelector(
	'#change_password>#change_password_form>#c_password'
)
const change_password_btn = document.querySelector(
	'#change_password>#change_password_form>#change_password_btn'
)
const resend_otp = document.querySelector('span>#resend_otp')

let response = null

send_otp_btn.onclick = async (e) => {
	e.preventDefault()
	// Authenticate email
	await send_data('../../api/forget_pass.php', {
		email: email.value,
	})
		.then((data) => {
			/*
                TODO:
                If success, hide forget password modal, then show eneter otp modal -> if success, hide enter otp modal;
                else, show error message on result box
            */
			if (!data) {
				result.innerHTML = 'Data cannot be processed!'
				return
			}

			if (data['status'] === 'fail') {
				// TODO: Handle fauilure
				result.innerHTML = data['message']
				return
			}

			result.innerHTML = data['message']
			response = data

			// TODO: Handle success
		})
		.catch((error) => {
			result.innerHTML = error['message']
		})
}

reset_password_btn.onclick = async (e) => {
	e.preventDefault()
	await send_data('../../api/authenticate_otp.php', {
		otp_code: otp.value,
		id: response['user']['id'],
	})
		.then((data) => {
			if (!data) {
				result.innerHTML = 'Data cannot be processed!'
				return
			}

			if (data['status'] === 'fail') {
				// TODO: Handle fauilure
				result.innerHTML = data['message']
				return
			}

			// TODO: Handle success
			result.innerHTML = data['message']
		})
		.catch((error) => {
			result.innerHTML = error['message']
		})
}

change_password_btn.onclick = async (e) => {
	e.preventDefault()
	await send_data('../../api/change_pass.php', {
		id: response['user']['id'],
		new_password: new_password.value,
		c_password: c_password.value,
	})
		.then((data) => {
			if (!data) {
				result.innerHTML = 'Data cannot be processed!'
				return
			}

			if (data['status'] === 'fail') {
				// TODO: Handle fauilure
				result.innerHTML = data['message']
				return
			}

			// TODO: Handle success
			result.innerHTML = data['message']
		})
		.catch((error) => {
			result.innerHTML = error['message']
		})
}

resend_otp.onclick = async (e) => {
	await send_data('../../api/resend_otp.php', {
		email: email.value,
	})
		.then((data) => {
			if (!data) {
				result.innerHTML = 'Data cannot be processed!'
				return
			}

			if (data['status'] === 'fail') {
				// TODO: Handle fauilure
				result.innerHTML = data['message']
				return
			}

			result.innerHTML = data['message']
			response = data

			// TODO: Handle success
		})
		.catch((error) => {
			result.innerHTML = error['message']
		})
}
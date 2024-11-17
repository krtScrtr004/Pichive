import { send_data, test_response } from '../utils/request.js'

document.addEventListener('DOMContentLoaded', () => {
	const result = document.querySelector('#result')

	const email = document.querySelector('#forget_password_form>#email')
	const send_otp_btn = document.querySelector(
		'#forget_password_form>#send_otp_btn'
	)
	const otp = document.querySelector('#otp_form>#otp_code')
	const reset_password_btn = document.querySelector(
		'#otp_form>#reset_password_btn'
	)
	const new_password = document.querySelector(
		'#change_password_form>#new_password'
	)
	const c_password = document.querySelector('#change_password_form>#c_password')
	const change_password_btn = document.querySelector(
		'#change_password_form>#change_password_btn'
	)
	const resend_otp = document.querySelector('#resend_otp')

	let data = null

	send_otp_btn.onclick = async (e) => {
		e.preventDefault()
		// Authenticate email
		try {
			const response = await send_data('../../api/forget_pass.php', {
				email: email.value,
			})
			const test = test_response(response)
			if (!test) {
				result.innerHTML = test['message']
				return
			}

			result.innerHTML = response['message']
			data = response
		} catch (error) {
			result.innerHTML = error['message']
		}

		/*
		TODO:
		If success, hide forget password modal, then show eneter otp modal -> if success, hide enter otp modal;
		else, show error message on result box
	*/
	}

	reset_password_btn.onclick = async (e) => {
		e.preventDefault()
		try {
			const response = await send_data('../../api/authenticate_otp.php', {
				otp_code: otp.value,
				id: response['user']['id'],
			})
			const test = test_response(response)
			if (!test) {
				result.innerHTML = test['message']
				return
			}

			// TODO: Handle success
			result.innerHTML = response['message']
		} catch (error) {
			result.innerHTML = error['message']
		}
	}

	change_password_btn.onclick = async (e) => {
		e.preventDefault()
		try {
			const response = await send_data('../../api/reset_pass.php', {
				id: response['user']['id'],
				new_password: new_password.value,
				c_password: c_password.value,
			})
			const test = test_response(response)
			if (!test) {
				result.innerHTML = test['message']
				return
			}

			result.innerHTML = data['message']
		} catch (error) {
			result.innerHTML = error['message']
		}
	}

	resend_otp.onclick = async (e) => {
		try {
			const response = await send_data('../../api/resend_otp.php', {
				email: email.value,
			})
			const test = test_response(response)
			if (!test) {
				result.innerHTML = test['message']
				return
			}

			result.innerHTML = response['message']
			data = response
		} catch (error) {
			result.innerHTML = error['message']
		}
	}
})

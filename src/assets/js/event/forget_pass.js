import { send_data, test_response } from '../utils/request.js'

document.addEventListener('DOMContentLoaded', () => {
	// Forget Password Modal Activator on Login Page
	const forget_password_link = document.querySelector('#forget_password_link')
	forget_password_link.onclick = async (e) => {
		e.preventDefault()

		const forget_password_modal = document.querySelector(
			'#forget_password_modal'
		)
		forget_password_modal.classList.add('show-modal')

		forget_password_modal.onclick = (e) => {
			if (e.target === forget_password_modal) {
				forget_password_modal.classList.remove('show-modal')
				document.querySelector('#forget_password_form').reset()
			}
		}
	}

	let data = null
	const result = document.querySelector('#result')

	// Send OTP
	const email = document.querySelector('#forget_password_form>#email')
	const send_otp_btn = document.querySelector('#send_otp_btn')
	send_otp_btn.onclick = async (e) => {
		e.preventDefault()

		// Authenticate email
		try {
			const response = await send_data('../api/forget_pass.php', {
				email: email.value,
			})
			const test = test_response(response)
			if (!test) {
				throw new Error(test['message'])
			}

			data = response
			document
				.querySelector('#forget_password_modal')
				.classList.remove('show-modal')
			document.querySelector('#forget_password_form').reset()

			const otp_modal = document.querySelector('#otp_modal')
			otp_modal.classList.add('show-modal')

			otp_modal.onclick = (e) => {
				if (e.target === otp_modal) {
					otp_modal.classList.remove('show-modal')
					document.querySelector('#otp_form').reset()
				}
			}
		} catch (error) {
			result.innerHTML = error
		}
	}

	// Authenticate OTP
	const otp = document.querySelector('#otp_form>#otp_code')
	const reset_password_btn = document.querySelector('#reset_password_btn')
	reset_password_btn.onclick = async (e) => {
		e.preventDefault()

		try {
			const response = await send_data('../api/authenticate_otp.php', {
				otp_code: otp.value,
				id: data['user']['id'],
			})
			const test = test_response(response)
			if (!test) {
				throw new Error(test['message'])
			}

			document.querySelector('#otp_modal').classList.remove('show-modal')
			document.querySelector('#otp_form').reset()

			const change_password_modal = document.querySelector(
				'#change_password_modal'
			)
			change_password_modal.classList.add('show-modal')

			change_password_modal.onclick = (e) => {
				if (e.target === change_password_modal) {
					change_password_modal.classList.remove('show-modal')
					document.querySelector('#change_password_form').reset()
				}
			}
		} catch (error) {
			result.innerHTML = error
		}
	}

	// Reset Pssword
	const new_password = document.querySelector(
		'#change_password_form>#new_password'
	)
	const c_password = document.querySelector('#change_password_form>#c_password')
	const change_password_btn = document.querySelector(
		'#change_password_form>#change_password_btn'
	)
	const resend_otp = document.querySelector('#resend_otp')
	change_password_btn.onclick = async (e) => {
		e.preventDefault()
		try {
			const response = await send_data('../api/reset_pass.php', {
				id: data['user']['id'],
				new_password: new_password.value,
				c_password: c_password.value,
				otp_code: data['otp_code'],
			})
			const test = test_response(response)
			if (!test) {
				throw new Error(test['message'])
			}

			document.querySelector('#change_password_form').reset()
		} catch (error) {
			result.innerHTML = error
		}
	}

	// Resend OTP
	resend_otp.onclick = async (e) => {
		try {
			const response = await send_data('../api/resend_otp.php', {
				email: data['user']['email'],
			})
			const test = test_response(response)
			if (!test) {
				throw new Error(test['message'])
			}

			data = response

			const change_password_modal = document.querySelector('#change_password_modal')
			change_password_modal.classList.remove('show-modal')
		} catch (error) {
			result.innerHTML = error
		}
	}

	const close_btn = document.querySelectorAll('.close-btn')
	close_btn.forEach((btn) => {
		btn.onclick = () => {
			btn.closest('.modal-wrapper').classList.remove('show-modal')
		}
	})
})

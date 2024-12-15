import { send_data } from '../utils/request.js'
import { form_reset } from '../utils/utils.js'

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
				throw new Error('Data cannot be processed!')
			} else if (response['status'] === 'fail') {
				// TODO: Handle fauilure
				if (response.hasOwnProperty('error')) {
					// Create an array of error messages
					const errorMessages = Object.values(response['error']);
					
					// Combine all error messages into a single string
					const alertMessage = errorMessages.join('\n');
					
					// Display the errors in an alert
					alert(alertMessage);
				
					// Optionally, display the errors on the page as well
					errorMessages.forEach((error) => {
						const paragraph = document.createElement('p');
						paragraph.textContent = error;
						result.appendChild(paragraph);
					});
				
					form_reset(document.querySelector('#signup_form'));
					return;
				}
				
			}

			// TODO: Handle success
			alert(response['message'])
			window.location.href = '../views/home_explore.php?page=home'
		} catch (error) {
			alert(error.message)
			console.error(error.message)
		}
	}
})

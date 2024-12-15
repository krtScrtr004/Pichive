import { send_data, test_response } from '../utils/request.js'
import { form_reset } from '../utils/utils.js'

document.addEventListener('DOMContentLoaded', () => {
	const email = document.querySelector('#login_form>#email')
	const password = document.querySelector('#login_form>#password')
	const login_btn = document.querySelector('#login_form>#login_btn')
	const result = document.querySelector('#result')

	login_btn.onclick = async (e) => {
		e.preventDefault()
		// Send data to backend for authentication
		try {
			const response = await send_data('../api/login.php', {
				email: email.value,
				password: password.value,
			})

			if (!response) {
				throw new Error('Data cannot be processed!');
			} else if (response['status'] === 'fail') {
				// Handle failure
				if (response.hasOwnProperty('error')) {
					// Collect error messages
					const error_msg = Object.values(response['error']);
					
					// Combine all error messages into a single string
					const alert_msg = error_msg.join('\n');
					
					// Display the errors in an alert box
					alert(alert_msg);
					
					// Optionally display errors on the page
					error_msg.forEach((error) => {
						const paragraph = document.createElement('p');
						paragraph.textContent = error;
						result.appendChild(paragraph);
					});
				} else {
					// Alert and display the failure message
					alert(response['message']);
					result.textContent = response['message'];
				}
			
				// Reset the form
				form_reset(document.querySelector('#login_form'));
				return;
			}			

			alert(response['message'])
			window.location.href = '../views/home_explore.php?page=home'
		} catch (error) {
			alert(error.message)
			console.error(error.message)
		}
	}
})

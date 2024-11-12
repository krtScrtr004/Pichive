// HTTP Operation Functions

export async function send_data(URL, OBJ) {
	try {
		const response = await fetch(URL, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify(OBJ),
		})
		if (response.status !== 200) {
			throw new Error(`Response Error: ${data.message}`)
		}

		const data = await response.json()
		return data
	} catch (error) {
		throw new Error(`Network Error: ${error}`)
	}
}

export async function send_file(URL, OBJ) {
	try {
		const response = await fetch(URL, {
			method: 'POST',
			body: OBJ,
		})
		if (response.status !== 200) {
			throw new Error(`Response Error: ${data.message}`)
		}

		const data = await response.json()
		return data
	} catch (error) {
		throw new Error(`Network Error: ${error}`)
	}
}

export async function get_data(URL) {
	try {
		const response = await fetch(URL)
		if (response.status !== 200) {
			throw new Error(`HTTP error! status: ${response.status}`)
		}

		const data = await response.json()
		return data
	} catch (error) {
		throw new Error(`Network Error: ${error}`)
	}
}

export function test_response(response) {
	if (!response) {
		return {
			status: false,
			message: 'No response was sent back to the request!',
		}
	} else if (response['status'] === 'fail') {
		return {
			status: false,
			message: response['message'],
		}
	}

	return {
		status: true,
		data: response['message'],
	}
}

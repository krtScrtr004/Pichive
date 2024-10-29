export async function sendData(URL, OBJ) {
	try {
		const response = await fetch(URL, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify(OBJ),
		})

		if (response.statusCode !== 200) {
			const error = await response.json()
			console.error(`Response Error: ${error.message}`)
			return error
		}
	} catch (e) {
		console.error(`Network Error: ${e}`)
	}
}

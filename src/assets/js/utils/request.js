// HTTP Operation Functions

export async function sendData(URL, OBJ) {
	try {
		const response = await fetch(URL, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify(OBJ),
		})

		const data = await response.json()
		if (response.status !== 200) {
			console.error(`Response Error: ${data.message}`)
		}
		return data
	} catch (e) {
		console.error(`Network Error: ${e}`)
	}
}

export async function send_file(URL, OBJ) {
	try {
		const response = await fetch(URL, {
			method: 'POST',
			body: OBJ,
		})

		const data = await response.json()
		if (response.status !== 200) {
			console.error(`Response Error: ${data.message}`)
		}
		return data
	} catch (e) {
		console.error(`Network Error: ${e}`)
	}
}


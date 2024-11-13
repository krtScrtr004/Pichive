import { send_file, test_response } from '../utils/request.js'

const form = document.querySelector('#create_post_modal')
const result_box = document.querySelector('.result_box')
const title = document.querySelector('#title')
const image_picker = document.querySelector('#file_picker')
const image_preview = document.querySelector('.img_preview')
const description = document.querySelector('#description')
const post_btn = document.querySelector('#post_btn')
const cancel_btn = document.querySelector('#cancel_btn')

// Dynamically change image preiew when user select another image
image_picker.onchange = () => {
	if (image_picker.files && image_picker.files[0]) {
		image_preview.src = URL.createObjectURL(image_picker.files[0])
	}
}

// FIXME
post_btn.onclick = async (e) => {
	e.preventDefault()
	const image = image_picker.files[0]
	if (!image) {
		result_box.innerHTML = 'Image not found!'
		return
	}

	const form_data = new FormData()
	form_data.append('title', title.value)
	form_data.append('image', image)
	form_data.append('description', description.value)

	try {
		const response = await send_file('../api/upload_image.php', form_data)
		const test = test_response(response)
		if (!test) {
			result_box.innerHTML = test['message']
			return
		}

		setTimeout(() => {
			result_box.innerHTML = response['message']
			title.value = ''
			image_preview.src = ''
			description.value = ''
			image_picker.value = ''
		}, '1000')
		result_box.innerHTML = ''
		location.reload()
	} catch(error) {
		result_box.innerHTML = error['message']
	}
}

cancel_btn.onclick = () => {
	form.hidePopover()
	// window.location.href = '../views/homepage.php'
}

import { send_file, test_response } from '../utils/request.js'

document.addEventListener('DOMContentLoaded', () => {
	const form = document.querySelector('#create_post_modal')
	const result_box = document.querySelector('.result_box')
	const title = document.querySelector('#title')
	const image_picker = document.querySelector('#file_picker')
	const image_preview = document.querySelector('.img-preview')
	const description = document.querySelector('#description')
	const post_btn = document.querySelector('#post_btn')
	const upload_img_btn = document.querySelector('#upload_img_btn')
	const cancel_btn = document.querySelector('#create_post_modal #cancel_btn')

	// Dynamically change image preiew when user select another image
	image_picker.onchange = () => {
		if (image_picker.files && image_picker.files[0]) {
			image_preview.src = URL.createObjectURL(image_picker.files[0])
		}
	}

	// For Profile page
	if (upload_img_btn) {
		upload_img_btn.onclick = () => {
			form.showPopover()
		}
	}

	post_btn.onclick = async (e) => {
		e.preventDefault()

		try {
			const image = image_picker.files[0]
			if (!image) {
				throw new Error('Image not found!')
			}

			const form_data = new FormData()
			form_data.append('title', title.value)
			form_data.append('image', image)
			form_data.append('description', description.value)

			const response = await send_file('../api/upload_image.php', form_data)
			const test = test_response(response)
			if (!test) {
				throw new Error(test['message'])
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
		} catch (error) {
			result_box.innerHTML = error
		}
	}

	cancel_btn.onclick = () => {
		form.hidePopover()
		// window.location.href = '../views/homepage.php'
	}
})

import { send_file, test_response } from '../utils/request.js'
import { form_reset } from '../utils/utils.js'

document.addEventListener('DOMContentLoaded', () => {
	const create_post_btn = document.querySelectorAll('#create_post_btn')
	const create_post_modal = document.querySelector('#create_post_modal')
	const create_post_form = document.querySelector('#create_post_form')

	create_post_btn.forEach((btn) => {
		btn.onclick = (e) => {
			e.preventDefault()
			create_post_modal.classList.add('show-modal')
		}
	})

	create_post_modal.onclick = (e) => {
		if (e.target === create_post_modal) {
			create_post_modal.classList.remove('show-modal')
			form_reset(create_post_form)
		}
	}

	// Create post form event

	// const result_box = document.querySelector('.result_box')

	// Dynamically change image preiew when user select another image
	const image_picker = document.querySelector('#file_picker')

	const image_preview = document.querySelector('#img_preview')
	image_picker.onchange = () => {
		if (image_picker.files && image_picker.files[0]) {
			image_preview.src = URL.createObjectURL(image_picker.files[0])
		}
	}

	// For Profile page
	const upload_img_btn = document.querySelector('#upload_img_btn')
	if (upload_img_btn) {
		upload_img_btn.onclick = () => {
			create_post_form.classList.add('show-modal')
		}
	}

	const post_btn = document.querySelector('#post_btn')
	const cancel_btn = document.querySelector('#create_post_modal #cancel_btn')

	post_btn.onclick = async (e) => {
		e.preventDefault()
		const title = document.querySelector('#title')
		const description = document.querySelector('#description')

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

			form_reset(create_post_form)
			create_post_modal.classList.remove('show-modal')
		} catch (error) {
			alert(error.message)
			console.error(error.message)
			create_post_form.reset()
		}
	}

	cancel_btn.onclick = (e) => {
		e.preventDefault()
		create_post_modal.classList.remove('show-modal')
		form_reset(create_post_form)
	}
})

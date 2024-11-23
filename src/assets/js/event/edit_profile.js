import { send_file, test_response } from '../utils/request.js'

document.addEventListener('DOMContentLoaded', async () => {
	const result = document.querySelector('.result')

	const edit_profile_modal = document.querySelector('#edit_profile_modal')
	const edit_profile_btn = document.querySelector('#edit_profile_btn')

	const img_preview = document.querySelector('.img-preview.circle')
	const img_picker_btn = document.querySelector('#img_picker_btn')
	const img_picker = document.querySelector('#img_picker')

	const save_btn = document.querySelector('#edit_profile_modal  #save_btn')
	const cancel_btn = document.querySelector('#edit_profile_modal #cancel_btn')

	if (edit_profile_btn) {
		edit_profile_btn.onclick = (e) => {
			e.preventDefault()
			edit_profile_modal.classList.add('show-modal')
		}
	}

	edit_profile_modal.onclick = (e) => {
		if (e.target === edit_profile_modal) {
			edit_profile_modal.classList.remove('show-modal')
		}
	}

	// Use button element to toggle file pick
	img_picker_btn.onclick = () => {
		img_picker.click()
	}

	img_picker.onchange = () => {
		if (img_picker.files && img_picker.files[0]) {
			img_preview.src = URL.createObjectURL(img_picker.files[0])
		}
	}

	save_btn.onclick = async (e) => {
		e.preventDefault()

		const username = document.querySelector('#edit_profile_form #username')
		const password = document.querySelector('#edit_profile_form #password')
		const bio = document.querySelector('#edit_profile_form #bio')
		const img = img_picker.files[0]

		const form_data = new FormData()
		if (username.value !== '') form_data.append('username', username.value)
		if (password.value !== '') form_data.append('password', password.value)
		if (bio.value !== '') form_data.append('bio', bio.value)
		if (img) form_data.append('profile_img', img)

		try {
			const response = await send_file('../api/edit_profile.php', form_data)
			const test = test_response(response)
			if (!test['status']) {
				throw new Error(test['message'])
			}

			img_preview.src = ''
			username.value = ''
			password.value = ''
			bio.value = ''
			result.innerHTML = ''
			location.reload()
		} catch (error) {
			result.innerHTML = error
		}
	}

	cancel_btn.onclick = () => {
		edit_profile_modal.classList.remove('show-modal')
	}
})

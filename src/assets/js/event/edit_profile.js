import { send_file, test_response } from '../utils/request.js'

document.addEventListener('DOMContentLoaded', async () => {
	const edit_profile_modal = document.querySelector('#edit_profile_modal')
	const edit_profile_btn = document.querySelector('#edit_profile_btn')

	const img_preview = document.querySelector('.img-preview.circle')
	const img_picker_btn = document.querySelector('#img_picker_btn')
	const img_picker = document.querySelector('#img_picker')

    const save_btn = document.querySelector('#edit_profile_modal  #save_btn')
    const cancel_btn = document.querySelector('#edit_profile_modal #cancel_btn')

	edit_profile_btn.onclick = (e) => {
		e.preventDefault()
		edit_profile_modal.classList.add('show-modal')
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
        const response = await send_file('../api/edit_profile.php', {

        })
        const test = test_response(response)
        // if (!test['status'])
    }

    cancel_btn.onclick = () => {
        edit_profile_modal.classList.remove('show-modal')
    }
})

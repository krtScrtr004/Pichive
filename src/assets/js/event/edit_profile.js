import { send_data, test_response } from '../utils/request.js'

const edit_profile_modal = document.querySelector('#edit_profile_modal')
const edit_profile_btn = document.querySelector('#edit_profile_btn')

const img_preview = document.querySelector('.img_preview.circle')
const img_picker = document.querySelector('#img_picker')


edit_profile_btn.onclick = (e) => {
	e.preventDefault()
	edit_profile_modal.classList.add('show-modal')
}

edit_profile_modal.onclick = (e) => {
    if (e.target === edit_profile_modal) {
        edit_profile_modal.classList.remove('show-modal')
    }
}

img_picker.onchange = () => {
    if (img_picker.files && img_picker.files[0]) {
        img_preview.src = URL.createObjectURL(img_preview.files[0])
    }
}
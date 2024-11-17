import { get_data, test_response } from '../utils/request.js'

document.addEventListener('DOMContentLoaded', async () => {
    const result_box = document.querySelector('.result-box');
    const profile_details = document.querySelector('.profile-details');

    const profile_img = document.querySelector('#profile_img');
    const username =  document.querySelector('.user-info #username');
    const user_id = document.querySelector('.user-info #user_id');
    const user_bio = document.querySelector('#user_bio');

    try {
        const response  = await get_data(`../api/fetch_user.php?id=${profile_details.getAttribute('data-id')}`);

        const test = test_response(response)
        if (!test) {
			result_box.innerHTML = test['message']
			return
		}

        profile_img.src = response['data']['img_url'] ?? '../assets/img/default_img_prev.png'
        username.textContent = response['data']['username']
        user_id.textContent = response['data']['id'] ?? '00000'
        user_bio.textContent = response['data']['bio'] ?? 'No bio available'
    } catch (error) {
        result_box.innerHTML = error['message']
    }
})
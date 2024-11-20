import { get_data, test_response } from '../utils/request.js'

document.addEventListener('DOMContentLoaded', async () => {
    const result_box = document.querySelector('.result-box');
    const profile_details = document.querySelector('.profile-details');

    const profile_img = document.querySelector('#profile_img');
    const username =  document.querySelector('.user-info #username');
    const user_id = document.querySelector('.user-info #user_id');
    const user_bio = document.querySelector('#user_bio');

    const follow_user_btn = document.querySelector('#follow_user_btn')
    const block_user_btn = document.querySelector('#block_user_btn')

    try {
        const response  = await get_data(`../api/fetch_user.php?id=${profile_details.getAttribute('data-id')}`);
        const test = test_response(response)
        if (!test) {
			result_box.innerHTML = test['message']
			return
		}

        const data = response['data'][0]

        profile_img.src = data['profile_url'] ?? '../assets/img/default_img_prev.png'
        username.textContent = data['username']
        user_id.textContent = data['id'] ?? '00000'
        user_bio.textContent = data['bio'] ?? 'No bio available'

        const body = document.querySelector('body')
        if (follow_user_btn) {
            if (data['is_followed'] === '1') {
                follow_user_btn.innerHTML = 'Unfollow'
                body.setAttribute('data-followed', 1)
            } else {
                follow_user_btn.innerHTML = 'Follow'
                body.setAttribute('data-followed', 0)
            }
        }
        if (block_user_btn) {
            if (data['is_blocked'] === '1') {
                block_user_btn.innerHTML = 'Unblock'
                body.setAttribute('data-blocked', 1)
            } else {
                block_user_btn.innerHTML = 'Block'
                body.setAttribute('data-blocked', 0)
            }
        }
    } catch (error) {
        result_box.innerHTML = error['message']
    }
})
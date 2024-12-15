import { load_posts, offset } from './fetch_post.js'

const tabs = document.querySelectorAll('.post-tabs>form>button')
const result_box = document.querySelector('.post-result-box')

function remove_active_tab() {
    const active_tab = document.querySelector('.content.active')
    if (active_tab) {
        active_tab.remove()
    }
}

async function load_own_posts() {
    offset['current_count'] = 0
    remove_active_tab()

    const profile_posts = document.querySelector('.profile-posts')
    const img_grid_HTML = `<div class="content active img-grid" data-content="profile" data-id="${document
        .querySelector('body')
        .getAttribute('data-id')}"></div>`

    profile_posts.insertAdjacentHTML('beforeend', img_grid_HTML)

    try {
        await load_posts()
    } catch (error) {
        console.error('Error loading posts:', error)
        result_box.innerHTML = error
    }
}

async function load_liked_posts() {
    offset['current_count'] = 0
    remove_active_tab()

    const profile_posts = document.querySelector('.profile-posts')
    const img_grid_HTML = `<div class="content active img-grid" data-content="like"></div>`

    profile_posts.insertAdjacentHTML('beforeend', img_grid_HTML)
    try {
        await load_posts()
    } catch (error) {
        console.error('Error loading posts:', error)
        result_box.innerHTML = error
    }
}

if (tabs.length > 0) {
	own_post_tab.onclick = async () => {
        await load_own_posts()
	}

	liked_post_tab.onclick = async () => {
       await load_liked_posts()
	}
}

await load_own_posts()




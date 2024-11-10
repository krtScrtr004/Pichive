import { get_data } from '../utils/request.js'

const img_grid = document.querySelector('.img_grid')
const result_box = document.querySelector('#result-box')
const modal_wrapper = document.querySelector('.modal_wrapper')

let offset = 0
const limit = 9
let is_loading = false // Flag to prevent multiple calls

export function handle_scroll() {
    if (
        window.innerHeight + window.scrollY >=
        document.body.offsetHeight - 100
    ) {
        load_posts()
    }
}

export async function load_posts() {
    if (is_loading) {
        return
    }
    is_loading = true

    const loading = document.querySelector('#loading')
    loading.style.display = 'block'

    let response = await get_data(`../api/fetch_img.php?offset=${offset}&limit=${limit}`)
    if (!response) {
        result_box.innerHTML = 'Failed to fetch posts data!'
        window.removeEventListener('scroll', handle_scroll)
        loading.style.display = 'none'
        is_loading = false
        return
    } else if (response['status'] === 'fail') {
        result_box.innerHTML = response['message']
        window.removeEventListener('scroll', handle_scroll)
        loading.style.display = 'none'
        is_loading = false
        return
    }

    const data = response['data']
    if (data.length === 0) {
        window.removeEventListener('scroll', handle_scroll)
        loading.style.display = 'none'
        is_loading = false
        return
    }

    // Iterate over each post and create image elements
    data.forEach((post) => {
        const img = document.createElement('img')
        img.src = post['img_url']
        img.loading = 'lazy'
        img.setAttribute('data-id', post['id'])
        // TODO: Add more attributes to display here

        const new_img_cont = document.createElement('div')
        new_img_cont.classList.add('img_cont')
        new_img_cont.appendChild(img)
        new_img_cont.onclick = () => {
            modal_wrapper.classList.add('show_modal')
            if (!fetch_post_details(img.getAttribute('data-id'))) {
                modal_wrapper.classList.remove('show_modal')					
            }
        }

        img_grid.appendChild(new_img_cont)
    })

    // Update offset for the next batch of data
    offset += limit
    loading.style.display = 'none'
    is_loading = false // Reset loading flag
}

export async function fetch_post_details(id) {
    const response = await get_data(`../api/fetch_img_detail.php?id=${id}`)
    if (!response) {
        result_box.innerHTML = 'Failed to fetch post details!'
        return null
    } else if (response['status'] === 'fail') {
        result_box.innerHTML = response['message']
        return null
    }

    const data = response['data']
    if (data.length === 0) {
        result_box.innerHTML = response['message']
        return null
    }

    document.querySelector('#img_view>img').src = data['img_url']
    document.querySelector('#post_detail>#poster_name').textContent = data['poster_name']
    document.querySelector('#post_detail>#poster_id').textContent = data['poster_id']
    document.querySelector('#post_detail>#title').textContent = data['title']
    document.querySelector('#post_detail>#description').textContent = data['description']
    document.querySelector('#post_detail>#date').textContent = data['date']
}
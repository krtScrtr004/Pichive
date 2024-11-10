import { get_data } from '../utils/request.js'

const wrapper = document.querySelector('.wrapper')
const result_box = document.querySelector('#result-box')

document.addEventListener('DOMContentLoaded', () => {
	let offset = 0
	const limit = 10

    function handle_scroll() {
		if (
			window.innerHeight + window.scrollY >=
			document.body.offsetHeight - 100
		) {
			loadPosts()
		}
	}

	async function loadPosts() {
		// window.location.href = `../api/fetch_img.php?offset=${offset}`
		const loading = document.querySelector('#loading')

		loading.style.display = 'block'

		let response = await get_data(`../api/fetch_img.php?offset=${offset}`)
		if (!response) {
			result_box.innerHTML = 'Failed to fetch data'
			window.removeEventListener('scroll', handle_scroll)
            loading.style.display = 'none'
            return  
		} else if (response['status'] === 'fail') {
			result_box.innerHTML = response['message']
			window.removeEventListener('scroll', handle_scroll)
			loading.style.display = 'none'
			return
		}

		const data = response['data']
		if (data.length === 0) {
			window.removeEventListener('scroll', handle_scroll)
			loading.style.display = 'none'
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

			wrapper.appendChild(new_img_cont)
		})

		// Update offset for the next batch of data
		offset += limit
		loading.style.display = 'none'
	}

	// Add scroll event listener
	window.addEventListener('scroll', handle_scroll)
	loadPosts()
})

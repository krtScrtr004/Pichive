import { fetch_user } from '../utils/fetch_user_list.util.js'

const search_input = document.querySelector('#search_input')
const search_btn = document.querySelector('#search_btn')

search_btn.onclick = (e) => {
	e.preventDefault()

	const search_term = search_input.value
	// Redirect to the search results page with the search term as a query parameter
	location.replace(`search_result.php?term=${encodeURIComponent(search_term)}`)
}

const query_params = window.location.search
const params = new URLSearchParams(query_params)
const search_term = params.get('term')
if (search_term) {
	search_input.value = search_term
	try {
		await fetch_user('search')
	} catch (error) { 
		console.error(error)
	}

	document.querySelector('.center').addEventListener('scroll', handle_scroll)

	async function handle_scroll() {
		if (
			window.innerHeight + window.scrollY >=
			document.body.offsetHeight - 100
		) {
			await fetch_user('search')
		}
	}
}

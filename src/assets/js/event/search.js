import { get_data, test_response } from '../utils/request.js'
import { add_post_details } from '../utils/fetch_post.util.js'
import { remove_comment, has_already_ran } from '../utils/comment.util.js'
import { remove_details } from '../utils/fetch_post.util.js'

const search_input = document.querySelector('#search_input')
const search_btn = document.querySelector('#search_btn');

search_btn.onclick = (e) => {
    e.preventDefault(); 

    const search_term = search_input.value;
    // Redirect to the search results page with the search term as a query parameter
    location.replace(`search_result.php?term=${encodeURIComponent(search_term)}`);
};

const query_params = window.location.search
const params = new URLSearchParams(query_params)
const search_term = params.get('term')
if (search_term) {
    search_input.value = search_term
}

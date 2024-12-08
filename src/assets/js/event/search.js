const search_btn = document.querySelector('#search_btn');

search_btn.onclick = (e) => {
    e.preventDefault();
    location.replace('search_result.php')
}
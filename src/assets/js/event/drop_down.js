import { get_data } from '../utils/request.js'

document.addEventListener("DOMContentLoaded", () => {
    document.querySelector("#logout").onclick = (e) => {
        e.stopPropagation()

        alert('You are now logged out')
        get_data('../api/logout.php')
    }
})
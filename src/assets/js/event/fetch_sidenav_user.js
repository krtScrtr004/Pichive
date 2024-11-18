import { get_data, test_response } from '../utils/request.js'

document.addEventListener('DOMContentLoaded', async () => {
    const response = await get_data('')
    const data = await response.json()
})
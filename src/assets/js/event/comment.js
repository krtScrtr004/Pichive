import { send_data } from '../utils/request.js'
import { display_comment } from '../utils/comment.util.js'

const result = document.querySelector('.result')
const img_source = document.querySelector('#img_view>img')
const input_comment = document.querySelector('#input_comment')
const submit_comment_btn = document.querySelector('#submit_comment_btn')

console.log(img_source)

submit_comment_btn.onclick = async (e) => {
    e.preventDefault()
    await send_data('../api/write_comment.php', {
        post_id : img_source.getAttribute('data-id'),
        comment : input_comment.value
    })
    .then((data) => {
        if (!data) {
            result_box.innerHTML =
                'Response was not successfully recieved while adding comment!'
            return
        }

        if (data['status'] === 'fail') {
            result_box.innerHTML = data['message']
            return
        }

        result.innserHTML = data['message']
        display_comment({
            img_url : data['data']['img_url'],
            commenter_name :  data['data']['commenter_name'],
            comment_content : input_comment.value,
            comment_date : data['data']['comment_date'],
        })
    })
    .catch((error) => {
        result.innserHTML = error['message']
    })
}
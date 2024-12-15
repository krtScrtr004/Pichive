export function form_reset(form) {
	form.reset()

	const imgs = form.querySelectorAll(form > 'img')
	imgs.forEach((img) => {
        img.src = '../assets/img/default_img_prev.png'
    })
}
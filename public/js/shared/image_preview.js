$('.image-preview-input[type="file"][accept="image/*"]').on('change', function () {
  readURL(this);
});

function readURL(input) {
  if (input.files && input.files[0]) {
    let target = input.dataset.target;
    let reader = new FileReader();
    reader.onload = function (e) {
        $(`${target}`).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
    console.log(reader);
  }
}

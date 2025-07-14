function modalDeleteVideoCourse(video_course_id) {
  if(isValidVariable(video_course_id)) {
      let classroom_name = $(`table tbody tr[data-id-video-course="${video_course_id}"]`).find('.name').text();
      $('#delete_video_course_modal_item').text(`o curso ${classroom_name}?`);
      $('#video_course_to_delete').val(video_course_id);
      $('#delete_video_course_modal').modal('show');
  }
}

function deleteVideoCourseConfirmed() {
  let video_course_id = $('#video_course_to_delete').val();

  if (isValidVariable(video_course_id)) {
      $.ajax({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          url: `/video-courses/${video_course_id}`,
          type: 'DELETE',
          success: function (response) {
              $(`table tbody tr[data-id-video-course="${video_course_id}"]`).remove();
              $('#delete_video_course_modal').modal('hide');

              notify(response.msg, response.icon);
          },
          error: function (error) {
              console.log(error);
              let data = error.responseJSON;
              notify(data.msg, data.icon);
              closeAllModals();
          }
      });
      $('#video_course_to_delete').val('');
  }
}

$(document).ready(function() {
    // Load recent video courses owlCarousel
    $('.video-course-list').owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        dots:true,
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            700: {items: 3},
            1200: { items: 4 },
            1500: { items: 5 }
        }
    });
});
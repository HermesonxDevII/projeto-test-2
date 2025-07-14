const { default: Echo } = require('laravel-echo');

require('./bootstrap');

// window.Vue = require('vue').default;
window.Datatables = require('datatables.net');
window.Select2 = require('select2');
window.owlCarousel = require('owl.carousel');
window.Swal = require('sweetalert2');

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// const app = new Vue({
//     el: '#app',
//     created() {
//         Echo.Channel('course-start')
//             .listen('CourseStartNotification', (e) => {
//                 alert('testing')
//             });
//     }
// });

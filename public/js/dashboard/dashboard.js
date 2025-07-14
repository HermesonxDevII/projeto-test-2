$(window).on('beforeunload', function() {
    $(window).scrollTop(0);
});

$(document).ready(function() {
    // Navbar animations
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#kt_header').addClass('navbar-scrolled-bg');
        }
        if ($(this).scrollTop() < 50) {
            $('#kt_header').removeClass('navbar-scrolled-bg');
        }
    });

    // Default global datatables
    let table = new Datatables('.default-datatable', {
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
        },
        paging: true,
        // autoWidth: false,
        ordering: true,
        info: false,
        searching: true,
        lenghtChange: false,
        lengthMenu: false,
        bLengthChange: false,
    });

    let tablevideocourseStudents = new Datatables('#video_course_students', {
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
        },
        paging: true,
        // autoWidth: false,
        ordering: true,
        info: false,
        searching: true,
        lenghtChange: false,
        lengthMenu: false,
        bLengthChange: false,
        order: [],
        columnDefs: [
            {
                targets: [0, 1, 2, 3],   // Especifica as colunas que você deseja que sejam ordenáveis
                orderable: true          // Habilita a ordenação nestas colunas
            }
        ]
    });

    let tableclassroomStudents = new Datatables('#classroom_students', {
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
        },
        paging: true,
        // autoWidth: false,
        ordering: true,
        info: false,
        searching: true,
        lenghtChange: false,
        lengthMenu: false,
        bLengthChange: false,
        columnDefs: [
            {
                targets: 0, // Índice da coluna de Data da Aula
                orderable: true,
                render: function(data, type, row) {
                    if (type === "sort" || type === "type") {                        
                        let parts = data.split('/');
                        return parts[2] + parts[1] + parts[0]; 
                    }
                    return data;
                }
            }
        ],
        order: [[0, 'desc']]
    });

    let studentsTable = new Datatables('#students-datatable', {
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
        },
        paging: true,
        // autoWidth: false,
        info: false,
        searching: true,
        lenghtChange: false,
        lengthMenu: false,
        bLengthChange: false,
        columnDefs: [
            { orderable: false, targets: 0 },  // Desabilita a ordenação na primeira coluna (checkboxes)
            { orderable: true, targets: 1 },   // Habilita a ordenação na segunda coluna (Nome)
            { orderable: true, targets: 2 },   // Habilita a ordenação na terceira coluna (Turmas)
            { orderable: true, targets: 3 },   // Habilita a ordenação na quarta coluna (Série)
            { orderable: true, targets: 4 },   // Habilita a ordenação na quinta coluna (Status)
            { orderable: false, targets: 5 }   // Desabilita a ordenação na sexta coluna (Opções)
        ],
        order: [[1, 'asc']]
    });

    let tableclassroomEvaluations = new Datatables('#classroom_evaluations', {
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
        },
        paging: true,
        // autoWidth: false,
        ordering: true,
        info: false,
        searching: true,
        lenghtChange: false,
        lengthMenu: false,
        bLengthChange: false,
        columnDefs: [
            {
                targets: 0, // Índice da coluna de Data da Aula
                orderable: true,
                render: function(data, type, row) {
                    if (type === "sort" || type === "type") {                        
                        let parts = data.split('/');
                        return parts[2] + parts[1] + parts[0]; 
                    }
                    return data;
                }
            }
        ],
        order: [[0, 'desc']] 
    });

    let tableStudentClassrooms = new Datatables('#table-student-classrooms', {
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
        },
        paging: true,
        // autoWidth: false,
        ordering: true,
        info: false,
        searching: true,
        lenghtChange: false,
        lengthMenu: false,
        bLengthChange: false,
        columnDefs: [
            {
                targets: 0, // Índice da coluna de Data da Aula
                orderable: true,
                render: function(data, type, row) {
                    if (type === "sort" || type === "type") {                        
                        let parts = data.split('/');
                        return parts[2] + parts[1] + parts[0]; 
                    }
                    return data;
                }
            }
        ],
        order: [[0, 'desc']]
    });

    $('#search_datatable').keyup(function() {
        table.search($(this).val()).draw();
        studentsTable.search($(this).val()).draw();
        tablevideocourseStudents.search($(this).val()).draw();
        tableclassroomStudents.search($(this).val()).draw();
        tableclassroomEvaluations.search($(this).val()).draw();
        tableStudentClassrooms.search($(this).val()).draw();
    });

    // Load recent courses owlCarousel
    $('.course-list').owlCarousel({
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

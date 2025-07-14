// =======================
// UTILITÁRIOS GERAIS
// =======================
function toggleActions() {
    const selectedStudents = document.querySelectorAll(".student-checkbox:checked");
    const actionsContainer = document.getElementById("actions-container");

    actionsContainer.style.display = selectedStudents.length > 0 ? "block" : "none";
}

function toggleDropdown(event) {
    event.stopPropagation();
    const selectBox = event.currentTarget;
    selectBox.classList.toggle("active");
}

function toggleClassroomDropdown(event) {
    event.stopPropagation();
    const selectBox = event.currentTarget;
    selectBox.classList.toggle("active");
}

function stopCheckboxPropagation(event) {
    event.stopPropagation();
}

// =======================
// MODAL: REMOVER ALUNO
// =======================
function modalDeleteStudent(student_id) {
    if (isValidVariable(student_id)) {
        let student_name = $(`table tbody tr[data-id-student="${student_id}"]`).find(".full_name").text();
        $("#delete_student_modal_item").text(`o(a) aluno(a) ${student_name}?`);
        $("#student_to_delete").val(student_id);
        $("#delete_student_modal").modal("show");
    }
}

function deleteStudentComfirmed() {
    let student_id = $("#student_to_delete").val();

    if (isValidVariable(student_id)) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: `/students/${student_id}`,
            type: "DELETE",
            success: function (response) {
                $(`table tbody tr[data-id-student="${student_id}"]`).remove();
                $("#delete_student_modal").modal("hide");
                notify(response.msg, response.icon);
            },
            error: function (error) {
                let data = error.responseJSON;
                notify(data.msg, data.icon);
            },
        });
        closeAllModals();
        $("#student_to_delete").val("");
    }
}

// =======================
// FILTROS
// =======================
function applyFilters() {
    let grade_id = document.getElementById("filter_grade").value;
    let classroom_id = document.getElementById("filter_classroom").value;
    let status = document.getElementById("filter_status").value;
    let period = document.getElementById("period").value;
    let url = new URL(window.location.href);

    grade_id ? url.searchParams.set("grade_id", grade_id) : url.searchParams.delete("grade_id");
    classroom_id ? url.searchParams.set("classroom_id", classroom_id) : url.searchParams.delete("classroom_id");
    status ? url.searchParams.set("status", status) : url.searchParams.delete("status");
    period ? url.searchParams.set("period", period) : url.searchParams.delete("period");

    window.location.href = url.toString();
}

document.getElementById("filter_grade").addEventListener("change", applyFilters);
document.getElementById("filter_classroom").addEventListener("change", applyFilters);
document.getElementById("filter_status").addEventListener("change", applyFilters);

// =======================
// MODAL: EXPORTAÇÃO DE AVALIAÇÕES
// =======================
let selectedStudentId = null;

function openExportModal(studentId) {
    selectedStudentId = studentId;
    $("#evaluation-period").val("");
    $("#export-classroom-select").empty().hide();
    $("#evaluation-download").hide();
    $("#export_modal").modal("show");
}

function submitEvaluationReportDownload() {
    let period = $("#evaluation-period").val();
    let classroom = $("#export-classroom-select").val();

    if (!period) return notify("Por favor, selecione um período.", "error");

    let evaluationsDownloadUrl = $("#export_modal").data("route");

    var form = document.createElement("form");
    form.method = "POST";
    form.action = evaluationsDownloadUrl;
    form.target = "_blank";

    const inputs = [
        { name: "_token", value: $('meta[name="csrf-token"]').attr("content") },
        { name: "student_id", value: selectedStudentId },
        { name: "period", value: period },
        { name: "classroom_id", value: classroom }
    ];

    inputs.forEach(({ name, value }) => {
        let input = document.createElement("input");
        input.type = "hidden";
        input.name = name;
        input.value = value;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function fetchClassroomsWithEvaluationsByPeriod() {
    let period = $("#evaluation-period").val();
    if (!period) return notify("Por favor, selecione um período.", "error");

    $.ajax({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        url: $("#evaluation-period").data("route"),
        type: "POST",
        data: { student_id: selectedStudentId, period },
        success: function (response) {
            let select = $("#export-classroom-select").empty();
            select.append($("<option>", { value: "all", text: "Todas" }));

            if (response?.length > 0) {
                response.forEach(({ id, name }) => {
                    select.append($("<option>", { value: id, text: name }));
                });
                select.show();
                $("#evaluation-download").show();
            } else {
                select.hide();
                $("#evaluation-download").hide();
                notify("Sem avaliações no período", "error");
            }
        },
        error: function (_, __, error) {
            notify(error, "error");
        },
    });
}

// =======================
// SELEÇÃO EM MASSA DE ALUNOS
// =======================
document.getElementById("select-all").addEventListener("click", function () {
    document.querySelectorAll(".student-checkbox").forEach(cb => cb.checked = this.checked);
    toggleActions();
});

document.querySelectorAll(".student-checkbox").forEach(cb => {
    cb.addEventListener("change", toggleActions);
});

document.getElementById("student-actions").addEventListener("change", function () {
    const action = this.value;
    const selectedStudents = Array.from(
        document.querySelectorAll(".student-checkbox:checked")
    ).map(cb => cb.dataset.id);

    if (action === "change-classroom") openClassroomModal(selectedStudents);
    else if (action === "include-in-courses") openCoursesModal(selectedStudents);
    else if (action === "remove-classroom") openRemoveClassroomModal(selectedStudents);
    else if (action === "change-serie") openChangeSeriesModal(selectedStudents);

    this.value = "";
});

// =======================
// MODAL: ALTERAR TURMA
// =======================
function openClassroomModal(selectedStudents) {
    $.ajax({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        url: "/students/getUnrelatedClassrooms",
        type: "POST",
        data: { students: selectedStudents },
        success: function (response) {
            if (response.success) {
                var select = $("#classroom-select").empty().append(
                    $("<option>", { value: "", text: "Selecione a turma" })
                );
                response.classrooms.forEach(({ id, name }) => {
                    select.append($("<option>", { value: id, text: name }));
                });
                $("#change_classroom_modal").modal("show");
            }
        },
        error: function (error) {
            let data = error.responseJSON;
            notify(data.msg, data.icon);
        },
    });
}

function submitClassroomChange() {
    const classroomId = $("#classroom-select").val();
    const selectedStudents = Array.from(
        document.querySelectorAll(".student-checkbox:checked")
    ).map(cb => cb.dataset.id);

    if (!classroomId) return notify("Por favor, selecione uma turma.", "error");

    $.ajax({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        url: "/students/changeClassrooms",
        type: "POST",
        data: { students: selectedStudents, classroom_id: classroomId },
        success: function () {
            $("#change_classroom_modal").modal("hide");
            notify("Concluído com sucesso");
        },
        error: function (error) {
            let data = error.responseJSON;
            notify(data.msg, data.icon);
        },
    });
}

// =======================
// MODAL: INCLUIR EM CURSOS
// =======================
function openCoursesModal() {
    $("#include_courses_modal").modal("show");
}

function submitCoursesSelection() {
    const selectedCourses = Array.from(
        document.querySelectorAll('#course-dropdown input[type="checkbox"]:checked')
    ).map(cb => cb.value);

    if (!selectedCourses.length)
        return notify("Por favor, selecione pelo menos um curso.", "error");

    const selectedStudents = Array.from(
        document.querySelectorAll(".student-checkbox:checked")
    ).map(cb => cb.dataset.id);

    $.ajax({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        url: "/students/includeVideoCourses",
        type: "POST",
        data: { students: selectedStudents, video_courses: selectedCourses },
        success: function () {
            $("#include_courses_modal").modal("hide");
            notify("Concluído com sucesso");
        },
        error: function (error) {
            let data = error.responseJSON;
            notify(data.msg, data.icon);
        },
    });
}

// =======================
// MODAL: REMOVER DE TURMAS
// =======================
let pendingRemovalData = {
    students: [],
    classrooms: []
};

function openRemoveClassroomModal(selectedStudents) {
    $.ajax({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        url: "/students/getRelatedClassrooms",
        type: "POST",
        data: { students: selectedStudents },
        success: function (response) {
            if (response.success) {

                const dropdown = document.getElementById('classroom-dropdown');
                dropdown.innerHTML = '';
                
                response.classrooms.forEach(classroom => {
                    const label = document.createElement('label');
                    label.setAttribute('onclick', 'stopCheckboxPropagation(event)');
                    
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'classrooms[]';
                    checkbox.value = classroom.id;
                    checkbox.setAttribute('onclick', 'stopCheckboxPropagation(event)');
                    
                    const text = document.createTextNode(` ${classroom.name}`);
                    
                    label.appendChild(checkbox);
                    label.appendChild(text);
                    dropdown.appendChild(label);
                });
                
                $("#remove_classroom_modal").modal("show");
            }
        },
        error: function (error) {
            let data = error.responseJSON;
            notify(data.msg, data.icon);
        },
    });
}

function submitClassroomRemoval() {
    const selectedClassrooms = Array.from(
        document.querySelectorAll('#classroom-dropdown input[type="checkbox"]:checked')
    ).map(cb => cb.value);

    if (!selectedClassrooms.length)
        return notify("Por favor, selecione pelo menos uma turma.", "error");

    const selectedStudents = Array.from(
        document.querySelectorAll(".student-checkbox:checked")
    ).map(cb => cb.dataset.id);

    pendingRemovalData.students = selectedStudents;
    pendingRemovalData.classrooms = selectedClassrooms;

    $("#remove_classroom_modal").modal("hide");

    updateConfirmationModal(selectedStudents.length, selectedClassrooms);

    $("#removal_confirmation_modal").modal("show");
}

function updateConfirmationModal(studentCount, classroomIds) {

    document.getElementById('student-count').textContent = studentCount;

    const classroomNames = [];
    classroomIds.forEach(classroomId => {
        const checkbox = document.querySelector(`#classroom-dropdown input[value="${classroomId}"]`);
        if (checkbox) {
            const label = checkbox.closest('label');
            const classroomName = label.textContent.trim();
            classroomNames.push(classroomName);
        }
    });

    const classroomElement = document.getElementById('classroom-name');
    if (classroomNames.length === 1) {
        classroomElement.textContent = `turma ${classroomNames[0]}`;
    } else if (classroomNames.length > 1) {
        classroomElement.textContent = `turmas ${classroomNames.join(', ')}`;
    } else {
        classroomElement.textContent = 'turma';
    }
}

function executeClassroomRemoval() {
    $.ajax({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        url: "/students/removalClassrooms",
        type: "POST",
        data: { 
            students: pendingRemovalData.students, 
            classrooms: pendingRemovalData.classrooms 
        },
        success: function () {
            $("#removal_confirmation_modal").modal("hide");
            notify("Aluno(s) removido(s) com sucesso.");
            
            pendingRemovalData = { students: [], classrooms: [] };
            
            document.querySelectorAll(".student-checkbox").forEach(cb => cb.checked = false);
            document.getElementById("select-all").checked = false;
            toggleActions();
        },
        error: function (error) {
            let data = error.responseJSON;
            notify(data.msg, data.icon);
        },
    });
}

// =======================
// MODAL: ALTERAR SÉRIE
// =======================
function openChangeSeriesModal() {
    $("#change_series_modal").modal("show");
}

function submitSeriesChange() {
    const gradeId = $("#series-select").val();
    const selectedStudents = Array.from(
        document.querySelectorAll(".student-checkbox:checked")
    ).map(cb => cb.dataset.id);

    if (!gradeId) return notify("Por favor, selecione uma série.", "error");

    $.ajax({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        url: "/students/changeSeries",
        type: "POST",
        data: { students: selectedStudents, grade_id: gradeId },
        success: function () {
            $("#change_series_modal").modal("hide");
            notify("Concluído com sucesso");
        },
        error: function (error) {
            let data = error.responseJSON;
            notify(data.msg, data.icon);
        },
    });
}

// =======================
// DATERANGEPICKER (INICIALIZAÇÃO)
// =======================
$(document).ready(function () {
    $("#evaluation-period").daterangepicker({
        autoUpdateInput: false,
        locale: { cancelLabel: "Limpar", format: "DD/MM/YYYY", applyLabel: "Aplicar" },
    });

    $("#evaluation-period").on("apply.daterangepicker", function (ev, picker) {
        $(this).val(`${picker.startDate.format("DD/MM/YYYY")} - ${picker.endDate.format("DD/MM/YYYY")}`);
        fetchClassroomsWithEvaluationsByPeriod();
    });

    $("#evaluation-period").on("cancel.daterangepicker", function () {
        $(this).val("");
        $("#export-classroom-select, #evaluation-download").hide();
    });

    $("#period").daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: "DD/MM/YYYY",
            applyLabel: "Aplicar",
            cancelLabel: "Cancelar",
            daysOfWeek: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            monthNames: [
                "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
                "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
            ],
        },
    });

    $("#period").on("apply.daterangepicker", function (ev, picker) {
        $(this).val(`${picker.startDate.format("DD/MM/YYYY")} - ${picker.endDate.format("DD/MM/YYYY")}`);
    });

    $("#period").on("cancel.daterangepicker", function () {
        $(this).val("");
        applyFilters();
    });

    let period = new URLSearchParams(window.location.search).get("period");
    if (period) {
        $("#period").val(period);
        let dates = period.split(" - ");
        $("#period").data("daterangepicker").setStartDate(dates[0]);
        $("#period").data("daterangepicker").setEndDate(dates[1]);
    }

    $("#period").on("change", function () {
        let dates = $(this).val().split(" - ");
        if (dates.length === 2) {
            let [startDate, endDate] = dates.map(date => moment(date, "DD/MM/YYYY"));

            if (startDate.isValid() && endDate.isValid()) {
                $("#period").data("daterangepicker").setStartDate(startDate);
                $("#period").data("daterangepicker").setEndDate(endDate);
                applyFilters();
            } else {
                notify("Por favor, insira uma data válida no formato DD/MM/YYYY.", "error");
                $(this).val("");
            }
        }
    });
});

// =======================
// FECHAMENTO DE DROPDOWNS AO CLICAR FORA
// =======================
window.addEventListener("click", function (event) {
    const courseBox = document.querySelector("#include_courses_modal .custom-select-box");
    const classroomBox = document.querySelector("#remove_classroom_modal .custom-select-box");

    if (courseBox && !courseBox.contains(event.target)) courseBox.classList.remove("active");
    if (classroomBox && !classroomBox.contains(event.target)) classroomBox.classList.remove("active");

    const confirmButton = document.getElementById('confirm-removal-btn');
    if (confirmButton) {
        confirmButton.addEventListener('click', executeClassroomRemoval);
    }
});
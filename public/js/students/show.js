const selectedStudentId = $('#nav-evaluations').data('student-id');

$(document).ready(function() {
    // Limpa ou configura o daterangepicker se necessário
    $("#evaluation-period").val("");
    $("#export-classroom-select").empty();

    $("#export-classroom-select").hide();
    $("#evaluation-download").hide();


    $( ".expand-profile, .expand-profile-mobile" ).click(function(e) {
        $(this).find('i').toggleClass('fa-angle-down').toggleClass('fa-angle-up');
        $( ".student-data-collapse" ).slideToggle("slow");
    });

    $("#evaluation-period").daterangepicker({
        autoUpdateInput: false,
        startDate: moment().startOf('month'),   // ⬅️ Primeiro dia do mês
        endDate: moment().endOf('month'),       // ⬅️ Último dia do mês
        locale: {
            cancelLabel: "Limpar",
            format: "DD/MM/YYYY",
            applyLabel: "Aplicar"
        },
    });
    
    $("#evaluation-period").val(
        moment().startOf('month').format("DD/MM/YYYY") +
        " - " +
        moment().endOf('month').format("DD/MM/YYYY")
    );

    fetchClassroomsWithEvaluationsByPeriod();

    $("#evaluation-period").on("apply.daterangepicker", function (ev, picker) {
        $(this).val(
            picker.startDate.format("DD/MM/YYYY") +
                " - " +
                picker.endDate.format("DD/MM/YYYY")
        );
        fetchClassroomsWithEvaluationsByPeriod();
    });

    $("#export-classroom-select").on("change", function () {
        const classroomId = $(this).val();
        if (classroomId) {
            fetchEvaluationTableData(classroomId)
            $("#evaluation-download").show();
            $("#evaluation-download").addClass('square-action-btn');
        }
    });

    $("#evaluation-period").on("cancel.daterangepicker", function (ev, picker) {
        $(this).val("");
        $("#export-classroom-select").hide();
        $("#evaluation-download").removeClass('square-action-btn');
        $("#evaluation-download").hide();
        
    });

    
    $("#period").daterangepicker({
        locale: {
            format: "DD/MM/YYYY",
            applyLabel: "Aplicar",
            cancelLabel: "Cancelar",
            daysOfWeek: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            monthNames: [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro",
            ],
        },
        autoUpdateInput: false,
        isInvalidDate: function (date) {
            return false;
        },
    });

    $("#period").on("apply.daterangepicker", function (ev, picker) {
        $(this).val(
            picker.startDate.format("DD/MM/YYYY") +
                " - " +
                picker.endDate.format("DD/MM/YYYY")
        );
    });

    $("#period").on("cancel.daterangepicker", function (ev, picker) {
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
            let startDate = moment(dates[0], "DD/MM/YYYY");
            let endDate = moment(dates[1], "DD/MM/YYYY");

            if (startDate.isValid() && endDate.isValid()) {
                $("#period").data("daterangepicker").setStartDate(startDate);
                $("#period").data("daterangepicker").setEndDate(endDate);
                applyFilters();
            } else {
                notify(
                    "Por favor, insira uma data válida no formato DD/MM/YYYY.",
                    "error"
                );
                $("#period").val("");
            }
        }
    });
})

    function commentModal(studentId, studentName, comment = '') {
        $("#comment-title").text(`Comentário de ${studentName}`);
        $("#comment-textarea").val(comment);
        new bootstrap.Modal(document.getElementById('comment-modal')).show(); // para garantir com Bootstrap 5
    }

    function submitEvaluationReportDownload() {
        let period = $("#evaluation-period").val();
        let classroom = $("#export-classroom-select").val();

        if (!period) {
            notify("Por favor, selecione um período.", "error");
            return;
        }

        // Cria um formulário temporário
        var form = document.createElement("form");
        form.method = "POST";
        form.action = evaluationsDownloadUrl;
        form.target = "_blank";

        // Adiciona CSRF token
        var csrfInput = document.createElement("input");
        csrfInput.type = "hidden";
        csrfInput.name = "_token";
        csrfInput.value = $('meta[name="csrf-token"]').attr("content");
        form.appendChild(csrfInput);

        // student_id
        var studentInput = document.createElement("input");
        studentInput.type = "hidden";
        studentInput.name = "student_id";
        studentInput.value = selectedStudentId;
        form.appendChild(studentInput);

        // period
        var periodInput = document.createElement("input");
        periodInput.type = "hidden";
        periodInput.name = "period";
        periodInput.value = period;
        form.appendChild(periodInput);

        // classroom_id
        var classroomInput = document.createElement("input");
        classroomInput.type = "hidden";
        classroomInput.name = "classroom_id";
        classroomInput.value = classroom;
        form.appendChild(classroomInput);

        // Adiciona o form ao body, submete e depois remove
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);

        // Caso queira fechar o modal após iniciar o download:
        // $('#export_modal').modal('hide');
    }

    function fetchClassroomsWithEvaluationsByPeriod() {
        let period = $("#evaluation-period").val();

        if (!period) {
            notify("Por favor, selecione um período.", "error");
            return;
        }

        let data = {
            student_id: selectedStudentId,
            period: period,
        };

        let classroomsWithEvaluationsUrl = $("#evaluation-period").data("route");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: classroomsWithEvaluationsUrl, // Usa a URL obtida do HTML
            type: "POST",
            data: data,
            success: function (response) {
                // Remove todas as opções exceto "all"
                $("#export-classroom-select").empty();

                if (response && response.length > 0) {
                    // Adiciona as salas de aula retornadas na resposta
                    response.forEach((classroom) => {
                        $("#export-classroom-select").append(
                            $("<option>", {
                                value: classroom.id,
                                text: classroom.name,
                            })
                        );
                    });

                    // Mostra os selects e botão de download
                    $("#export-classroom-select").show();

                    // Seleciona a primeira turma automaticamente e dispara o .change()
                    $("#export-classroom-select").val(response[0].id).trigger("change");

                } else {
                    // Esconde os selects e botão de download caso não haja resultados
                    $("#export-classroom-select").hide();
                    $("#evaluation-download").hide();

                    // Notifica o usuário
                    notify("Sem avaliações no período", "error");
                }
            },
            error: function (xhr, status, error) {
                notify(error, "error");
            },
        });
    }

    function fetchEvaluationTableData(classroomId) {
        const route = $("#export-classroom-select").data("fetch-route"); // você precisa setar isso no HTML
        const period = $("#evaluation-period").val();

        $.ajax({
            url: route,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                classroom_id: classroomId,
                student_id: selectedStudentId,
                period: period,
            },
            success: function (response) {
                // Aqui você manipula a tabela
                const tbody = $("#table-student-evaluations tbody");
                tbody.empty();

                if (response.length > 0) {
                    response.forEach((evaluation) => {
                        const values = evaluation.values;

                        const getValueByTitle = (paramTitle) => {
                            const val = values.find(v => v.parameter?.title === paramTitle);
                            return val && val.value ? val.value.title : '-';
                        };

                        const hasComment = !!evaluation.comment;
                        const buttonClass = hasComment ? "square-action-btn btn-comment" : "square-action-btn";

                        const rowHtml = `
                            <tr>
                                <td>${evaluation.evaluation.date}</td>
                                <td>${getValueByTitle("Participação")}</td>
                                <td>${getValueByTitle("Tarefas")}</td>
                                <td>${getValueByTitle("Comportamento")}</td>
                                <td>${getValueByTitle("Câmera")}</td>
                                <td class="text-center align-middle">
                                    <button 
                                        type="button" 
                                        class="${buttonClass}"
                                        onclick="commentModal(${evaluation.student_id}, '${evaluation.student.full_name}', \`${evaluation.comment || ''}\`)"
                                    >
                                        <img src="${messageIconUrl}" alt="">
                                    </button>
                                </td>
                            </tr>
                        `;

                        tbody.append(rowHtml);
                    });
                } else {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="text-center">Nenhum dado encontrado.</td>
                        </tr>
                    `);
                }
            },
            error: function () {
                notify("Erro ao buscar os dados da tabela.", "error");
            }
        });
    }

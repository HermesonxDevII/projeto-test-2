function modalDeleteGuardian(guardian_id, students) {
    if (isValidVariable(guardian_id)) {
        if (students > 0) {
            $("#guardian_has_students_item").text(students);
            $("#guardian_to_edit").val(guardian_id);
            $("#guardian_has_students").modal("show");
        } else {
            let guardian_name = $(
                `table tbody tr[data-id-guardian="${guardian_id}"]`
            )
                .find(".name")
                .text();
            $("#delete_guardian_modal_item").text(
                `o(a) responsável ${guardian_name}?`
            );
            $("#guardian_to_delete").val(guardian_id);
            $("#delete_guardian_modal").modal("show");
        }
    } else {
        showAlertModal("Responsável inválido!");
    }
}

function modalConfirmConsultoriaGuardian(guardian_id, has_consultancy) {
    if (isValidVariable(guardian_id)) {

        if(has_consultancy) {            
            $("#guardian_to_delete").val(guardian_id);

            $("#delete_consultancy_modal").modal("show");            
        } else {            
            $("#guardian_to_confirm").val(guardian_id);

            $("#confirm_consultancy_modal").modal("show");
        }
        
    } else {
        showAlertModal("Responsável inválido!");
    }
}

function deleteGuardianComfirmed() {
    let guardian_id = $("#guardian_to_delete").val();

    if (isValidVariable(guardian_id)) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: `/guardians/${guardian_id}`,
            type: "DELETE",
            success: function (response) {
                $(`table tbody tr[data-id-guardian="${guardian_id}"]`).remove();
                $("#delete_guardian_modal").modal("hide");

                notify(response.msg, response.icon);
            },
            error: function (error) {
                let data = error.responseJSON;
                notify(data.msg, data.icon);
                closeAllModals();
            },
        });
        $("#guardian_to_delete").val("");
    }
}

function updateConsultancyGuardian(has_consultancy, type) {
    let guardian_id = null
    if(type === 'confirm') {
        guardian_id = $("#guardian_to_confirm").val();
    } else {
        guardian_id = $("#guardian_to_delete").val();
    }

    if (isValidVariable(guardian_id)) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: `/guardians/${guardian_id}/consultancy/update`,
            type: "PUT",
            data: {
                has_consultancy: has_consultancy,
            },
            success: function (response) {
                // Seletor para o elemento específico
                const iconElement = $(`.btn-action-consultancy[data-guardian-id="${guardian_id}"]`);

                if (iconElement.length > 0) {
                    // Troca as classes com base no valor de has_consultancy
                    if (has_consultancy) {                        
                        iconElement
                            .removeClass("icon-check-false") // Remove a classe antiga
                            .addClass("icon-check-true"); // Adiciona a classe nova
                    } else {
                        iconElement
                            .removeClass("icon-check-true") // Remove a classe antiga
                            .addClass("icon-check-false"); // Adiciona a classe nova
                    }
                }    
                
                // Atualiza o evento onclick
                const newOnClick = `modalConfirmConsultoriaGuardian('${guardian_id}', ${has_consultancy});`;
                iconElement.attr("onclick", newOnClick);

                $("#confirm_consultancy_modal").modal("hide");
                $("#delete_consultancy_modal").modal("hide");

                notify(response.msg, response.icon);
            },
            error: function (error) {
                let data = error.responseJSON;
                notify(data.msg, data.icon);
                closeAllModals();
            },
        });
        $("#guardian_to_confirm").val("");
    }
}

document.getElementById("filter_grade").addEventListener("change", function () {
    applyFilters();
});

document
    .getElementById("filter_classroom")
    .addEventListener("change", function () {
        applyFilters();
    });

document
    .getElementById("filter_status")
    .addEventListener("change", function () {
        applyFilters();
    });

function applyFilters() {
    let grade_id = document.getElementById("filter_grade").value;
    let classroom_id = document.getElementById("filter_classroom").value;
    let status = document.getElementById("filter_status").value;
    let period = document.getElementById("period").value;

    let url = new URL(window.location.href);

    if (grade_id) {
        url.searchParams.set("grade_id", grade_id);
    } else {
        url.searchParams.delete("grade_id");
    }

    if (classroom_id) {
        url.searchParams.set("classroom_id", classroom_id);
    } else {
        url.searchParams.delete("classroom_id");
    }

    if (status) {
        url.searchParams.set("status", status);
    } else {
        url.searchParams.delete("status");
    }

    if (period) {
        url.searchParams.set("period", period);
    } else {
        url.searchParams.delete("period");
    }

    window.location.href = url.toString();
}

function editGuardian() {
    let guardian_id = $("#guardian_to_edit").val();

    if (isValidVariable(guardian_id)) {
        window.open(`/guardians/${guardian_id}/edit`);
    }
}

$(document).ready(function () {
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
        applyFilters();
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
});

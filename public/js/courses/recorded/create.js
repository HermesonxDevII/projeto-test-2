var materialKey = 0;

function addMaterialFiles(materials) {
  let fileList = $('.drop-files-list');
  let filename = '';
  let filesize = 0;

  for(var i = 0; i<materials.files.length; i++) {
    let file = materials.files[i];

    if (i > 0) {
      filename += ', ';
    }

    filename += file.name;
    filesize += file.size;
  }
  
  fileList.append(`
    <div class="drop-file-item">
        <img src="/images/icons/file-pdf-2.svg"" alt="File Icon" />
        <span>${filename}</span>
        <i class="drop-file-remove">
            <img src="/images/icons/x.svg" alt="Remove Icon" data-key="${materialKey}">
        </i>
        <small class="drop-file-size"> ${bytesToSize(filesize)}</small>
    </div>
  `);
  
  createMaterialInput();
  bindRemoveEvent();
}

function createMaterialInput() {
  materialKey += 1;

  let materialEl = `<input type="file" class="d-none" id="materials" name="materials[]" 
    multiple onchange="addMaterialFiles(this)" data-key="${materialKey}"></input>`;

  $('input[name="materials[]"]:last').after(materialEl);
}

// Events
$('.drop-files').on('click drag', ((e) => {
    $('input[name="materials[]"]').last().click();
}));

$('.submit').on('click', function () {
    let form = $('#course_form');

    if (validateForm()) {
        let descriptionSize = $('#description').val().length,
            embed = $('#embed').val().length,
            link = $('#link').val().length;

        if (descriptionSize > 950) {
            showAlertModal(`A descrição pode conter até 950 caracteres. Quantidade de caracteres atual: ${descriptionSize}.`);
            return;
        }

        if (link == 0 && embed == 0) {
            showAlertModal(`Você precisa inserir um código embed válido do Genially ou um link de um vídeo do Youtube/Vimeo antes de salvar uma aula.`);
            return;
        }

        form.submit();
    } else {
        showAlertModal('Para inserir uma nova aula preencha todos os campos.');
    }
});

function validateForm() {
    let isValid = true;
    let embed = $('#embed').val();

    $('#course_form input, select').not(':hidden').not('#embed').not('#link').each(function (i, e) {
        if (!isValidVariable($(e).val())) {
            isValid = false;
        }
    });

    if (embed != "") {
        !validateHTML(embed) ? isValid = false: ""
    }

    return isValid;
}


function bindRemoveEvent() {
    // Bind events to new inputs
    $('.drop-file-remove').click((e)=> {
      let key = $(e.target).attr('data-key');
      $(`input[name="materials[]"][data-key="${key}"]`).remove();
      $(e.target).closest('.drop-file-item').remove();
    });
}


$('document').ready(function() {
    $('#embed').on('change keyup keydown focusin focusout', function(e) {
        if ($('#embed').val() == "") {
            $('#embed').removeClass('is-valid').removeClass('is-invalid');
        } else if (!validateHTML(e.target.value)) {
            $('#embed').removeClass('is-valid').addClass('is-invalid');
            $('#embed-feedback').show();
        } else {
            $('#embed').removeClass('is-invalid').addClass('is-valid');
        }
    });

    bindRemoveEvent();

    $('#link').on('change', function () {
        let embed = $('#embed');
        embed.val('');

        $(this).val() != ''
            ? embed.prop('readonly', true)
            : embed.prop('readonly', false);
    });

    $('#embed').on('change', function () {
        let link = $('#link');
        link.val('');

        $(this).val() != ''
            ? link.prop('readonly', true)
            : link.prop('readonly', false);
    });
});

//MODAL DE VIDEOS - YOUTUBE
$(document).on("click","#btn_modal_yt",function(){
    let modal = $('#yt_modal');
    modal.modal('show');

    //se nao tiver div de videos e nem estiver carregando, envia requisição
    if($(modal).find('.modal-body').find('.videos').length === 0
        && $(modal).find('.modal-body').find('img').length ===0){

        $(modal).find('.modal-body').find('.text-center').append
        (`<img src="${window.location.origin}/images/loading.svg" />`);

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/youtube/getVideos`,
            type: 'GET',
            success: function (response) {
                videos = response;

                generateSearchInput();
                generateVideosModal(response[0]);
                generatePaginate(response.length);

            },
            error: function (error) {
                $(modal).find('.modal-body').find('.text-center').find('img').remove();
                $(modal).find('.modal-body').find('.text-center').append(error);
            }
        });
    }
})

//animação ao clicar no vídeo selecionado
$(document).on("click", ".btn_video_select", function(){
    let id = $(this).attr('id');
    let buttons = $(this).parents('.row').find('button');
    $(buttons).each(function(i, e){
        $(e).find('div').css('border','4px solid #fff');
    });
    $(this).find('div').css('border','4px solid #0da9bf');
    $('#yt_video_selected').val(`https://www.youtube.com/watch?v=${id}`);
})

//adicionar url de video no input
$(document).on("click", "#yt_system_confirm", function(){
    let url = $('#yt_video_selected').val();
    $('input#link').val(url);
    closeAllModals();
})

//procurar video por palavra chave
$(document).on("click", "#search_addon", function(){
    let input = $('#search_modal').find('input').val();
    //rm caracter especial
    let input_fetch = input.replace(" ", "_");
    input_fetch = input_fetch.replace(/[_\W]+/g, "_");

    if(isValidVariable(input_fetch) && !input_fetch.includes('/') && !input_fetch.includes('-')){

        $('#yt_modal').find('.modal-body').find('.row').remove();
        $('#yt_modal').find('.modal-body').find('.text-center').append
            (`<img src="/images/loading.svg" />`);

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/youtube/getSearch/${input_fetch}`,
            type: 'GET',
            success: function (response) {
                videos = response;

                generateSearchInput();
                generateVideosModal(response[0]);
                generatePaginate(response.length);

                $('#yt_modal').find('.input-group').after(`<span class="mb-2">Exibindo resultados para '${input}'</span>`);
                $('#yt_modal').find('input').val(input);
            },
            error: function (error) {
                $('#yt_modal').find('.modal-body').find('.text-center').find('img').remove();
                $('#yt_modal').find('.modal-body').find('.text-center').append(error);
            }
        });
    }
})

//gerar input de busca no modal
function generateSearchInput(){
    $('#yt_modal').find('.modal-body').find('.text-center').find('img').remove();
    $('#yt_modal').find('.modal-body').find('.text-center').append(`
    <div class="row mt-4">
        <div class="col-12 mb-1">
            <div class="d-flex" id="search_modal">
                <input type="text" class="form-control m-auto" placeholder="Faça uma busca..." aria-describedby="search_addon">
                <button class="btn bg-primary btn-shadow ps-2 pe-2 m-2" id="search_addon">
                    <img src="/images/icons/find.svg" alt="Find Icon" />
                </button>
            </div>
        </div>
    </div>`);
}

//gerar vídeos no modal
function generateVideosModal(response){

    $('#yt_modal').find('.row').append(`<div class="videos row"></div>`);

    $(response).each(function(i, video){
        let image = video.snippet.thumbnails.medium.url;
        let name = video.snippet.title;
        $('#yt_modal').find('.videos').append(`
            <button type="button" class="btn col-md-4 btn_video_select"
                title="${name}" id="${video.id.videoId}">
                <div class="mb-2 img_div_yt">
                    <img src="${image}" alt="${name}" class="img_video_yt">
                    <span class="desc">${name}</p>
                </div>
            </button>
        `);
    })

}

//gerar botões de paginação no modal
function generatePaginate(limit){
    $('#yt_modal').find('.modal-footer').find('nav').remove();
    if(limit>0){
        $('#yt_modal').find('.modal-footer').prepend(`
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item disabled">
                    <button class="btn page-link" id="btn_paginate_modal_0"><i class="fa-solid fa-chevron-left"></i></button>
                </li>`);

                for(i=0; i<limit; i++){
                    $('.pagination').append(`
                    <li class="page-item ${i==0?'active':''}">
                        <button class="btn page-link" id="btn_paginate_modal_${i+1}">${i+1}</button>
                    </li>`);
                }

                $('.pagination').append(`
                <li class="page-item">
                    <button class="btn page-link" id="btn_paginate_modal_${limit+1}"><i class="fa-solid fa-chevron-right"></i></button>
                </li>
            </ul>
        </nav>
        `);
    }
}

//paginação do modal
$(document).on('click', '.page-item', async function(){

    if(!$(this).hasClass('disabled')){

        let page = $(this).find('button').attr('id').split('_')[3];

        $(this).parents('.pagination').find('li').each(function(){
            if($(this).hasClass('active')){
                page_active = $(this).find('button').attr('id').split('_')[3];
            }
        })

        if(page!="0" && page!=videos.length+1){
            $(this).parents('.pagination').find('li').removeClass('active');
            $(this).addClass('active');

        }else if(page=="0" || page==videos.length+1){
            if(page==videos.length+1){
                $(this).parents('.pagination').find('li').removeClass('active');
                $(this).parents('.pagination').find(`#btn_paginate_modal_${parseInt(page_active)+1}`).parents('li').addClass('active');
            }else if(page=="0"){
                $(this).parents('.pagination').find('li').removeClass('active');
                $(this).parents('.pagination').find('#btn_paginate_modal_'+(page_active-1)).parents('li').addClass('active');
            }
        }

        if(page>"1" && $("#btn_paginate_modal_0").parents('.page-item').hasClass('disabled')){
            $("#btn_paginate_modal_0").parents('.page-item').removeClass('disabled');
        }
        if(page=="1" || (page_active=="2" && page=="0")){
            $("#btn_paginate_modal_0").parents('.page-item').addClass('disabled');
        }

        if((page==videos.length+1 && page_active==videos.length-1) || page==videos.length){
           $('#btn_paginate_modal_'+(videos.length+1)).parents('.page-item').addClass('disabled');
        }
        if(page<videos.length && $('#btn_paginate_modal_'+(videos.length+1)).parents('.page-item').hasClass('disabled')==true){
            $('#btn_paginate_modal_'+(videos.length+1)).parents('.page-item').removeClass('disabled');
        }

        $('#yt_modal').find('.videos').remove();
        if(page!="0" && page!=videos.length+1){
            generateVideosModal(videos[page-1]);
        }else{
            if(page=="0"){
                generateVideosModal(videos[page_active-2]);
            }
            if(page==videos.length+1){
                generateVideosModal(videos[page_active]);
            }
        }
    }
})

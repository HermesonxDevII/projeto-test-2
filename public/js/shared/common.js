/* eslint-disable */

// Global AJAX Setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// UI Utility Functions
function loading() {
    $('#loading_modal').modal('toggle');
}

$('.expand-profile, .expand-profile-mobile').on('click', function () {
    $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
    $('.data-collapse').slideToggle('slow');
});

function showAlertModal(message) {
    const modal = $('#alert_modal');
    if (isValidVariable(message)) {
        modal.find('#message').text(message);
        modal.modal('show');
    }
}

function bytesToSize(bytes) {
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes === 0) {
        return 'n/a';
    }
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
}

function initialUpper(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
}

function select2Setup() {
    $('.select2').select2();
}

function copyElementText(elementId) {
    const range = document.createRange();
    range.selectNode(document.getElementById(elementId));
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
    document.execCommand("copy");
    window.getSelection().removeAllRanges();
}

function closeAllModals() {
    $('.modal').each(function (_index, value) {
        $(value).modal('hide');
    });
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

function notify(message = '', status = 'success') {
    Toast.fire({
        icon: status,
        title: message
    });
}

function formatIframe(iframeCode) {
    const iframe = $(`<div>${iframeCode}</div>`).find('iframe');
    if (iframe.length === 0) {
        return false;
    }
    return iframe.get(0).outerHTML;
}

function isHTML(str) {
    const a = document.createElement('div');
    a.innerHTML = str;
    for (let c = a.childNodes, i = c.length; i--;) {
        if (c[i].nodeType === 1) return true;
    }
    return false;
}

function validateHTML(html) {
    if (!isHTML(html)) {
        return false;
    }
    const doc = document.createElement('div');
    doc.innerHTML = html;
    return (doc.innerHTML === html);
}

// Student & Session Related Functions
let user_role, user_id, student;

function getApiParticipantId() {
    if (user_role === 'guardian' && typeof studentId !== 'undefined' && studentId !== null) {
        return studentId;
    }
    
    return user_id;
}

function getUserRole() {
    $.ajax({
        url: `/session/getUserRole`,
        async: false,
        type: 'GET',
        success: (response) => {
            user_role = response;
        }
    });
}

function getUserId() {
    $.ajax({
        url: `/session/getUserId`,
        async: false,
        type: 'GET',
        success: (response) => {
            user_id = response;
        }
    });
}

function getStudent() {
    $.ajax({
        url: `/session/getStudent`,
        async: false,
        type: 'GET',
        success: (response) => {
            student = response;
        }
    });
}

function chooseStudent() {
    $.ajax({
        url: `/users/getStudents`,
        type: 'GET',
        success: function (response) {
            const studentsContainer = $('#choose_student_modal .modal-body .students');
            studentsContainer.html('');
            response.forEach(element => {
                studentsContainer.append(`
                    <div class="col-5 row text-center justify-content-center student"
                        id="student-${element.id}" onclick="">
                        <img src="/images/avatars/avatar${element.avatar_id}.svg" class="student-avatar"
                            alt="Student Avatar">
                        <span class="pt-3 student-name">
                            <b>${element.full_name}</b>
                        </span>
                        <span class="mb-3">Aluno(a)</span>
                    </div>
                `);
            });
            $('#choose_student_modal').modal('show');
        }
    });
}

// Notifications
let recentNotifications = [];

function subscribeToCourses() {
    $.ajax({
        type: 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: `/students/getCoursesOfSelectedStudent`,
        success: function (response) {
            response.map(course => {
                pusher.subscribe(`course-${course.id}-notifications`);
            });

            const callback = (data) => {
                localStorage.setItem('is-read-notifications', 0);
                const notificationExists = recentNotifications.filter(obj => data.id === obj.id);

                if (notificationExists.length === 0) {
                    recentNotifications.push(data);
                }

                localStorage.setItem('recent-notifications', JSON.stringify(recentNotifications));
                showNotificationsCounter();
                showRecentNotifications();
            };

            pusher.bind('App\\Events\\CourseStartNotification', callback);
        },
        error: function () {
            showAlertModal('Houve um erro ao configurar as notificações.');
        }
    });
}

function unsubscribeFromCourses() {
    return new Promise((resolve) => {
        $.ajax({
            type: 'GET',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/students/getCoursesOfSelectedStudent`,
            success: function (response) {
                response.map(course => {
                    pusher.unsubscribe(`course-${course.id}-notifications`);
                });
                localStorage.clear();
                resolve(response);
            },
            error: function () {
                showAlertModal('Houve um erro ao configurar as notificações.');
            }
        });
    });
}

function getWeeklyNotificationsByStudentSelected(course_type) {
    const notificacoes = $('.notification-list');
    const bubbleCounter = $('#notification-counter');

    $('#notification-dropdown').toggleClass('d-none');
    bubbleCounter.addClass('d-none');
    bubbleCounter.text(0);

    localStorage.setItem('is-read-notifications', 1);

    $.ajax({
        type: 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: `/students/getWeeklyNotificationsByStudentSelected/${course_type}`,
        beforeSend: function () {
            notificacoes.html('<img class="notification-loading" src="images/loading.svg" alt="Loading"/>');
        },
        success: function (response) {
            notificacoes.html('');
            response.map(course => {
                notificacoes.append(`
                    <div class="notification">
                        <span>${course.date}</span>
                        <b>${course.title}</b>
                        <p>${course.message}</p>
                    </div>
                `);
            });
            if (response.length === 0) {
                notificacoes.html('<p class="pt-4 m-2">Sem notificações.</p>');
            }
        },
        error: function () {
            showAlertModal('Houve um erro ao carregar as notificações.');
        }
    });
}

function getRecentNotifications() {
    return JSON.parse(localStorage.getItem('recent-notifications') ?? '[]');
}

function isReadNotifications() {
    const isRead = localStorage.getItem('is-read-notifications');
    return parseInt(isRead ?? 1);
}

function showNotificationsCounter() {
    const currentRecentNotifications = getRecentNotifications();
    const bubbleCounter = $('#notification-counter');

    if (!isReadNotifications()) {
        bubbleCounter.removeClass('d-none');
        bubbleCounter.text(currentRecentNotifications.length <= 9 ? currentRecentNotifications.length : '9+');
    }

    if (currentRecentNotifications.length === 0) {
        bubbleCounter.addClass('d-none');
    }
}

function showRecentNotifications() {
    const notifications = getRecentNotifications();

    if (notifications !== null) {
        notifications.forEach(function (notification) {
            if (notification !== null) {
                const hasNotification = $('#courses-notifications').find(`#course-${notification.id}-start-notification`);

                if (hasNotification.length === 0) {
                    $('#courses-notifications').append(`
                        <div class="alert alert-warning alert-dismissible fade show live-alert" role="alert"
                            id="course-${notification.id}-start-notification">
                            <img src="{{ asset('images/live-badge.svg') }}" alt="Live Icon Badge">
                            Sua aula ao vivo <b>${notification.name}</b> vai começar em breve.
                            <a href="${notification.link}" target="_blank" class="${notification.link === null ? 'd-none' : ''}">Assistir aula</a>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                            onclick="removeCourseNotificationById(${notification.id})" >
                            </button>
                        </div>
                    `);

                    $(`#course-${notification.id}-start-notification`).delay(600000).fadeOut(1000, function () {
                        $(this).remove();
                        removeCourseNotificationById(notification.id);
                    });
                }
            }
        });
    }
}

function removeAllRecentNotifications() {
    localStorage.removeItem('recent-notifications');
}

function removeCourseNotificationById(idCourse) {
    let currentRecentNotifications = getRecentNotifications();
    currentRecentNotifications = currentRecentNotifications.filter(value => value.id !== idCourse);
    localStorage.setItem('recent-notifications', JSON.stringify(currentRecentNotifications));
    showNotificationsCounter();
}

const chatNotificationWrapper = document.getElementById('chat-notification-wrapper');
const chatDropdown = document.getElementById('chat-dropdown');
const chatMessageCounter = document.getElementById('chat-message-counter');
const chatMessagesContainer = document.getElementById('chat-messages-container');
const expandChatButton = document.getElementById('expand-chat-button');
const viewAllChatsButton = document.getElementById('view-all-chats-button');

let chatPollingInterval;

function getChatBaseUrl(includeApi = false) {
    const hostname = window.location.hostname;
    let baseUrl;

    if (hostname === 'localhost') {
        baseUrl = 'http://localhost:81';
    } else if (hostname.includes('homolog')) {
        baseUrl = 'https://chat-homolog.academy-meliseducation.com';
    } else {
        baseUrl = 'https://chat.academy-meliseducation.com';
    }

    return includeApi ? `${baseUrl}/api` : baseUrl;
}

function toggleChatDropdown() {
    if (chatDropdown) {
        chatDropdown.classList.toggle('d-none');
        if (!chatDropdown.classList.contains('d-none')) {
            fetchRecentMessages();
            markAllConversationsAsRead();
        }
    }
}

function setupChatToggle() {
    if (chatNotificationWrapper && chatDropdown) {
        $(document).on('click', function (event) {
            if (!$(event.target).closest('#chat-notification-wrapper').length &&
                !$(event.target).closest('#chat-dropdown').length &&
                !$('#chat-dropdown').hasClass('d-none')) {
                $('#chat-dropdown').addClass('d-none');
            }
        });
    }
}

async function fetchTotalUnreadMessages() {
    try {

        const participantId = getApiParticipantId();
        if (!participantId) return;
    
        const chatBaseUrl = getChatBaseUrl(true);
        const response = await fetch(`${chatBaseUrl}/integration-api/chat/total-unread-messages/${participantId}`);
        const data = await response.json();

        if (chatMessageCounter) {
            if (data.total_unread > 0) {
                chatMessageCounter.textContent = data.total_unread;
                chatMessageCounter.classList.remove('d-none');
            } else {
                chatMessageCounter.classList.add('d-none');
            }
        }
    } catch (error) {
        console.error('Error fetching total unread messages:', error);
    }
}

async function fetchRecentMessages() {
    try {

        const participantId = getApiParticipantId();
        if (!participantId) return;

        const chatBaseUrl = getChatBaseUrl(true);
        const response = await fetch(`${chatBaseUrl}/integration-api/chat/recent-messages-for-notifications/${participantId}`);
        const data = await response.json();

        if (chatMessagesContainer) {
            chatMessagesContainer.innerHTML = '';
            if (data.formatted_messages && data.formatted_messages.length > 0) {
                data.formatted_messages.forEach(message => {
                    const chatURL = `chats/${message.conversation_id}`;
                    const chatItem = `
                        <a href="${chatURL}" class="chat-item text-decoration-none">
                            <div class="chat-content">
                                <span class="chat-name">${message.conversation_name}</span>
                                <p class="chat-last-message">
                                    ${message.last_message_sender
                                        ? message.last_message_sender + ': '
                                        : ''
                                    }${message.last_message}
                                </p>
                            </div>

                            <div class="chat-meta">
                                ${message.unread_count > 0
                                    ? `<div class="chat-unread-count" >${message.unread_count}</div>`
                                    : ''
                                }
                                <span class="chat-time">${message.last_message_time}</span>
                            </div>
                        </a>
                    `;
                    chatMessagesContainer.innerHTML += chatItem;
                });
            } else {
                chatMessagesContainer.innerHTML = '<p class="text-center text-muted">Sem mensagens recentes.</p>';
            }
        }
    } catch (error) {
        console.error('Error fetching recent messages:', error);
    }
}

async function markConversationAsRead(conversationId) {
    try {
        const participantId = getApiParticipantId();
        if (!participantId) return;

        const chatBaseUrl = getChatBaseUrl(true);
        await fetch(`${chatBaseUrl}/integration-api/chat/${conversationId}/mark-as-read/${participantId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        fetchTotalUnreadMessages();
    } catch (error) {
        console.error(`Error marking conversation ${conversationId} as read:`, error);
    }
}

async function markAllConversationsAsRead() {
    try {

        const participantId = getApiParticipantId();
        if (!participantId) return;

        const chatBaseUrl = getChatBaseUrl(true);
        const response = await fetch(`${chatBaseUrl}/integration-api/chat/recent-messages-for-notifications/${participantId}`);

        const data = await response.json();
        if (data.formatted_messages) {
            for (const message of data.formatted_messages) {
                if (message.unread_count > 0) {
                    await markConversationAsRead(message.conversation_id);
                }
            }
        }
        fetchTotalUnreadMessages();
    } catch (error) {
        console.error('Error marking all conversations as read:', error);
    }
}

function setupChatButtons() {
    const chatBaseUrl = getChatBaseUrl();

    if (expandChatButton) {
        expandChatButton.addEventListener('click', function (e) {
            e.preventDefault();
            window.open(`${chatBaseUrl}/chats`);
        });
    }

    if (viewAllChatsButton) {
        viewAllChatsButton.addEventListener('click', function (e) {
            e.preventDefault();
            window.open(`${chatBaseUrl}/chats`);
        });
    }
}

$(document).on('click', '.logout-system', function (event) {
    event.preventDefault();
    $('#logout_modal').modal('show');
});

$(document).on('click', '#logout_system_confirm', async function () {
    $(this).attr('disabled', true);
    await unsubscribeFromCourses();
    $('#logout-form').submit();
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    moment.locale('pt-br');
});

$(document).ready(function () {
    getUserId();
    setupChatToggle();
    setupChatButtons();
    fetchTotalUnreadMessages();
    chatPollingInterval = setInterval(fetchTotalUnreadMessages, 15000);

    showRecentNotifications();
    showNotificationsCounter();
});
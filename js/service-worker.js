// service-worker.js

// Функция для сохранения состояния таймера в localStorage
function saveTimerState(ticketId, timer) {
    localStorage.setItem('timer_' + ticketId, timer);
}

// Функция для восстановления состояния таймера из localStorage
function restoreTimerState(ticketId) {
    return localStorage.getItem('timer_' + ticketId);
}

// Функция для запуска таймера
function startTimer(duration, display, ticketId) {
    var start = Date.now(), // Время начала отсчета
        diff, // Разница между текущим временем и временем начала отсчета
        minutes, seconds;

    function timer() {
        // Вычисляем разницу во времени
        diff = duration - (((Date.now() - start) / 1000) | 0);

        // Преобразуем время в минуты и секунды
        minutes = (diff / 60) | 0;
        seconds = (diff % 60) | 0;

        // Форматируем время для отображения
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        // Обновляем отображение таймера
        display.textContent = minutes + ":" + seconds;

        // Если время истекло, останавливаем таймер
        if (diff <= 0) {
            clearInterval(interval);
            deleteTicket(ticketId);
            return;
        }

        // Сохраняем текущее состояние таймера в localStorage
        saveTimerState(ticketId, diff);
    }

    // Запускаем таймер
    timer();
    var interval = setInterval(timer, 1000);
}
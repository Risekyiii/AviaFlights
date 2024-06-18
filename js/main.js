document.addEventListener('DOMContentLoaded', () => {
    // Функция для загрузки занятых мест
    function loadSeatsData(flightId) {
        fetch('load_seats.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                flightId: flightId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Loaded Seats Data:', data);
            if (data.success) {
                const placesTaken = data.placesTaken;
                document.querySelectorAll('.lalka-btn').forEach(seat => {
                    seat.checked = false;
                    seat.disabled = false;
                    if (placesTaken.includes(parseInt(seat.value))) {
                        seat.checked = true;
                        seat.disabled = true;
                        seat.parentElement.classList.add('occupied');
                    }
                });
            } else {
                console.error(data.message);
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    document.querySelectorAll('.knopka').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const form = this.closest('form');
            const flightId = form.querySelector('input[name="flightId"]').value;
            const numPlaces = form.querySelector('input[name="numPlaces"]').value;
            console.log('Flight ID:', flightId);
            console.log('Num Places:', numPlaces);

            if (!numPlaces) {
                alert('Пожалуйста, выберите количество мест.');
                return;
            }

            const modal = document.getElementById('lalka');
            modal.setAttribute('data-flight-id', flightId);
            modal.setAttribute('data-num-places', numPlaces);

            modal.showModal();

            // Загрузка данных о занятых местах при открытии модального окна
            loadSeatsData(flightId);
        });
    });

    document.getElementById('confirmbtn').addEventListener('click', function() {
        const modal = document.getElementById('lalka');
        const flightId = modal.getAttribute('data-flight-id');
        const numPlaces = parseInt(modal.getAttribute('data-num-places'), 10);
        const checkboxes = document.querySelectorAll('.lalka-btn');
        const selectedSeats = Array.from(checkboxes).filter(checkbox => checkbox.checked && !checkbox.disabled).map(checkbox => checkbox.value);

        console.log('Flight ID:', flightId);
        console.log('Selected Seats:', selectedSeats);

        if (selectedSeats.length === 0) {
            alert('Пожалуйста, выберите хотя бы одно место.');
            return;
        }

        if (isNaN(numPlaces) || numPlaces === null || numPlaces === 0) {
            alert('Количество мест указано неверно.');
            return;
        }

        if (selectedSeats.length > numPlaces) {
            alert(`Вы можете выбрать не более ${numPlaces} мест.`);
            return;
        }

        fetch('save_seats.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                flightId: flightId,
                selectedSeats: selectedSeats
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Преобразуем ответ в JSON
        })
        .then(data => {
            console.log('Parsed Data:', data);
            if (data.success) {
                alert('Места успешно забронированы!');
            } else {
                alert('Ошибка при сохранении мест: ' + data.message);
            }
            modal.close();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    document.querySelector('.cancelbtn').addEventListener('click', function () {
        const modal = document.getElementById('lalka');
        modal.close();
    });
});
function loadUsers() {
    fetch('ws/api/users')
        .then(response => response.json())
        .then(users => {
            const list = document.getElementById('user-list');
            list.innerHTML = '';
            users.forEach(user => {
                const li = document.createElement('li');
                li.textContent = user.name;
                list.appendChild(li);
            });
        })
        .catch(error => console.error('Erreur AJAX:', error));
}

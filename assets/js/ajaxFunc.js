const apiBase = "http://localhost/exam_s4/ws";

function ajax(method, url, data, successCallback, errorCallback) {
    const xhr = new XMLHttpRequest();
    xhr.open(method, apiBase + url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    // Vérifie si la réponse est vide avant de parser
                    const responseText = xhr.responseText.trim();
                    if (!responseText) {
                        throw new Error('Réponse vide du serveur');
                    }
                    const data = JSON.parse(responseText);
                    successCallback(data);
                } catch (e) {
                    console.error('Erreur de parsing JSON:', e, 'Réponse brute:', xhr.responseText);
                    if (errorCallback) {
                        errorCallback({
                            status: xhr.status,
                            message: 'Réponse serveur invalide',
                            rawResponse: xhr.responseText
                        });
                    }
                }
            } else {
                if (errorCallback) {
                    errorCallback({
                        status: xhr.status,
                        message: xhr.statusText,
                        rawResponse: xhr.responseText
                    });
                }
            }
        }
    };

    xhr.onerror = function() {
        if (errorCallback) {
            errorCallback({
                status: 0,
                message: 'Erreur réseau',
                rawResponse: null
            });
        }
    };

    xhr.send(data ? JSON.stringify(data) : null);
}
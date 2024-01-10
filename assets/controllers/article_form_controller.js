import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['title', 'description', 'body', 'response'];

    submit(event) {
        event.preventDefault();

        const data = {
            title: this.titleTarget.value,
            description: this.descriptionTarget.value,
            body: this.bodyTarget.value
        };

        fetch('http://127.0.0.1:8001/api/articles', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            this.responseTarget.innerText = 'Article créé avec succès!';
            setTimeout(() => {
                window.location.href = '/'; 
            }, 1000);
        })
        .catch(error => {
            console.error('Error:', error);
            this.responseTarget.innerText = 'Erreur lors de la création de l\'article';
            // Additional error handling
        });
    }
}

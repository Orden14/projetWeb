import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['id', 'title', 'description', 'body', 'response'];

    submit(event) {
        event.preventDefault();

        const data = {
            title: this.titleTarget.value,
            description: this.descriptionTarget.value,
            body: this.bodyTarget.value
        };

        fetch(`http://127.0.0.1:8001/api/articles/${this.idTarget.value}`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/merge-patch+json' },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(() => {
            this.responseTarget.innerText = 'Article mis à jour avec succès!';
            setTimeout(() => {
                window.location.href = '/show'; 
            }, 1000);
        })
        .catch(error => {
            this.responseTarget.innerText = 'Erreur lors de la mise à jour de l\'article';
        });
    }
}

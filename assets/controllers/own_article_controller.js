import { Controller } from '@hotwired/stimulus'
import { formatDate } from '../utils/dateFormatterUtil';

export default class extends Controller {
    static targets = ["form", "title", "description", "body", "response"]
    static values = { currentUsername: String }
    static idValue = { articleId: Number };
    
    connect() {
        this.loadArticles();
    }

    loadArticles() {
        const apiEndpoint = `http://127.0.0.1:8001/api/articles?page=1&user.username=${this.currentUsernameValue}`;

        fetch(apiEndpoint)
            .then(response => response.json())
            .then(articles => {
                const articlesDiv = document.getElementById('articlesContainer');
                let html = '<div class="row gx-3 gx-lg-3 row-cols-3 row-cols-md-3 row-cols-xl-3 justify-content-center">';

                if (articles.length !== 0) {
                    articles.forEach(article => {
                        html += this.buildArticleCard(article);
                    });
                } else {
                    html += '<p class="text-center">Aucun article publié pour le moment.</p>';
                }

                html += '</div>';
                articlesDiv.innerHTML = html;
            });
        }

    buildArticleCard(article) {
        let formattedDate = formatDate(article);
        const body = article.body.length > 450 ? article.body.substring(0, 450) + ' ...' : article.body;

        return `
            <div class="col mb-5">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <p class="h5 text-justify">${article.title}</p>
                        </div>
                        <div><em>
                            <p>Auteur : ${article.user.username} <br>
                            ${formattedDate}
                            <br></em>
                            <p class="text-justify">${body}</p>
                        </div>
                    </div>
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent text-center">
                        <a class="btn btn-outline-danger mt-auto" href="http://127.0.0.1:8001/show" data-action="click->own-article#deleteArticle" 
                        data-article-id="${article.id }"> Supprimer </a>
                        <a class="btn btn-outline-info mt-auto" href="/edit/${article.id}" 
                        data-article-id="${article.id}">Modifier</a>
                     
                    </div>
                </div>
            </div>
        `;
    }

    deleteArticle(event) {
        const articleId = event.currentTarget.getAttribute('data-article-id');
        event.preventDefault()
        $.confirm({
            icon: 'bi bi-exclamation-triangle-fill',
            title: 'Attention !',
            content: 'Êtes-vous sûr de vouloir procéder à la suppression ?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                confirm: {
                    text: 'Confirmer',
                    action: () => {
                        fetch(`/api/articles/${articleId}`, { method: 'DELETE' })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Error deleting article');
                                }
                                return response.json();
                            })
                            .then(data => {
                                event.currentTarget.closest('.article-container').remove();
                            })
                            .catch(error => console.error('Error:', error));
                        setTimeout(() => {
                            window.location.href = '/show'; 
                        }, 1000);
                    }
                },
                cancel: {
                    text: 'Annuler'
                }
            }
        })
    }
}
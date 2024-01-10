import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    initialize () {
        const apiEndpoint = 'http://127.0.0.1:8001/api/articles?page=1';

        fetch(apiEndpoint)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                return response.json();
            })
            .then(data => {
                const articlesDiv = document.getElementById('articlesContainer');

                // Start the row
                let html = '<div class="row gx-3 gx-lg-3 row-cols-3 row-cols-md-3 row-cols-xl-3 justify-content-center">';

                data.forEach(article => {
                    let date = new Date(article.publishedAt);
                    let day = date.getDate().toString().padStart(2, '0');
                    let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are 0-based
                    let year = date.getFullYear();
                    let hours = date.getHours().toString().padStart(2, '0');
                    let minutes = date.getMinutes().toString().padStart(2, '0');
                    let formattedDate = `Publié le ${day}/${month}/${year} à ${hours}h${minutes}`;

                    let body = article.body.length > 450 ? article.body.substring(0, 450) + ' ...' : article.body;

                    html += `
                        <div class="col mb-5">
                            <div class="card h-100">
                                <div class="card-body p-4">
                                    <div class=" text-center">
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
                                    <a class="btn btn-outline-dark mt-auto" href="#">Lire</a>
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += '</div>';
                articlesDiv.innerHTML = html;

            });

    }
}
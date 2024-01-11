const formatDate = (article) => { 
    let date = new Date(article.publishedAt);
    let day = date.getDate().toString().padStart(2, '0');
    let month = (date.getMonth() + 1).toString().padStart(2, '0');
    let year = date.getFullYear();
    let hours = date.getHours().toString().padStart(2, '0');
    let minutes = date.getMinutes().toString().padStart(2, '0');

    return `Publié le ${day}/${month}/${year} à ${hours}h${minutes}`;
}

export { formatDate };
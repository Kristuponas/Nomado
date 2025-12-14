const countPerPage = 10;
let currentPage = 0;

document.getElementById('page-forward-button').addEventListener('click', function (e) {
  e.preventDefault();
  
  const url = `/api/comments.php?count=${countPerPage}&offset=${currentPage * countPerPage}`;
  
  fetch(url)
    .then(response => response.json())
    .then(data => {
	console.log(data);
        renderComments(data);
    })
    .catch(error => console.error('Fetch error:', error));

  currentPage++;
});

function renderComments(comments) {
  const container = document.getElementById('comment-container');
  container.innerHTML = '';

    console.log(comments);

  comments.forEach(comment => {
    const p = document.createElement('p');
    p.className = 'amenity-text';
    p.textContent = `${comment.fk_Vartotojas}: ${comment.turinys}`;
    container.appendChild(p);
  });
}

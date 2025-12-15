const countPerPage = 3;
let currentPage = 0;

urlParams = new URLSearchParams(window.location.search);
const hotelID = urlParams.get('hotel_id');

const forwardBtn = document.getElementById('page-forward-button');
const backBtn = document.getElementById('page-back-button');

//initial load 
loadComments();

forwardBtn.addEventListener('click', function (e) {
  e.preventDefault();
  currentPage++;
  loadComments();
});

backBtn.addEventListener('click', function (e) {
  e.preventDefault();

  if (currentPage === 0) return;

  currentPage--;
  loadComments();
});

function loadComments() {
  const offset = currentPage * countPerPage;
  const url = `/api/comments.php?count=${countPerPage}&offset=${offset}&hotel_id=${hotelID}`;

  fetch(url)
    .then(response => response.json())
    .then(data => {
      renderComments(data['result']);
      updateButtons(data['count']);
    })
    .catch(error => console.error('Fetch error:', error));
}

function renderComments(comments) {
  const container = document.getElementById('comment-container');
  container.innerHTML = '';

  comments.forEach(comment => {
    const commentDiv = document.createElement('div');
    commentDiv.className = 'comment';

    const userDiv = document.createElement('div');
    userDiv.className = 'comment-user';
    userDiv.textContent = comment.vartotojo_vardas;

    const textDiv = document.createElement('div');
    textDiv.className = 'comment-text';
    textDiv.textContent = comment.turinys;

    const starsDiv = document.createElement('div');
    starsDiv.className = 'comment-stars';
    starsDiv.innerHTML = generateStars(comment.bendras);

    commentDiv.appendChild(userDiv);
    commentDiv.appendChild(starsDiv);
    commentDiv.appendChild(textDiv);
    container.appendChild(commentDiv);
  });
}

function updateButtons(commentCount) {
  backBtn.disabled = currentPage === 0;
  forwardBtn.disabled = (currentPage + 1) * countPerPage >= commentCount;
}

function generateStars(rating) {
    rating = rating / 2;
    const fullStars = Math.floor(rating);
    const halfStar = rating % 1 >= 0.5 ? 1 : 0;
    const emptyStars = 5 - fullStars - halfStar;

    let starsHTML = '';

    // full stars
    for (let i = 0; i < fullStars; i++) {
        starsHTML += `<svg class="star" viewBox="0 0 24 24"><path fill="#FFD700" d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.78 1.402 8.172L12 18.896l-7.336 3.866 1.402-8.172-5.934-5.78 8.2-1.192z"/></svg>`;
    }

    // half star
    if (halfStar) {
        starsHTML += `<svg class="star" viewBox="0 0 24 24">
            <defs>
                <linearGradient id="halfGrad">
                    <stop offset="50%" stop-color="#FFD700"/>
                    <stop offset="50%" stop-color="#e0e0e0"/>
                </linearGradient>
            </defs>
            <path fill="url(#halfGrad)" d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.78 1.402 8.172L12 18.896l-7.336 3.866 1.402-8.172-5.934-5.78 8.2-1.192z"/>
        </svg>`;
    }

    // empty stars
    for (let i = 0; i < emptyStars; i++) {
        starsHTML += `<svg class="star" viewBox="0 0 24 24"><path fill="#e0e0e0" d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.78 1.402 8.172L12 18.896l-7.336 3.866 1.402-8.172-5.934-5.78 8.2-1.192z"/></svg>`;
    }

    return starsHTML;
}

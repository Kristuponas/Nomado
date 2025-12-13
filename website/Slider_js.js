<script>
const slides = document.querySelectorAll('.slide');
const next = document.querySelector('.next');
const prev = document.querySelector('.prev');
let index = 0;

function showSlide(n) {
  slides.forEach(slide => slide.classList.remove('active'));
  index = (n + slides.length) % slides.length; // loops back
  slides[index].classList.add('active');
}

next.addEventListener('click', () => showSlide(index + 1));
prev.addEventListener('click', () => showSlide(index - 1));
</script>

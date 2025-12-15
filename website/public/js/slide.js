        // Slider functionality (same as before)
        const slides = document.querySelectorAll('.slide');
        let currentSlide = 0;

        document.querySelector('.next').addEventListener('click', () => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        });

        document.querySelector('.prev').addEventListener('click', () => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
        });

        // --- Image modal (click to expand) ---
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImg');
        const closeBtn = document.querySelector('.close');

        // Open modal when clicking an image
        document.querySelectorAll('.slider-image').forEach(img => {
            img.addEventListener('click', () => {
                modal.style.display = 'block';
                modalImg.src = img.src;
            });
        });

        // Close modal when clicking the ×
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Optional: close when clicking outside the image
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.style.display = 'none';
        });
